<?php

namespace Database\Seeders;

use App\Models\Scripture;
use App\Models\ScriptureCategory;
use Illuminate\Database\Seeder;

/** Kinh Pháp Hoa, Kinh Sám Hối (nghi thức), Kinh Người Áo Trắng — PDF trong storage/app/public/scriptures/pdf/. */
class PhapHoaSamHoiNguoiAoTrangSeeder extends Seeder
{
    public const PHAP_HOA_PATH = 'scriptures/pdf/kinh-phap-hoa-viengiac.pdf';

    public const SAM_HOI_PATH = 'scriptures/pdf/kinh-sam-hoi-nghi-thuc-vanthaphienminh.pdf';

    public const NGUOI_AO_TRANG_PATH = 'scriptures/pdf/kinh-nguoi-ao-trang-sakya.pdf';

    public function run(): void
    {
        $heThong = ScriptureCategory::query()->where('name', 'Hệ Thống Kinh')->value('id');
        $vanSamHoi = ScriptureCategory::query()->where('name', 'Văn Sám Hối')->value('id');

        if ($heThong === null || $vanSamHoi === null) {
            $this->command?->warn('Chạy BuddhistContentSeeder trước để có danh mục kinh.');

            return;
        }

        Scripture::query()->updateOrCreate(
            ['title' => 'Kinh Pháp Hoa'],
            [
                'summary' => 'Diệu Pháp Liên Hoa kinh — bản PDF tiếng Việt (nguồn: kinh.viengiac.info).',
                'content_text' => null,
                'content_file_path' => self::PHAP_HOA_PATH,
                'duration_minutes' => 90,
                'chant_count' => 0,
                'image_url' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=500',
                'reader_mode' => 'pdf',
                'category_id' => $heThong,
            ]
        );

        Scripture::query()->updateOrCreate(
            ['title' => 'Kinh Sám Hối'],
            [
                'summary' => 'Nghi thức sám hối (PDF: Văn Tháp Hiền Minh, vanthaphienminh.org).',
                'content_text' => null,
                'content_file_path' => self::SAM_HOI_PATH,
                'duration_minutes' => 30,
                'chant_count' => 0,
                'image_url' => 'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?auto=format&fit=crop&q=80&w=500',
                'reader_mode' => 'pdf',
                'category_id' => $vanSamHoi,
            ]
        );

        Scripture::query()->updateOrCreate(
            ['title' => 'Kinh Người Áo Trắng'],
            [
                'summary' => 'Dành cho đệ tử tại gia — năm giới và bốn tâm (bản PDF tiếng Việt; kinh Ưu Bà Tắc / Trung A Hàm).',
                'content_text' => null,
                'content_file_path' => self::NGUOI_AO_TRANG_PATH,
                'duration_minutes' => 20,
                'chant_count' => 0,
                'image_url' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&q=80&w=500',
                'reader_mode' => 'pdf',
                'category_id' => $heThong,
            ]
        );
    }
}
