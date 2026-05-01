-- Gộp các bản ghi "Kinh Địa Tạng — Phẩm …" thành một quyển.
-- Đường dẫn PDF trong DB: scriptures/kinh-dia-tang-bo-tat-bon-nguyen.pdf
-- (file thật: storage/app/public/scriptures/kinh-dia-tang-bo-tat-bon-nguyen.pdf)
--
-- MySQL / MariaDB:
DELETE FROM scriptures WHERE title LIKE 'Kinh Địa Tạng — Phẩm %';

DELETE FROM scriptures
WHERE title = 'Kinh Địa Tạng Bồ Tát Bổn Nguyện';

INSERT INTO scriptures (
  title, summary, content_text, content_file_path,
  duration_minutes, chant_count, image_url, reader_mode,
  category_id, created_at, updated_at
)
SELECT
  'Kinh Địa Tạng Bồ Tát Bổn Nguyện',
  'Toàn bộ kinh (một quyển PDF).',
  NULL,
  'scriptures/kinh-dia-tang-bo-tat-bon-nguyen.pdf',
  45,
  0,
  'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=500',
  'pdf',
  id,
  NOW(),
  NOW()
FROM scripture_categories
WHERE name = 'Kinh Địa Tạng'
LIMIT 1;

-- SQLite (php artisan db:show / .env DB_CONNECTION=sqlite): dùng datetime thay NOW():
-- DELETE FROM scriptures WHERE title LIKE 'Kinh Địa Tạng — Phẩm %';
-- DELETE FROM scriptures WHERE title = 'Kinh Địa Tạng Bồ Tát Bổn Nguyện';
-- INSERT INTO scriptures (...)
-- SELECT ..., datetime('now'), datetime('now') FROM scripture_categories WHERE name = 'Kinh Địa Tạng' LIMIT 1;
