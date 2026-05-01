#!/usr/bin/env python3
"""Tải PDF từ URL vào storage/app/public/scriptures/pdf/ (Laravel)."""

from __future__ import annotations

import argparse
import ssl
import sys
import urllib.error
import urllib.request
from pathlib import Path


def main() -> int:
    parser = argparse.ArgumentParser(description="Download a PDF into Laravel public storage.")
    parser.add_argument("url", help="Direct HTTPS URL to the PDF")
    parser.add_argument(
        "--out",
        required=True,
        help="Relative path under storage/app/public/, e.g. scriptures/pdf/kinh-foo.pdf",
    )
    parser.add_argument(
        "--project-root",
        default=".",
        help="Laravel project root (directory containing storage/)",
    )
    parser.add_argument(
        "--insecure",
        action="store_true",
        help="Skip TLS certificate verification (macOS/Python without certs)",
    )
    args = parser.parse_args()

    root = Path(args.project_root).resolve()
    dest = root / "storage" / "app" / "public" / args.out.lstrip("/")
    dest.parent.mkdir(parents=True, exist_ok=True)

    req = urllib.request.Request(
        args.url,
        headers={"User-Agent": "Mozilla/5.0 (compatible; ThemKinhSkill/1.0)"},
    )
    ctx = None
    if args.insecure:
        ctx = ssl._create_unverified_context()

    try:
        with urllib.request.urlopen(req, timeout=120, context=ctx) as resp:
            _ = (resp.headers.get("Content-Type") or "").lower()
            data = resp.read()
    except urllib.error.HTTPError as e:
        print(f"HTTP {e.code}: {e.reason}", file=sys.stderr)
        return 1
    except urllib.error.URLError as e:
        print(f"URL error: {e.reason}", file=sys.stderr)
        return 1

    if not data.startswith(b"%PDF"):
        print("Warning: response does not start with %PDF; saving anyway.", file=sys.stderr)

    dest.write_bytes(data)
    print(dest)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
