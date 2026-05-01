#!/usr/bin/env python3
"""
Generate scripture thumbnails from DB titles using a template image.

Modes:
- pil: Cheapest and deterministic; overlays title text on template.
- openai: Uses OpenAI image edit model (set OPENAI_API_KEY).
- claude-svg: Uses text model to generate SVG, then converts to PNG.
"""

from __future__ import annotations

import argparse
import base64
import os
import re
import time
import sys
import unicodedata
from dataclasses import dataclass
from pathlib import Path
from typing import Iterable


@dataclass
class ScriptureRow:
    row_id: int
    title: str


def parse_env_file(env_path: Path) -> dict[str, str]:
    data: dict[str, str] = {}
    if not env_path.exists():
        return data
    for raw_line in env_path.read_text(encoding="utf-8").splitlines():
        line = raw_line.strip()
        if not line or line.startswith("#") or "=" not in line:
            continue
        key, value = line.split("=", 1)
        key = key.strip()
        value = value.strip().strip("'").strip('"')
        data[key] = value
    return data


def load_config(project_root: Path) -> dict[str, str]:
    env = parse_env_file(project_root / ".env")
    merged = dict(env)
    for key in list(env.keys()) + [
        "DB_HOST",
        "DB_PORT",
        "DB_DATABASE",
        "DB_USERNAME",
        "DB_PASSWORD",
        "DB_SOCKET",
        "OPENAI_API_KEY",
        "OPENAI_BASE_URL",
    ]:
        if os.getenv(key):
            merged[key] = os.getenv(key, "")
    return merged


def slugify(value: str) -> str:
    normalized = unicodedata.normalize("NFD", value)
    without_marks = "".join(ch for ch in normalized if unicodedata.category(ch) != "Mn")
    safe = re.sub(r"[^a-zA-Z0-9]+", "-", without_marks).strip("-").lower()
    return safe or "scripture"


def fetch_scriptures(config: dict[str, str], limit: int | None = None, scripture_id: int | None = None) -> list[ScriptureRow]:
    try:
        import pymysql
    except ImportError as exc:
        raise RuntimeError("Missing dependency: pymysql. Install with `pip install pymysql`.") from exc

    socket_path = config.get("DB_SOCKET", "").strip()
    connect_kwargs = {
        "user": config.get("DB_USERNAME", "root"),
        "password": config.get("DB_PASSWORD", ""),
        "database": config.get("DB_DATABASE", ""),
        "charset": "utf8mb4",
        "cursorclass": pymysql.cursors.DictCursor,
    }
    if socket_path:
        connect_kwargs["unix_socket"] = socket_path
    else:
        connect_kwargs["host"] = config.get("DB_HOST", "127.0.0.1")
        connect_kwargs["port"] = int(config.get("DB_PORT", "3306"))
    conn = pymysql.connect(**connect_kwargs)
    try:
        with conn.cursor() as cur:
            sql = "SELECT id, title FROM scriptures"
            params: list[object] = []
            clauses: list[str] = []
            if scripture_id is not None:
                clauses.append("id = %s")
                params.append(scripture_id)
            if clauses:
                sql += " WHERE " + " AND ".join(clauses)
            sql += " ORDER BY id ASC"
            if limit is not None:
                sql += " LIMIT %s"
                params.append(limit)

            cur.execute(sql, params)
            rows = cur.fetchall()
    finally:
        conn.close()

    return [ScriptureRow(row_id=row["id"], title=row["title"]) for row in rows]


def update_scripture_image(config: dict[str, str], row_id: int, image_url: str) -> None:
    try:
        import pymysql
    except ImportError as exc:
        raise RuntimeError("Missing dependency: pymysql. Install with `pip install pymysql`.") from exc

    socket_path = config.get("DB_SOCKET", "").strip()
    connect_kwargs = {
        "user": config.get("DB_USERNAME", "root"),
        "password": config.get("DB_PASSWORD", ""),
        "database": config.get("DB_DATABASE", ""),
        "charset": "utf8mb4",
    }
    if socket_path:
        connect_kwargs["unix_socket"] = socket_path
    else:
        connect_kwargs["host"] = config.get("DB_HOST", "127.0.0.1")
        connect_kwargs["port"] = int(config.get("DB_PORT", "3306"))
    conn = pymysql.connect(**connect_kwargs)
    try:
        with conn.cursor() as cur:
            cur.execute("UPDATE scriptures SET image_url = %s WHERE id = %s", (image_url, row_id))
        conn.commit()
    finally:
        conn.close()


def wrap_text_for_width(draw, text: str, font, max_width: int) -> str:
    words = text.split()
    lines: list[str] = []
    current: list[str] = []
    for word in words:
        test_line = " ".join(current + [word]).strip()
        left, _, right, _ = draw.textbbox((0, 0), test_line, font=font)
        if (right - left) <= max_width or not current:
            current.append(word)
        else:
            lines.append(" ".join(current))
            current = [word]
    if current:
        lines.append(" ".join(current))
    return "\n".join(lines)


def render_with_pil(
    template_path: Path,
    output_path: Path,
    title: str,
    font_path: Path | None,
    title_color: tuple[int, int, int] = (152, 21, 23),
) -> None:
    try:
        from PIL import Image, ImageDraw, ImageFont
    except ImportError as exc:
        raise RuntimeError("Missing dependency: pillow. Install with `pip install pillow`.") from exc

    image = Image.open(template_path).convert("RGBA")
    draw = ImageDraw.Draw(image)
    width, height = image.size
    max_text_width = int(width * 0.78)

    preferred_sizes: Iterable[int] = range(int(height * 0.16), int(height * 0.08), -2)
    selected_font = None
    selected_wrapped = None
    selected_bbox = None

    for font_size in preferred_sizes:
        if font_path and font_path.exists():
            font = ImageFont.truetype(str(font_path), font_size)
        else:
            font = ImageFont.load_default()

        wrapped = wrap_text_for_width(draw, title, font, max_text_width)
        bbox = draw.multiline_textbbox((0, 0), wrapped, font=font, align="center", spacing=max(8, font_size // 5))
        text_width = bbox[2] - bbox[0]
        text_height = bbox[3] - bbox[1]
        if text_width <= max_text_width and text_height <= int(height * 0.45):
            selected_font = font
            selected_wrapped = wrapped
            selected_bbox = bbox
            break

    if selected_font is None or selected_wrapped is None or selected_bbox is None:
        raise RuntimeError(f"Cannot fit title into template: {title}")

    text_width = selected_bbox[2] - selected_bbox[0]
    text_height = selected_bbox[3] - selected_bbox[1]
    x = (width - text_width) / 2
    y = (height - text_height) / 2

    # Simple shadow for readability on bright yellow background.
    draw.multiline_text(
        (x + 2, y + 2),
        selected_wrapped,
        font=selected_font,
        fill=(90, 12, 12),
        align="center",
        spacing=max(8, selected_font.size // 5),
    )
    draw.multiline_text(
        (x, y),
        selected_wrapped,
        font=selected_font,
        fill=title_color,
        align="center",
        spacing=max(8, selected_font.size // 5),
    )

    output_path.parent.mkdir(parents=True, exist_ok=True)
    image.convert("RGB").save(output_path, quality=95)


def render_with_openai(
    template_path: Path,
    output_path: Path,
    title: str,
    api_key: str,
    model: str,
    base_url: str | None = None,
) -> None:
    try:
        from openai import OpenAI
    except ImportError as exc:
        raise RuntimeError("Missing dependency: openai. Install with `pip install openai`.") from exc

    client_kwargs = {"api_key": api_key}
    if base_url:
        client_kwargs["base_url"] = base_url
    client = OpenAI(**client_kwargs)
    prompt = (
        "Keep the exact same yellow poster design and cloud decorations. "
        "Replace only the existing red calligraphy text with this Vietnamese title: "
        f'"{title}". '
        "Center the title similarly, in artistic red calligraphy, readable and elegant. "
        "Do not add extra elements."
    )

    with template_path.open("rb") as image_file:
        result = client.images.edit(
            model=model,
            image=image_file,
            prompt=prompt,
            size="1024x1024",
            quality="low",
        )
    b64_data = result.data[0].b64_json
    if not b64_data:
        raise RuntimeError("OpenAI response did not include image bytes.")

    output_path.parent.mkdir(parents=True, exist_ok=True)
    output_path.write_bytes(base64.b64decode(b64_data))


def extract_svg(text: str) -> str:
    match = re.search(r"<svg[\s\S]*?</svg>", text, re.IGNORECASE)
    if not match:
        raise RuntimeError("Model response does not contain a valid <svg>...</svg> block.")
    return match.group(0)


def sanitize_svg(svg_text: str) -> str:
    cleaned = svg_text
    # Strip markdown fences if model still wraps output.
    cleaned = cleaned.replace("```svg", "").replace("```xml", "").replace("```", "").strip()
    # Remove unsupported or unsafe blocks that commonly break SVG parsing.
    cleaned = re.sub(r"<style[\s\S]*?</style>", "", cleaned, flags=re.IGNORECASE)
    cleaned = re.sub(r"<script[\s\S]*?</script>", "", cleaned, flags=re.IGNORECASE)
    cleaned = re.sub(r"<foreignObject[\s\S]*?</foreignObject>", "", cleaned, flags=re.IGNORECASE)
    cleaned = re.sub(r"@\s*import[\s\S]*?;", "", cleaned, flags=re.IGNORECASE)
    return cleaned


def run_with_backoff(fn, backoff_seconds: list[int], context: str):
    last_error = None
    total_attempts = len(backoff_seconds) + 1
    for attempt in range(1, total_attempts + 1):
        try:
            return fn()
        except Exception as exc:  # noqa: BLE001
            message = str(exc).lower()
            is_timeout = "timeout" in message or "timed out" in message
            if not is_timeout:
                raise
            last_error = exc
            if attempt == total_attempts:
                break
            sleep_seconds = backoff_seconds[attempt - 1]
            print(
                f"[WARN] Timeout in {context} (attempt {attempt}/{total_attempts}). "
                f"Retrying after {sleep_seconds}s..."
            )
            time.sleep(sleep_seconds)
    if last_error:
        raise RuntimeError(f"Timeout after {total_attempts} attempts in {context}") from last_error
    raise RuntimeError(f"Unknown retry failure in {context}")


def render_with_claude_svg(
    output_path: Path,
    title: str,
    api_key: str,
    model: str,
    base_url: str,
    backoff_seconds: list[int],
) -> None:
    try:
        from openai import OpenAI
    except ImportError as exc:
        raise RuntimeError("Missing dependency: openai. Install with `pip install openai`.") from exc
    try:
        import cairosvg
    except ImportError as exc:
        raise RuntimeError("Missing dependency: cairosvg. Install with `pip install cairosvg`.") from exc

    client = OpenAI(api_key=api_key, base_url=base_url)
    prompt = (
        "Output only valid SVG XML, no markdown, no explanation. "
        "Create a 1024x640 thumbnail background in bright yellow with subtle cloud ornaments near corners "
        "and soft bottom wave accents. Add center-aligned Vietnamese calligraphy-like red text for this title: "
        f"'{title}'. "
        "Use UTF-8 safe text rendering. Keep style elegant and highly readable. "
        "Do not include external images, scripts, CSS, @import, or web fonts. "
        "Do not use <style> tag. Use only inline SVG attributes."
    )
    completion = run_with_backoff(
        lambda: client.chat.completions.create(
            model=model,
            messages=[
                {"role": "system", "content": "You are an SVG designer. Return only raw SVG content."},
                {"role": "user", "content": prompt},
            ],
            temperature=0.2,
        ),
        backoff_seconds=backoff_seconds,
        context=f"claude-svg title='{title}'",
    )
    content = completion.choices[0].message.content or ""
    svg_text = sanitize_svg(extract_svg(content))

    output_path.parent.mkdir(parents=True, exist_ok=True)
    cairosvg.svg2png(bytestring=svg_text.encode("utf-8"), write_to=str(output_path))


def build_parser() -> argparse.ArgumentParser:
    parser = argparse.ArgumentParser(description="Generate scripture thumbnails from scripture titles in DB.")
    parser.add_argument("--project-root", default=".", help="Laravel project root containing .env")
    parser.add_argument(
        "--template",
        default="IMG/14e60448-391d-49d4-ade0-f7c2d4e12528.png",
        help="Template image path",
    )
    parser.add_argument(
        "--output-dir",
        default="storage/app/public/scriptures/thumbnails",
        help="Output directory for generated thumbnails",
    )
    parser.add_argument("--font-path", default="", help="Font path for PIL mode (Vietnamese-capable font recommended)")
    parser.add_argument("--limit", type=int, default=None, help="Limit number of scriptures")
    parser.add_argument("--scripture-id", type=int, default=None, help="Generate only one scripture ID")
    parser.add_argument("--title", default="", help="Generate a single thumbnail from a direct title (skip DB read)")
    parser.add_argument(
        "--mode",
        choices=["pil", "openai", "claude-svg"],
        default="pil",
        help="Thumbnail generation mode",
    )
    parser.add_argument("--openai-model", default="gpt-image-1", help="OpenAI image model for openai mode")
    parser.add_argument("--svg-model", default="claude-haiku-4.5", help="Text model used for claude-svg mode")
    parser.add_argument("--openai-base-url", default="", help="Custom OpenAI-compatible base URL")
    parser.add_argument(
        "--timeout-backoff",
        default="2,4,6,8,10",
        help="Retry wait seconds for timeout errors (comma-separated)",
    )
    parser.add_argument("--dry-run", action="store_true", help="Generate files without updating DB image_url")
    return parser


def main() -> int:
    args = build_parser().parse_args()
    project_root = Path(args.project_root).resolve()
    template_path = (project_root / args.template).resolve()
    output_dir = (project_root / args.output_dir).resolve()
    font_path = Path(args.font_path).resolve() if args.font_path else None

    if not template_path.exists():
        print(f"[ERROR] Template not found: {template_path}", file=sys.stderr)
        return 2

    config = load_config(project_root)
    if args.title.strip():
        rows = [ScriptureRow(row_id=0, title=args.title.strip())]
    else:
        rows = fetch_scriptures(config=config, limit=args.limit, scripture_id=args.scripture_id)
    if not rows:
        print("[INFO] No scriptures found.")
        return 0

    api_key = config.get("OPENAI_API_KEY", "")
    base_url = args.openai_base_url or config.get("OPENAI_BASE_URL", "")
    backoff_seconds = [int(chunk.strip()) for chunk in args.timeout_backoff.split(",") if chunk.strip()]
    if args.mode == "openai" and not api_key:
        print("[ERROR] OPENAI_API_KEY is required for --mode openai.", file=sys.stderr)
        return 2
    if args.mode == "claude-svg" and (not api_key or not base_url):
        print("[ERROR] OPENAI_API_KEY and OPENAI_BASE_URL are required for --mode claude-svg.", file=sys.stderr)
        return 2

    print(f"[INFO] Found {len(rows)} scriptures. Mode: {args.mode}")

    for row in rows:
        filename = f"{row.row_id:04d}-{slugify(row.title)}.png"
        output_path = output_dir / filename

        if args.mode == "pil":
            render_with_pil(
                template_path=template_path,
                output_path=output_path,
                title=row.title,
                font_path=font_path,
            )
        elif args.mode == "openai":
            render_with_openai(
                template_path=template_path,
                output_path=output_path,
                title=row.title,
                api_key=api_key,
                model=args.openai_model,
                base_url=base_url or None,
            )
        else:
            render_with_claude_svg(
                output_path=output_path,
                title=row.title,
                api_key=api_key,
                model=args.svg_model,
                base_url=base_url,
                backoff_seconds=backoff_seconds,
            )

        public_url = f"/storage/scriptures/thumbnails/{filename}"
        if not args.dry_run and row.row_id > 0:
            update_scripture_image(config=config, row_id=row.row_id, image_url=public_url)
        print(f"[OK] id={row.row_id} title='{row.title}' -> {public_url}")

    print("[DONE] Thumbnail generation completed.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
