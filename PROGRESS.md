# PROGRESS

Updated: 2026-05-01

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

## Partially Done / In Progress

- PDF booklet visual polish is improved but still sensitive to source PDF layout:
  - balance between "fill page" and "no crop" still requires fine tuning for some documents.
  - booklet page turn aesthetics were adjusted and stabilized, but may still need minor tweaks per preference.

## Not Done Yet / Pending

- Add explicit UI status badge in dashboard list for each scripture mode (`AUTO` / `PDF` / `CONTENT`).
- Add quick toggle action directly from scripture table (without opening modal).
- Optional: persist reader visual preferences (zoom/fit mode) per scripture or globally.
- Optional: add small runtime indicator in reader (`PDF mode` vs `Fallback content`) for easier debugging.

## Required Manual Steps

Run migration for the new `reader_mode` field:

```bash
php artisan migrate
```

Recommended cache clear after migrations/config changes:

```bash
php artisan optimize:clear
```

## Main Files Touched (recent work)

- `app/Http/Controllers/ScriptureReaderController.php`
- `resources/views/scriptures/reader.blade.php`
- `app/Livewire/DashboardPage.php`
- `resources/views/livewire/dashboard-page.blade.php`
- `app/Models/Scripture.php`
- `routes/web.php`
- `database/migrations/2026_05_01_011900_add_reader_mode_to_scriptures_table.php`
- `resources/views/components/icon.blade.php`
