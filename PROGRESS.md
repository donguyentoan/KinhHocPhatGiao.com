# PROGRESS

Updated: 2026-05-17 (session: reader, header, email, máy niệm Phật, PWA tải app)

## Session 2026-05-17 — Hoàn thành

### Đọc kinh (`reader.blade.php`)

- Tối ưu lật trang booklet: tăng tốc animation (`easeOutCubic`, ~500ms), GPU `backface-visibility`, hoãn prefetch PDF (`schedulePrioritizePages`), bỏ overlay loading khi chuyển trang.
- Thử virtual reader / thanh điều hướng cố định trên mobile — sau đó **khôi phục mobile về bản gốc** theo yêu cầu (giữ `book-nav` trên/dưới, `syncMobileSlide()`).
- Desktop: giữ cải tiến booklet; mobile: hành vi như trước khi thử nghiệm.

### Header & UI

- **Tên dài trong header:** mobile chỉ hiện icon user; hover/active hiện tooltip đầy đủ «Xin chào, {tên}»; desktop (≥640px) vẫn hiện đủ chữ.
- **`donate-link.blade.php`:** mobile icon only, chữ từ `sm` trở lên.

### Email liên hệ

- Thống nhất email **`thienhoangbao15102003@gmail.com`** (qua `SITE_CONTACT_EMAIL` / mặc định):
  - `config/site.php`, `config/mail.php`
  - `site-footer.blade.php`, `lien-he-ho-tro.blade.php`
  - `.env`, `.env.example`
  - `Kinh Học Phật Giáo/index.html`
- *Lưu ý:* `local.sql` / nội dung DB cũ có thể còn email bên thứ ba — chưa đổi hàng loạt trong DB.

### Máy niệm Phật (`may-niem-phat.blade.php` + `public/audio/may-niem-phat/`)

- Toàn bộ **7 câu** dùng giọng **Thầy Thích Trí Thoát** (trích YouTube), không còn TTS.
- File âm thanh:

| Câu | Clip (một lần) | Loop (~90s, niệm liên tục) | Nguồn YouTube |
|-----|------------------|----------------------------|---------------|
| Niệm Nam Mô A Di Đà Phật (6 chữ) | `02-nam-mo-a-di-da-phat.mp3` | `02-nam-mo-a-di-da-phat-loop.mp3` | `5Wg0Vs-OziA` |
| Thích Ca | `03-nam-mo-thich-ca.mp3` | `03-nam-mo-thich-ca-loop.mp3` | `0pwcc-VuxqI` |
| Quan Thế Âm | `04-nam-mo-quan-the-am.mp3` | `04-nam-mo-quan-the-am-loop.mp3` | `mkYHkQ-fVdk` |
| Đại Thế Chí | `05-nam-mo-dai-the-chi.mp3` | `05-nam-mo-dai-the-chi-loop.mp3` | `5qNcy2pfHkw` |
| Địa Tạng | `06-nam-mo-dia-tang.mp3` | `06-nam-mo-dia-tang-loop.mp3` | `MyMM5oipY4Y` |
| Dược Sư | `07-nam-mo-duoc-su.mp3` | `07-nam-mo-duoc-su-loop.mp3` | `8ATJPhWdfGk` |

- Tạo clip/loop bằng `yt_dlp` + `ffmpeg` (imageio_ffmpeg). File `00-nam-mo-6-chu-tri-thoat-loop.mp3` vẫn tồn tại (dùng khi cắt ban đầu).
- **UI hiện tại:** lưới 6 câu (user đã bỏ dòng «Niệm A Di Đà Phật» riêng); mỗi nút phát **file loop** với `audio.loop = true`; bấm lại để dừng; bấm câu khác dừng bản đang phát.
- Đã bỏ khối «Niệm lặp liên tục» riêng (dropdown + Phát/Dừng toàn trang).
- Copy trang: «Chọn câu niệm bên dưới. Bấm một lần để bắt đầu, bấm lại để dừng.» — không còn dòng phụ «Thầy Thích Trí Thoát · niệm liên tục».

### Trang chủ — Phần ứng dụng Thiện Hoàng Bảo

- **Bỏ** nút Google Play / App Store (mockup app section).
- **Bỏ** banner tự bật `pwa-install-banner` trên layout trang chủ (`layouts/home.blade.php`) — không popup khi vào trang chủ.
- **Thêm** nút **«Tải ứng dụng»** → mở popup hướng dẫn **Thêm vào Màn hình chính** (`components/pwa-install-modal.blade.php`):
  - Hướng dẫn iOS (Safari), Android (Chrome), máy tính (Chrome/Edge).
  - Android: nút **«Cài đặt ngay»** nếu có `beforeinstallprompt`.
  - Đóng: X, «Đã hiểu», click nền, Esc.
  - Nút ẩn nếu đã mở ở chế độ standalone (đã cài PWA).
- Banner `pwa-install-banner` vẫn có trên **tool**, **dashboard**, **reader** (không tự bật trên home).

## Done

- Fixed missing dashboard icons by replacing dynamic Lucide runtime rendering with static SVG/component-based icons in dashboard UI.
- Implemented image upload previews in dashboard forms (scripture/post) with persistent local preview behavior across Livewire rerenders.
- Added robust PDF reading pipeline for scripture reader:
  - Booklet mode can render PDF pages via `pdf.js` (page-by-page into booklet pages).
  - Multi-CDN fallback loader for `pdf.js` script sources.
  - Text fallback when PDF rendering fails.
- Fixed PDF 404 access issue by adding dedicated server-side PDF stream route:
  - Route: `scriptures.pdf`
  - Controller method resolves file paths from storage and serves PDF inline.
- Added per-scripture reading mode setting in dashboard:
  - `auto` (prefer PDF if available)
  - `pdf` (force PDF mode)
  - `content` (force text/content mode)
- Wired reading mode end-to-end:
  - Migration added new `scriptures.reader_mode` column.
  - `Scripture` model updated (`fillable`).
  - `DashboardPage` save/edit/reset/validate updated.
  - Scripture modal UI updated with select field for reading mode.
  - `ScriptureReaderController` now respects selected mode.
- Restored/adjusted multiple reader UI regressions during iterations (book size, render behavior, fallback behavior).
- Integrated 8 tiện ích Phật giáo end-to-end:
  - Routes `GET /tien-ich/{slug}` (`tools.show`) + `ToolsController`.
  - Trang: máy niệm Phật, ngồi thiền (bấm giờ), chuông mõ (Web Audio), lần chuỗi hạt, nhạc thiền (iframe), sự kiện trong năm, liên hệ hỗ trợ; **Đọc kinh** trỏ neo `#thu-vien-kinh-dien` trên trang chủ.
  - Cột `utilities.link_url`, lưới tiện ích clickable, nav/footer/header đồng bộ.
  - Dashboard: modal thêm/sửa tiện ích (trước đó thiếu UI modal).
- Production-ready SEO crawling (`/robots.txt`, `/sitemap.xml`):
  - Dynamic routes `seo.robots`, `seo.sitemap`; removed static `public/robots.txt`.
  - `config/seo.php`: indexing toggle, disallow paths, cache TTL, priorities.
  - `SitemapBuilder`: home, 8 tiện ích, mọi `scriptures.read`, bài viết đã publish.
  - Cache sitemap (1h) + auto-invalidate khi Post/Scripture thay đổi.
  - `php artisan sitemap:generate` ghi file tĩnh (tùy chọn CDN).
  - `x-seo-meta`: canonical + meta description + `noindex` khi staging.
  - Tests: `tests/Feature/SeoTest.php`.

## Partially Done / In Progress

- PDF booklet visual polish is improved but still sensitive to source PDF layout:
  - balance between "fill page" and "no crop" still requires fine tuning for some documents.
  - booklet page turn aesthetics were adjusted and stabilized, but may still need minor tweaks per preference.

## Not Done Yet / Pending

- Add explicit UI status badge in dashboard list for each scripture mode (`AUTO` / `PDF` / `CONTENT`).
- Add quick toggle action directly from scripture table (without opening modal).
- Optional: persist reader visual preferences (zoom/fit mode) per scripture or globally.
- Optional: add small runtime indicator in reader (`PDF mode` vs `Fallback content`) for easier debugging.

## Growth & SEO Ideas (new)

### Trending Topic Clusters to Build Around

- `thiền cho người mới bắt đầu`
- `thiền 5 phút / 15 phút mỗi ngày`
- `chánh niệm trong công việc và học tập`
- `phật pháp ứng dụng cho người trẻ`
- `giảm stress, lo âu theo tinh thần Phật giáo`
- `nuôi dạy con theo tinh thần Phật giáo`
- `khóa tu mùa hè / tu học thanh thiếu niên`
- `nghe kinh mỗi ngày / đọc kinh online`

### Feature Ideas to Attract More Followers + SEO

1) SEO Hub Pages by Intent
- Create dedicated landing pages per intent cluster (Learn / Practice / Family / Youth).
- Add internal links to related scriptures, posts, and audio.
- Add FAQs on each hub page for long-tail search coverage.

2) "Practice in X Minutes" Experience
- Add quick practice modules: 3, 5, 10, 15 minutes.
- Show a daily check-in streak to keep users returning.
- Build keyword-focused pages such as "thiền 5 phút trước khi ngủ".

3) Scripture + Explanation + Audio Triplet
- For each scripture: keep original text, add easy explanation, and optional audio narration.
- This increases session time and supports keywords like "kinh [name] dễ hiểu".

4) Family/Youth Resource Center
- Add a section focused on parents and teenagers:
  - values education,
  - emotional regulation,
  - mindful habits for students.
- Useful for keywords around parenting and youth moral education.

5) Topic Series Pages (Pillar + Cluster)
- Build pillar pages: "Phật pháp ứng dụng", "Thiền căn bản", "Sống chánh niệm".
- Attach cluster articles beneath each pillar for stronger topical authority.

### Add 10 More Features (scale-up plan)

6) Daily Buddhist Quote + Reflection
- Show "Lời Phật dạy hôm nay" on homepage with a short practical reflection.
- Create archive pages by topic (`an lạc`, `buông xả`, `từ bi`) to capture long-tail traffic.

7) Guided Audio Meditation Library
- Add audio sessions by duration (`5p`, `10p`, `20p`) and intent (`ngủ ngon`, `giảm stress`, `tập trung`).
- Add transcript below each audio for indexable SEO content.

8) Q&A "Hỏi đáp Phật pháp đời sống"
- Let users submit questions (anonymous optional), admin/pagoda team can answer.
- Every Q&A becomes an indexable URL targeting question-style keywords.

9) Personalized Reading / Practice Path
- New users choose a goal: `bớt lo âu`, `ngủ tốt hơn`, `sống chậm lại`, `nuôi dạy con`.
- System suggests scriptures + practice sessions + related articles.

10) Buddhist Calendar + Event Landing Pages
- Build pages for full moon/new moon observances, major lễ Phật giáo days, retreat schedules.
- Add yearly recurring SEO pages: "Lịch lễ Phật giáo 2026/2027".

11) Weekly Newsletter + Telegram/Zalo Digest
- Collect email/subscriber list with lead magnet "7 ngày thực tập chánh niệm".
- Send weekly digest that links back to new scripture/audio/article content.

12) Community Challenges (7-21 days)
- Launch challenge campaigns: "7 ngày thiền 10 phút", "21 ngày sống chánh niệm".
- Add progress badges and share cards for organic social growth.

13) SEO Programmatic Pages by Keyword Pattern
- Auto-generate landing pages from template:
  - `kinh [topic]`,
  - `thiền [mục tiêu]`,
  - `phật pháp cho [đối tượng]`.
- Keep strict quality control (no thin content) with curated intro + related links.

14) Internal Search with Suggestion + Intent Tags
- Improve search bar with auto-suggest by popular keywords.
- Add tags (`thiền`, `gia đình`, `người trẻ`, `kinh tụng`) for stronger discovery and retention.

15) Testimony / Transformation Stories
- Publish user stories about practicing mindfulness and Buddhist teachings in daily life.
- Strong trust signal for new visitors and supports conversion to long-term followers.

### SEO Implementation Checklist (technical)

- Add JSON-LD structured data:
  - `Article` for posts,
  - `FAQPage` for Q&A sections,
  - `BreadcrumbList` for navigation.
- Ensure unique meta title/description per scripture and article (description via `x-seo-meta`; titles per page).
- ~~Add canonical tags to prevent duplicate indexing.~~ Done (`x-seo-meta`).
- ~~Add XML sitemap entries for scripture reader pages.~~ Done (`SitemapBuilder`).
- Improve Core Web Vitals on reader page (optimize PDF loading, lazy assets).

### Execution Roadmap (12 weeks, less simple and more complete)

Phase 1 (Week 1-2) - Foundation
- Launch 2 hub pages (`Thiền cho người mới`, `Phật pháp cho người trẻ`).
- Publish first 8 SEO articles + 20 FAQ entries.
- Add schema (`Article`, `FAQPage`, `BreadcrumbList`) to templates.
- Set up analytics dashboard (GSC + GA4) with conversion events.

Phase 2 (Week 3-5) - Retention Features
- Ship "Practice in 5/10/15 minutes" with streak tracking.
- Launch daily quote + reflection module.
- Release guided audio meditation library v1 (minimum 15 tracks + transcripts).

Phase 3 (Week 6-8) - Community + UGC
- Launch Q&A module and testimony stories section.
- Start first "7 ngày thiền 10 phút" challenge.
- Enable weekly digest signup (email + social channel integration).

Phase 4 (Week 9-10) - Authority Expansion
- Publish scripture explanation + audio for top 20 most-read scriptures.
- Launch Buddhist calendar/event landing pages for the next 12 months.
- Add personalized reading/practice path by user goal.

Phase 5 (Week 11-12) - Scale SEO Engine
- Deploy programmatic SEO pages with editorial review workflow.
- Upgrade internal search with autosuggest + intent tags.
- Optimize pages with low CTR/high impression in Search Console.

### KPI Targets (first 90 days)

- Organic sessions: `+80%`
- Returning users: `+35%`
- Average session duration: `+25%`
- Newsletter subscribers: `2,000+`
- Top-10 ranking keywords: `50+`

### Example Long-tail Keywords to Target

- `thiền 5 phút cho người bận rộn`
- `cách thực hành chánh niệm mỗi ngày`
- `phật pháp ứng dụng trong cuộc sống hiện đại`
- `kinh phật dễ hiểu cho người mới`
- `giảm lo âu theo lời phật dạy`
- `dạy con lòng từ bi theo phật giáo`
- `khóa tu mùa hè cho thanh thiếu niên`
- `nghe kinh online mỗi ngày`

## Required Manual Steps

### Tái tạo file âm Máy niệm Phật (tùy chọn)

Cần `python3 -m yt_dlp` và ffmpeg (hoặc `imageio_ffmpeg`). Ví dụ cắt loop A Di Đà từ video `5Wg0Vs-OziA`:

```bash
# Tải audio
python3 -m yt_dlp -x --audio-format mp3 -o "/tmp/nam-mo-a-di-da.%(ext)s" "https://www.youtube.com/watch?v=5Wg0Vs-OziA"

# Cắt ~90s loop (điều chỉnh -ss theo đoạn niệm ổn định trong video)
ffmpeg -y -ss 25 -t 90 -i "/tmp/nam-mo-a-di-da.webm" -vn -ac 1 -ar 44100 \
  -c:a libmp3lame -b:a 96k public/audio/may-niem-phat/02-nam-mo-a-di-da-phat-loop.mp3
```

Các câu 03–07: tải từ video ID trong bảng trên, cắt clip + loop tương tự (`ss` ~22–25s, `t` 90s cho loop).

Run migrations (gồm `reader_mode` và `utilities.link_url`):

```bash
php artisan migrate
```

Migration `add_link_url_to_utilities` tự gán `link_url` theo đúng `name` đã seed. Nếu tên tiện ích trên DB khác, sửa trực tiếp trong **Dashboard → Tiện ích** (trường *Liên kết khi click*). Không nên chạy lại toàn bộ `BuddhistContentSeeder` trên DB đã có dữ liệu (sẽ trùng lặp kinh/bài viết).

Recommended cache clear after migrations/config changes:

```bash
php artisan optimize:clear
```

### Production SEO (robots + sitemap)

Trên server production, trong `.env`:

```env
APP_URL=https://kinhhocphatgiaocom.com
APP_ENV=production
SEO_INDEXING_ENABLED=true
```

Staging/local: để `SEO_INDEXING_ENABLED=false` (mặc định khi `APP_ENV` ≠ `production`) — `robots.txt` chặn toàn site, `sitemap.xml` trả 404.

Sau deploy:

```bash
php artisan optimize:clear
php artisan route:cache
```

Kiểm tra:

- `https://<domain>/robots.txt` — có `Sitemap:` trỏ đúng domain.
- `https://<domain>/sitemap.xml` — XML hợp lệ, có URL kinh/bài/tiện ích.

Google Search Console: gửi sitemap `https://<domain>/sitemap.xml`.

Tùy chọn (host chỉ phục vụ file tĩnh):

```bash
php artisan sitemap:generate
```

## Main Files Touched (recent work)

### Session 2026-05-17

- `resources/views/scriptures/reader.blade.php`
- `resources/views/components/site-header.blade.php`
- `resources/views/components/donate-link.blade.php`
- `resources/views/tools/may-niem-phat.blade.php`
- `public/audio/may-niem-phat/*.mp3` (01–07 clip + loop; `00-*` loop A Di Đà 6 chữ)
- `resources/views/livewire/home-page.blade.php`
- `resources/views/components/layouts/home.blade.php`
- `resources/views/components/pwa-install-modal.blade.php` *(mới)*
- `resources/views/components/pwa-install-banner.blade.php`
- `config/site.php`, `config/mail.php`, `.env`, `.env.example`
- `resources/views/components/site-footer.blade.php`
- `resources/views/tools/lien-he-ho-tro.blade.php`
- `Kinh Học Phật Giáo/index.html`

### Trước đó

- `app/Http/Controllers/ScriptureReaderController.php`
- `app/Http/Controllers/ToolsController.php`
- `resources/views/scriptures/reader.blade.php`
- `resources/views/tools/*.blade.php`
- `resources/views/components/layouts/tool.blade.php`
- `app/Livewire/DashboardPage.php`
- `resources/views/livewire/dashboard-page.blade.php`
- `resources/views/livewire/home-page.blade.php`
- `resources/views/components/utility-grid.blade.php`
- `resources/views/components/site-header.blade.php`
- `resources/views/components/site-footer.blade.php`
- `app/Models/Scripture.php`
- `app/Models/Utility.php`
- `routes/web.php`
- `database/migrations/2026_05_01_011900_add_reader_mode_to_scriptures_table.php`
- `database/migrations/2026_05_01_120000_add_link_url_to_utilities_table.php`
- `database/seeders/BuddhistContentSeeder.php`
- `resources/views/components/icon.blade.php`
- `app/Http/Controllers/SeoController.php`
- `app/Services/SitemapBuilder.php`
- `app/Support/ToolSlugs.php`
- `app/Console/Commands/GenerateSitemapCommand.php`
- `config/seo.php`
- `resources/views/components/seo-meta.blade.php`
- `tests/Feature/SeoTest.php`
