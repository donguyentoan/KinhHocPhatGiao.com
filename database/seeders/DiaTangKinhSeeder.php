<?php

namespace Database\Seeders;

use App\Models\Scripture;
use App\Models\ScriptureCategory;
use Illuminate\Database\Seeder;

/** Một quyển Kinh Địa Tạng Bồ Tát Bổn Nguyện (PDF trong storage/app/public/scriptures/). */
class DiaTangKinhSeeder extends Seeder
{
    public const CONTENT_FILE_PATH = 'scriptures/kinh-dia-tang-bo-tat-bon-nguyen.pdf';

    public function run(): void
    {
        $categoryId = ScriptureCategory::query()
            ->where('name', 'Kinh Địa Tạng')
            ->value('id');

        if ($categoryId === null) {
            $this->command?->warn('Chưa có ScriptureCategory "Kinh Địa Tạng". Chạy BuddhistContentSeeder trước.');

            return;
        }

        Scripture::query()->updateOrCreate(
            ['title' => 'Kinh Địa Tạng Bồ Tát Bổn Nguyện'],
            [
                'summary' => 'Toàn bộ kinh (một quyển PDF).',
                'content_text' => null,
                'content_file_path' => self::CONTENT_FILE_PATH,
                'duration_minutes' => 45,
                'chant_count' => 0,
                'image_url' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=500',
                'reader_mode' => 'pdf',
                'category_id' => $categoryId,
            ]
        );
    }
}
