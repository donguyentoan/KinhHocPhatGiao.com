---
name: tao-thumbnail
description: >-
  Tạo thumbnail hàng loạt bằng Python từ dữ liệu DB và template ảnh, rồi cập
  nhật lại image_url. Dùng khi người dùng nói tạo thumbnail, render ảnh theo
  tên trong DB, hoặc muốn tái sử dụng pipeline ảnh cho mục khác ngoài scriptures.
---

# Tạo thumbnail từ DB + template

## Mục tiêu

- Dùng script `scripts/generate_scripture_thumbnails.py` để tạo ảnh thumbnail từ tiêu đề trong DB.
- Hỗ trợ 3 mode:
  - `pil`: rẻ nhất, render text trực tiếp lên template.
  - `claude-svg`: gọi model text xuất SVG rồi convert PNG.
  - `openai`: dùng image edit API nếu endpoint hỗ trợ ảnh.
- Sau khi tạo ảnh, cập nhật cột `image_url` trong DB.

## Khi nào dùng skill này

- Người dùng nói: "tạo thumbnail", "update image_url", "dùng template ảnh này cho danh sách trong DB".
- Cần chạy batch cho nhiều bản ghi và có retry timeout.
- Cần tái dùng workflow ảnh cho chuyên mục khác (bài viết, pháp thoại, khóa tu, ...).

## Quy trình chuẩn

1. Xác nhận input:
   - `template` ảnh.
   - nguồn dữ liệu DB (`title` và `id` hoặc cột tương đương).
   - đích lưu ảnh và format URL public.
2. Chọn mode mặc định:
   - ưu tiên `claude-svg` khi endpoint chỉ có model text.
   - ưu tiên `pil` nếu cần tiết kiệm chi phí tuyệt đối và output ổn định.
3. Chạy test 1 bản ghi trước (`--title ... --dry-run` hoặc `--limit 1 --dry-run`).
4. Chạy full batch không `--dry-run` để update DB.
5. Báo lại số lượng đã xử lý, file output, và các record lỗi (nếu có).

## Lệnh mẫu (script hiện có trong repo)

### 1) Test nhanh 1 ảnh (claude-svg)

```bash
OPENAI_API_KEY="..." OPENAI_BASE_URL="https://.../v1" \
python3 scripts/generate_scripture_thumbnails.py \
  --mode claude-svg \
  --openai-base-url "https://.../v1" \
  --svg-model "claude-haiku-4.5" \
  --title "Kinh Đại Bảo Tích" \
  --dry-run
```

### 2) Chạy full và update DB (claude-svg + backoff)

```bash
OPENAI_API_KEY="..." OPENAI_BASE_URL="https://.../v1" \
DB_SOCKET="/path/to/mysqld.sock" DB_DATABASE="local" DB_USERNAME="root" DB_PASSWORD="root" \
python3 scripts/generate_scripture_thumbnails.py \
  --mode claude-svg \
  --openai-base-url "https://.../v1" \
  --svg-model "claude-haiku-4.5" \
  --timeout-backoff "2,4,6,8,10"
```

### 3) Mode rẻ nhất (PIL)

```bash
python3 scripts/generate_scripture_thumbnails.py \
  --mode pil \
  --font-path "/path/to/vietnamese-font.ttf"
```

## Tùy biến cho mục khác ngoài scriptures

- Nếu bảng khác không phải `scriptures`, sửa script theo hướng:
  - query: `SELECT id, title FROM <table>`
  - update: `UPDATE <table> SET image_url = %s WHERE id = %s`
  - `output-dir` và URL public theo module tương ứng.
- Luôn giữ các phần reusable:
  - retry timeout backoff (`2,4,6,8,10`),
  - hỗ trợ `DB_SOCKET`,
  - test trước khi chạy full.

## Checklist trước khi kết thúc

- [ ] Test 1 ảnh thành công.
- [ ] Full batch chạy `exit_code = 0`.
- [ ] DB đã cập nhật `image_url`.
- [ ] Người dùng được báo đường dẫn output và số record đã xử lý.
