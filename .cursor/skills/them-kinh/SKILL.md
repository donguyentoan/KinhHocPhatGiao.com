---
name: them-kinh
description: >-
  Thêm bài kinh vào Laravel: tìm PDF trên mạng, tải bằng Python vào
  storage/app/public/scriptures/pdf/, tạo Database Seeder chèn bảng scriptures
  (title, summary, content_file_path, reader_mode, category_id, …). Dùng khi
  người dùng nói thêm kinh, seed kinh, PDF kinh, hoặc gọi skill them-kinh.
---

# Thêm kinh (scriptures + PDF)

## Ngữ cảnh dự án (kinhhocphatgiaocom)

- Model: `App\Models\Scripture` — các cột quan trọng: `title`, `summary`, `content_text`, `content_file_path`, `duration_minutes`, `chant_count`, `image_url`, `reader_mode` (`auto`|`pdf`|`content`), `category_id`.
- File PDF: lưu dưới `storage/app/public/scriptures/`; giá trị DB là đường dẫn tương đối kiểu `scriptures/ten-file.pdf` (không có tiền tố `public/`).
- `ScriptureReaderController` phục vụ PDF khi `content_file_path` kết thúc bằng `.pdf` và `reader_mode` phù hợp.
- Danh mục mẫu: `BuddhistContentSeeder` đã tạo `ScriptureCategory` gồm **Kinh Địa Tạng**, **Hệ Thống Kinh**, v.v.

## Quy trình

1. **Nhận tên kinh** từ người dùng (ví dụ: "Kinh Địa Tạng", "Kinh A Di Đà").
2. **Tìm URL PDF trực tiếp** (web search / trang chùa, thư viện Hoa Sen, đạo tràng — ưu tiên nguồn công khai, không Scribd/login). Xác nhận link trả về `application/pdf` hoặc file bắt đầu bằng `%PDF`.
3. **Tải file**:
   - Chạy script có sẵn từ thư mục skill:

   ```bash
   python3 .cursor/skills/them-kinh/scripts/download_pdf.py "URL_PDF" \
     --out scriptures/pdf/slug-ten-file.pdf \
     --project-root .
   ```

   Nếu gặp lỗi SSL trên macOS: thêm `--insecure` vào lệnh trên (chỉ khi tin cậy URL).

   - Hoặc `curl -fsSL -o storage/app/public/scriptures/pdf/slug.pdf "URL"` nếu phù hợp.
4. **Seeder**:
   - Tạo class trong `database/seeders/` (ví dụ `TenKinhSeeder.php`).
   - Lấy `category_id`: `ScriptureCategory::query()->where('name', '...')->value('id')` hoặc `firstOrCreate` nếu cần danh mục mới.
   - `insert` / `upsert` / `updateOrCreate` theo `title` để chạy lại seeder không trùng lặp vô hạn.
   - Đặt `reader_mode` => `'pdf'` khi nguồn chính là PDF.
5. **Đăng ký** trong `DatabaseSeeder` nếu người dùng muốn seed mặc định; nếu không, hướng dẫn: `php artisan db:seed --class=TenKinhSeeder`.
6. **Kiểm tra**: `php artisan db:seed --class=...` và mở route đọc kinh `/scriptures/{id}/read` (sau khi có id).

## Nhiều phẩm / chương

- Nếu một bộ kinh có nhiều phẩm và chỉ có **một file PDF toàn kinh**: có thể tạo **nhiều bản ghi** `scriptures` (mỗi phẩm một `title`), cùng `content_file_path` — người đọc vẫn mở cùng PDF; có thể bổ sung `summary` ghi rõ phạm vi phẩm.
- Nếu tìm được **PDF từng phẩm**: mỗi bản ghi trỏ một file riêng (UX tốt hơn).
- Có thể kết hợp `content_text` (trích đoạn) + PDF đầy đủ tùy nội dung có sẵn.

## Bản quyền & an toàn

- Chỉ dùng nguồn cho phép tái phân phối / công khai rõ ràng.
- Không nhúng credential; không tải từ trang cần đăng nhập trừ khi người dùng cung cấp cách hợp pháp.

## Tham chiếu trong repo

- Seeder mẫu một quyển: `database/seeders/DiaTangKinhSeeder.php`. SQL gộp phẩm: `database/sql/merge_kinh_dia_tang_one_volume.sql`.
