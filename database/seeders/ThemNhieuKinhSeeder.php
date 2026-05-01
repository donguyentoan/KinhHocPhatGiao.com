<?php

namespace Database\Seeders;

use App\Models\Scripture;
use App\Models\ScriptureCategory;
use Illuminate\Database\Seeder;

class ThemNhieuKinhSeeder extends Seeder
{
    public function run(): void
    {
        $heThongId = ScriptureCategory::query()->firstOrCreate(
            ['name' => 'Hệ Thống Kinh'],
            ['description' => 'Các bộ kinh căn bản từ sơ cấp đến đại thừa.', 'color_class' => 'text-[#8b5e34]']
        )->id;

        $diaTangId = ScriptureCategory::query()->firstOrCreate(
            ['name' => 'Kinh Địa Tạng'],
            ['description' => 'Nguyện lực vĩ đại, hiếu đạo và giải thoát siêu độ.', 'color_class' => 'text-red-700']
        )->id;

        $rows = [
            ['title' => 'Kinh A Di Đà', 'path' => 'scriptures/pdf/kinh-a-di-da.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Vô Lượng Thọ', 'path' => 'scriptures/pdf/kinh-vo-luong-tho.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Quán Vô Lượng Thọ', 'path' => 'scriptures/pdf/kinh-quan-vo-luong-tho.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Địa Tạng Bồ Tát Bổn Nguyện', 'path' => 'scriptures/kinh-dia-tang-bo-tat-bon-nguyen.pdf', 'category_id' => $diaTangId],
            ['title' => 'Kinh Pháp Hoa', 'path' => 'scriptures/pdf/kinh-phap-hoa.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Kim Cang Bát Nhã Ba La Mật', 'path' => 'scriptures/pdf/kinh-kim-cang.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Bát Nhã Tâm Kinh', 'path' => 'scriptures/pdf/kinh-bat-nha-tam-kinh.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Dược Sư', 'path' => 'scriptures/pdf/kinh-duoc-su.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Diệu Pháp Liên Hoa (tên gọi khác của Kinh Pháp Hoa)', 'path' => 'scriptures/pdf/kinh-phap-hoa.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Lăng Nghiêm', 'path' => 'scriptures/pdf/kinh-lang-nghiem.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Lăng Già', 'path' => 'scriptures/pdf/kinh-lang-gia.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Viên Giác', 'path' => 'scriptures/pdf/kinh-vien-giac.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Hoa Nghiêm', 'path' => 'scriptures/pdf/kinh-hoa-nghiem.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Thủ Lăng Nghiêm', 'path' => 'scriptures/pdf/kinh-thu-lang-nghiem.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Phổ Môn (phẩm Phổ Môn)', 'path' => 'scriptures/pdf/kinh-phap-hoa.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Tứ Thập Nhị Chương', 'path' => null, 'category_id' => $heThongId],
            ['title' => 'Kinh Thiện Sinh', 'path' => null, 'category_id' => $heThongId],
            ['title' => 'Kinh Pháp Cú', 'path' => null, 'category_id' => $heThongId],
            ['title' => 'Kinh Đại Bát Niết Bàn', 'path' => 'scriptures/pdf/kinh-dai-bat-niet-ban.pdf', 'category_id' => $heThongId],
            ['title' => 'Kinh Đại Bảo Tích', 'path' => 'scriptures/pdf/kinh-dai-bao-tich.pdf', 'category_id' => $heThongId],
        ];

        foreach ($rows as $row) {
            $hasPdf = is_string($row['path']) && str_ends_with($row['path'], '.pdf');

            Scripture::query()->updateOrCreate(
                ['title' => $row['title']],
                [
                    'summary' => $hasPdf
                        ? 'Bản kinh được cấu hình đọc từ PDF trong thư viện nội bộ.'
                        : 'Bản kinh đã tạo mục trong thư viện, chờ bổ sung PDF phù hợp.',
                    'content_text' => null,
                    'content_file_path' => $row['path'],
                    'duration_minutes' => 45,
                    'chant_count' => 0,
                    'image_url' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=500',
                    'reader_mode' => $hasPdf ? 'pdf' : 'content',
                    'category_id' => $row['category_id'],
                ]
            );
        }
    }
}
