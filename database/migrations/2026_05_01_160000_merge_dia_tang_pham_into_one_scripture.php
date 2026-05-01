<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const TITLE_ONE_VOLUME = 'Kinh Địa Tạng Bồ Tát Bổn Nguyện';

    private const PDF_PATH = 'scriptures/kinh-dia-tang-bo-tat-bon-nguyen.pdf';

    public function up(): void
    {
        DB::table('scriptures')->where('title', 'like', 'Kinh Địa Tạng — Phẩm %')->delete();

        $categoryId = DB::table('scripture_categories')->where('name', 'Kinh Địa Tạng')->value('id');
        if ($categoryId === null) {
            return;
        }

        $now = now();

        $updated = DB::table('scriptures')
            ->where('title', self::TITLE_ONE_VOLUME)
            ->update([
                'content_file_path' => self::PDF_PATH,
                'reader_mode' => 'pdf',
                'summary' => 'Toàn bộ kinh (một quyển PDF).',
                'duration_minutes' => 45,
                'updated_at' => $now,
            ]);

        if ($updated === 0) {
            DB::table('scriptures')->insert([
                'title' => self::TITLE_ONE_VOLUME,
                'summary' => 'Toàn bộ kinh (một quyển PDF).',
                'content_text' => null,
                'content_file_path' => self::PDF_PATH,
                'duration_minutes' => 45,
                'chant_count' => 0,
                'image_url' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=500',
                'reader_mode' => 'pdf',
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('scriptures')
            ->where('title', self::TITLE_ONE_VOLUME)
            ->where('content_file_path', self::PDF_PATH)
            ->delete();
    }
};
