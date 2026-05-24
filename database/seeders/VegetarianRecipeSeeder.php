<?php

namespace Database\Seeders;

use App\Models\Utility;
use App\Models\VegetarianRecipe;
use Illuminate\Database\Seeder;

class VegetarianRecipeSeeder extends Seeder
{
    private function cover(string $slug): string
    {
        return '/storage/recipes/'.$slug.'.jpg';
    }

    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Canh nấm hương nấu đậu hũ non',
                'slug' => 'canh-nam-huong-dau-hu-non',
                'excerpt' => 'Canh thanh, ngọt tự nhiên — phù hợp ngày chay hoặc bữa tối nhẹ bụng.',
                'ingredients' => "• 150g nấm hương khô (ngâm nở, giữ nước ngâm)\n• 1 hộp đậu hũ non (300g)\n• 1 củ cà rốt\n• 100g bắp non\n• 1 lít nước dùng rau / nước lọc\n• Gừng lát mỏng, hành lá\n• Muối, tiêu, dầu ăn",
                'content' => "1. Ngâm nấm hương với nước ấm 20 phút, vắt ráo, thái miếng vừa.\n2. Đậu hũ non cắt khối vuông 2cm, chần qua nước sôi 1 phút để bớt tanh.\n3. Phi thơm gừng với chút dầu, cho cà rốt xào sơ, thêm nấm và bắp non.\n4. Đổ nước dùng + nước ngâm nấm, nấu sôi nhỏ 15 phút.\n5. Cho đậu hũ vào, nêm muối tiêu vừa miệng, tắt bếp, rắc hành lá.\n\nMẹo: Nấu lửa nhỏ giúp nước canh trong, vị ngọt thanh.",
                'health_tips' => "Canh nấm giàu umami tự nhiên, ít dầu mỡ — phù hợp người ăn chay muốn bổ sung protein thực vật từ đậu nành.",
                'image_url' => $this->cover('canh-nam-huong-dau-hu-non'),
                'prep_minutes' => 35,
                'servings' => 4,
                'difficulty' => 'de',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Phở chay rau củ thanh đạm',
                'slug' => 'pho-chay-rau-cu',
                'excerpt' => 'Nước dùng chay ngọt thanh, bún mềm — bữa sáng ấm bụng mà vẫn nhẹ nhàng.',
                'ingredients' => "• 500g bún tươi hoặc bún khô\n• 1.5 lít nước dùng chay (củ dền, cà rốt, hành tây hầm 40 phút)\n• Đậu hũ chiên vàng, cắt miếng\n• Nấm đông, bắp cải, giá đỗ\n• Hành lá, ngò rí, chanh, ớt\n• Nước tương, muối",
                'content' => "1. Hầm nước dùng chay với rau củ, lọc trong, nêm vừa ăn.\n2. Blanch bún qua nước sôi, xếp tô.\n3. Xếp đậu hũ, nấm, bắp cải lên bún, chan nước dùng sôi.\n4. Rắc hành ngò, chanh ớt tùy khẩu vị.\n\nCó thể thêm vài lát gừng để ấm bụng ngày mưa lạnh.",
                'health_tips' => "Chọn bún gạo, ăn kèm nhiều rau xanh — tăng chất xơ, dễ tiêu hóa.",
                'image_url' => $this->cover('pho-chay-rau-cu'),
                'prep_minutes' => 50,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Gỏi đu đủ chay chua ngọt',
                'slug' => 'goi-du-du-chay',
                'excerpt' => 'Giòn, thanh, kích thích vị giác — món khai vị hoặc ăn kèm cơm chay.',
                'ingredients' => "• 1 trái đu đủ xanh bào sợi\n• 1 củ cà rốt bào\n• Đậu phộng rang, đậu hũ chiên sợi\n• Rau thơm, ớt\n• Nước cốt chanh, đường phèn, nước tương, tỏi ớt băm",
                'content' => "1. Đu đủ và cà rốt ngâm nước đá 10 phút cho giòn, vắt ráo.\n2. Pha nước trộn: chanh, đường, nước tương, tỏi ớt — vị chua ngọt cân bằng.\n3. Trộn đu đủ, cà rốt, đậu phộng, đậu hũ, rau thơm.\n4. Dùng ngay khi còn giòn.",
                'health_tips' => "Ăn sống nhiều rau giúp bổ sung vitamin; hạn chế đường nếu cần kiểm soát đường huyết.",
                'image_url' => $this->cover('goi-du-du-chay'),
                'prep_minutes' => 20,
                'servings' => 3,
                'difficulty' => 'de',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'Cơm rang dưa bao chay',
                'slug' => 'com-rang-dua-bao-chay',
                'excerpt' => 'Cơm vàng thơm, đậu hũ giòn — bữa trưa nhanh cho ngày bận rộn.',
                'ingredients' => "• 3 chén cơm nguội\n• 150g đậu hũ chiên khối\n• 1/2 quả dưa bao hạt lép\n• Đậu Hà Lan, hành lá\n• Nước tương, dầu hào chay, tiêu",
                'content' => "1. Chiên vàng đậu hũ, để riêng.\n2. Xào dưa bao với chút dầu, cho cơm vào đảo đều.\n3. Thêm nước tương, dầu hào chay, đậu Hà Lan.\n4. Cuối cùng cho đậu hũ, hành lá, đảo nhẹ.\n\nDùng cơm nguội để hạt cơm tách, không bị nhão.",
                'health_tips' => "Khẩu phần cơm vừa phải, tăng rau xanh trong ngày để cân bằng tinh bột.",
                'image_url' => $this->cover('com-rang-dua-bao-chay'),
                'prep_minutes' => 25,
                'servings' => 2,
                'difficulty' => 'de',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Cháo nấm linh chi đậu xanh',
                'slug' => 'chao-nam-linh-chi-dau-xanh',
                'excerpt' => 'Ấm bụng, dịu nhẹ — thích hợp sáng sớm hoặc khi cơ thể cần nghỉ ngơi.',
                'ingredients' => "• 1 chén gạo tấm\n• 50g đậu xanh cà vỏ\n• Nấm linh chi tươi hoặc khô (1 tai nhỏ)\n• Gừng, muối, tiêu, dầu ăn",
                'content' => "1. Vo gạo, ngâm 30 phút; đậu xanh rửa sạch.\n2. Nấu gạo + đậu xanh + nấm với nhiều nước, đun nhỏ 45–60 phút đến nhừ.\n3. Nêm muối, chút tiêu, múc ra tô, rắc hành.\n\nCó thể nấu bằng nồi cơm điện chế độ cháo.",
                'health_tips' => "Cháo loãng dễ tiêu; ăn chậm, thở đều — biến bữa ăn thành khoảnh khắc chánh niệm.",
                'image_url' => $this->cover('chao-nam-linh-chi-dau-xanh'),
                'prep_minutes' => 60,
                'servings' => 3,
                'difficulty' => 'de',
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'Bánh xèo chay giòn rụm',
                'slug' => 'banh-xeo-chay',
                'excerpt' => 'Vỏ vàng giòn, nhân nấm rau — cuốn bánh tráng ăn kèm rau sống.',
                'ingredients' => "• Bột gạo, bột nghệ, nước cốt dừa\n• Nấm mèo, giá, hành lá\n• Bánh tráng, xà lách, rau thơm\n• Nước chấm chay: nước tương, chanh, đường, tỏi ớt",
                'content' => "1. Pha bột: bột gạo + nghệ + nước cốt dừa + muối, để nghỉ 30 phút.\n2. Xào nhân nấm mèo với giá, nêm vừa ăn.\n3. Chảo nóng, quét dầu mỏng, đổ bột mỏng, cho nhân, gập đôi.\n4. Ăn nóng với rau sống và nước chấm.\n\nLửa vừa giúp vỏ giòn không bị cháy.",
                'health_tips' => "Hạn chế dầu chiên; có thể dùng chảo chống dính và lượng dầu tối thiểu.",
                'image_url' => $this->cover('banh-xeo-chay'),
                'prep_minutes' => 45,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($recipes as $row) {
            VegetarianRecipe::query()->updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, [
                    'published_at' => now()->subDays(random_int(1, 14)),
                ])
            );
        }

        Utility::query()->updateOrCreate(
            ['link_url' => '/mon-chay'],
            [
                'name' => 'Món chay thanh đạm',
                'icon_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=128&q=80',
                'is_active' => true,
                'sort_order' => 11,
            ]
        );
    }
}
