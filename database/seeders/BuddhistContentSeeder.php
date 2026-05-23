<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Scripture;
use App\Models\ScriptureCategory;
use App\Models\Utility;
use Illuminate\Database\Seeder;

class BuddhistContentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Hệ Thống Kinh', 'description' => 'Các bộ kinh căn bản từ sơ cấp đến đại thừa.', 'color_class' => 'text-[#8b5e34]'],
            ['name' => 'Kinh Địa Tạng', 'description' => 'Nguyện lực vĩ đại, hiếu đạo và giải thoát siêu độ.', 'color_class' => 'text-red-700'],
            ['name' => 'Mật Chú', 'description' => 'Các chân ngôn và thần chú phổ biến.', 'color_class' => 'text-purple-700'],
            ['name' => 'Tụng Hằng Ngày', 'description' => 'Nghi thức tụng niệm sớm tối.', 'color_class' => 'text-blue-700'],
            ['name' => 'Văn Sám Hối', 'description' => 'Các bài văn sám nguyện, thanh tịnh thân tâm.', 'color_class' => 'text-emerald-700'],
        ])->map(fn (array $item) => ScriptureCategory::query()->create($item))->keyBy('name');

        Scripture::query()->insert([
            [
                'title' => 'Kinh Phổ Môn (Cầu An)',
                'summary' => 'Tụng đọc để nuôi dưỡng lòng từ bi và cầu an cho gia đạo.',
                'duration_minutes' => 25,
                'chant_count' => 1200,
                'image_url' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&q=80&w=500',
                'category_id' => $categories['Hệ Thống Kinh']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Chú Đại Bi (84 Biến)',
                'summary' => 'Thực hành trì chú để tịnh tâm và tăng trưởng năng lượng từ bi.',
                'duration_minutes' => 45,
                'chant_count' => 3500,
                'image_url' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=500',
                'category_id' => $categories['Mật Chú']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kinh A Di Đà',
                'summary' => 'Kinh tụng hằng ngày cho hành giả Tịnh Độ.',
                'duration_minutes' => 30,
                'chant_count' => 850,
                'image_url' => 'https://images.unsplash.com/photo-1590731130394-77c8e9982496?auto=format&fit=crop&q=80&w=500',
                'category_id' => $categories['Tụng Hằng Ngày']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sám Hối Hồng Danh',
                'summary' => 'Văn sám hối để quay về nội tâm trong sạch.',
                'duration_minutes' => 40,
                'chant_count' => 2100,
                'image_url' => 'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?auto=format&fit=crop&q=80&w=500',
                'category_id' => $categories['Văn Sám Hối']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Post::query()->insert([
            [
                'title' => 'Truyện cổ Phật giáo: Một lời ác ý, trăm năm chịu khổ',
                'excerpt' => 'Người xưa có câu: ác giả ác báo, thiện giả thiện lai.',
                'image_url' => 'https://png.pngtree.com/thumb_back/fh260/background/20250224/pngtree-a-small-buddha-statue-sits-on-top-of-smooth-black-rocks-image_16948733.jpg',
                'published_at' => now()->subDays(3),
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Ác giả ác báo theo quan điểm của nhà Phật',
                'excerpt' => 'Đức Phật khai thị một dạng thức chung nhất: ác giả ác báo.',
                'image_url' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=300',
                'published_at' => now()->subDays(4),
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Người mất trong 49 ngày rất trông mong người thân làm phước',
                'excerpt' => 'Nội dung trích từ Địa Tạng Bồ Tát Bổn Nguyện Kinh.',
                'image_url' => 'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?auto=format&fit=crop&q=80&w=300',
                'published_at' => now()->subDays(6),
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $utilities = [
            ['name' => 'Máy niệm phật', 'link_url' => '/tien-ich/may-niem-phat'],
            ['name' => 'Đọc kinh', 'link_url' => '/tien-ich/doc-kinh'],
            ['name' => 'Ngồi thiền', 'link_url' => '/tien-ich/ngoi-thien'],
            ['name' => 'Chuông mõ', 'link_url' => '/tien-ich/chuong-mo'],
            ['name' => 'Lần chuỗi hạt', 'link_url' => '/tien-ich/lan-chuoi-hat'],
            ['name' => 'Nhạc thiền', 'link_url' => '/tien-ich/nhac-thien'],
            ['name' => 'Sự kiện trong năm', 'link_url' => '/tien-ich/su-kien-trong-nam'],
            ['name' => 'Liên hệ hỗ trợ', 'link_url' => '/tien-ich/lien-he-ho-tro'],
            ['name' => 'Cây Bồ Đề Pháp Cú', 'link_url' => '/tien-ich/hai-loc-phap-cu'],
            ['name' => 'Trắc nghiệm Phật giáo', 'link_url' => '/tien-ich/truc-nghiem-phat-giao'],
        ];

        foreach ($utilities as $index => $row) {
            Utility::query()->updateOrCreate(
                ['name' => $row['name']],
                [
                    'icon_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK3vqaAlAVrF3ICG82_XpZPi4ebsNR1HEd-Q&s',
                    'link_url' => $row['link_url'],
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
