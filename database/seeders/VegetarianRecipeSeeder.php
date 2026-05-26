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
                'title' => 'Phở chay',
                'slug' => 'pho-chay',
                'excerpt' => 'Tô phở nóng với nước dùng rau củ ngọt thanh, ăn cùng đậu hũ, nấm và rau thơm.',
                'ingredients' => "• 500g bánh phở\n• 1.5 lít nước dùng rau củ\n• 200g đậu hũ chiên\n• Nấm hương, nấm rơm, hành tây, gừng nướng\n• Giá, rau quế, ngò gai, chanh, ớt\n• Muối, đường phèn, nước tương",
                'content' => "1. Hầm nước dùng với củ cải, cà rốt, hành tây và gừng nướng khoảng 40 phút.\n2. Nêm muối, đường phèn và nước tương cho vị thanh nhẹ.\n3. Chần bánh phở, xếp vào tô cùng đậu hũ chiên và nấm đã xào sơ.\n4. Chan nước dùng thật nóng, thêm rau thơm, giá, chanh và ớt.\n\nMẹo: Nướng hành tây và gừng trước khi hầm giúp nước phở thơm hơn.",
                'health_tips' => "Ăn kèm nhiều rau thơm và giá để tăng chất xơ, dùng ít nước tương nếu cần giảm muối.",
                'image_url' => $this->cover('pho-chay'),
                'prep_minutes' => 50,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Bún riêu chay',
                'slug' => 'bun-rieu-chay',
                'excerpt' => 'Bún riêu vị cà chua dịu, riêu chay từ đậu hũ và nấm, hợp cho bữa trưa nhẹ nhàng.',
                'ingredients' => "• 500g bún tươi\n• 4 quả cà chua\n• 250g đậu hũ non và đậu hũ chiên\n• 100g nấm rơm băm nhỏ\n• Sữa đậu nành không đường hoặc nước dùng rau củ\n• Rau muống bào, giá, rau thơm\n• Mắm chay, muối, đường phèn",
                'content' => "1. Xào cà chua với chút dầu cho ra màu, thêm nước dùng rau củ.\n2. Dằm đậu hũ non với nấm băm, nêm nhẹ rồi thả vào nồi để tạo phần riêu chay.\n3. Cho đậu hũ chiên vào, nêm mắm chay, muối và đường phèn vừa miệng.\n4. Chần bún, chan nước riêu nóng, ăn cùng rau sống.\n\nMẹo: Thêm ít sữa đậu nành không đường giúp nước dùng béo nhẹ mà vẫn thanh.",
                'health_tips' => "Đậu hũ và nấm bổ sung đạm thực vật, cà chua cung cấp lycopene tự nhiên.",
                'image_url' => $this->cover('bun-rieu-chay'),
                'prep_minutes' => 45,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Gỏi cuốn chay',
                'slug' => 'goi-cuon-chay',
                'excerpt' => 'Cuốn tươi mát với bún, rau sống, đậu hũ và nấm, dùng cùng nước chấm chay.',
                'ingredients' => "• Bánh tráng cuốn\n• 200g bún tươi\n• Đậu hũ chiên cắt thanh\n• Nấm đùi gà hoặc nấm bào ngư xào sơ\n• Xà lách, húng quế, rau thơm, dưa leo\n• Tương đậu phộng hoặc nước tương pha chanh",
                'content' => "1. Chuẩn bị rau sống, bún, đậu hũ và nấm để ráo.\n2. Nhúng bánh tráng qua nước, đặt rau, bún, đậu hũ và nấm vào giữa.\n3. Gấp mép hai bên rồi cuốn chặt tay.\n4. Dùng với tương đậu phộng hoặc nước tương chanh ớt.\n\nMẹo: Không nhúng bánh tráng quá lâu để cuốn không bị rách.",
                'health_tips' => "Món cuốn ít dầu, nhiều rau sống, phù hợp cho bữa nhẹ hoặc khai vị.",
                'image_url' => $this->cover('goi-cuon-chay'),
                'prep_minutes' => 25,
                'servings' => 3,
                'difficulty' => 'de',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'Cơm chiên chay',
                'slug' => 'com-chien-chay',
                'excerpt' => 'Cơm chiên rau củ nhanh gọn với đậu hũ, cà rốt, đậu Hà Lan và bắp ngọt.',
                'ingredients' => "• 3 chén cơm nguội\n• 150g đậu hũ chiên hạt lựu\n• Cà rốt, đậu Hà Lan, bắp ngọt\n• Hành lá hoặc boa-rô\n• Nước tương, dầu hào chay, tiêu",
                'content' => "1. Xào boa-rô cho thơm, thêm cà rốt, đậu Hà Lan và bắp ngọt.\n2. Cho cơm nguội vào đảo đều trên lửa vừa.\n3. Nêm nước tương, dầu hào chay và chút tiêu.\n4. Thêm đậu hũ chiên, đảo nhẹ rồi tắt bếp.\n\nMẹo: Dùng cơm nguội giúp hạt cơm săn và không bị nhão.",
                'health_tips' => "Giữ lượng dầu vừa phải, thêm rau luộc hoặc canh thanh để cân bằng bữa ăn.",
                'image_url' => $this->cover('com-chien-chay'),
                'prep_minutes' => 25,
                'servings' => 2,
                'difficulty' => 'de',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'title' => 'Lẩu nấm chay',
                'slug' => 'lau-nam-chay',
                'excerpt' => 'Nồi lẩu thanh ngọt từ nấm và rau củ, phù hợp bữa sum họp gia đình ngày chay.',
                'ingredients' => "• Nấm kim châm, nấm đùi gà, nấm hương, nấm rơm\n• Củ cải trắng, bắp Mỹ, cà rốt\n• Đậu hũ non, tàu hũ ky\n• Rau cải, tần ô, mì hoặc bún\n• Muối, đường phèn, nước tương",
                'content' => "1. Hầm củ cải, bắp Mỹ và cà rốt để lấy nước dùng ngọt tự nhiên.\n2. Nêm muối, đường phèn và nước tương vừa ăn.\n3. Dọn nấm, đậu hũ, rau và mì ra đĩa.\n4. Nhúng nấm và rau theo từng lượt để giữ độ giòn ngọt.\n\nMẹo: Cho nấm vào gần cuối để nấm không bị dai và giữ mùi thơm.",
                'health_tips' => "Nấm giàu vị umami tự nhiên, giúp món ăn đậm đà mà không cần nhiều gia vị.",
                'image_url' => $this->cover('lau-nam-chay'),
                'prep_minutes' => 55,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Đậu hũ sốt cà chua',
                'slug' => 'dau-hu-sot-ca-chua',
                'excerpt' => 'Đậu hũ mềm béo thấm sốt cà chua chua ngọt, ăn với cơm nóng rất đưa vị.',
                'ingredients' => "• 3 miếng đậu hũ trắng\n• 4 quả cà chua chín\n• Boa-rô băm\n• Nước tương, muối, đường, tiêu\n• Hành lá hoặc ngò rí",
                'content' => "1. Cắt đậu hũ miếng vừa ăn, áp chảo vàng nhẹ hai mặt.\n2. Phi thơm boa-rô, cho cà chua băm vào nấu mềm thành sốt.\n3. Nêm nước tương, muối, đường và tiêu.\n4. Cho đậu hũ vào rim 5-7 phút để thấm sốt, rắc hành ngò.\n\nMẹo: Chọn cà chua chín đỏ để sốt có màu đẹp và vị ngọt tự nhiên.",
                'health_tips' => "Đậu hũ cung cấp đạm thực vật, sốt cà chua giúp món ăn dễ ăn mà không cần nhiều dầu.",
                'image_url' => $this->cover('dau-hu-sot-ca-chua'),
                'prep_minutes' => 25,
                'servings' => 3,
                'difficulty' => 'de',
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'title' => 'Bánh xèo chay',
                'slug' => 'banh-xeo-chay',
                'excerpt' => 'Bánh xèo vỏ giòn vàng, nhân nấm, giá và đậu xanh, cuốn rau sống chấm nước mắm chay.',
                'ingredients' => "• Bột gạo, bột nghệ, nước cốt dừa\n• Nấm mèo, nấm rơm, giá, đậu xanh hấp\n• Xà lách, cải xanh, rau thơm\n• Nước chấm chay: nước tương, chanh, đường, ớt",
                'content' => "1. Pha bột gạo với bột nghệ, nước cốt dừa, muối và để nghỉ 30 phút.\n2. Xào sơ nấm với giá và đậu xanh, nêm nhẹ.\n3. Làm nóng chảo, quét dầu mỏng, đổ bột, thêm nhân rồi gập đôi.\n4. Ăn nóng cùng rau sống và nước chấm chay.\n\nMẹo: Đổ lớp bột mỏng và giữ lửa vừa để bánh giòn lâu.",
                'health_tips' => "Dùng chảo chống dính và lượng dầu vừa đủ để món bánh nhẹ hơn.",
                'image_url' => $this->cover('banh-xeo-chay'),
                'prep_minutes' => 45,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'title' => 'Mì xào rau củ',
                'slug' => 'mi-xao-rau-cu',
                'excerpt' => 'Mì xào nhanh với cải thìa, cà rốt, nấm và đậu hũ, thơm nhẹ vị nước tương.',
                'ingredients' => "• 300g mì vàng hoặc mì trứng chay\n• Cải thìa, cà rốt, bông cải, nấm\n• Đậu hũ chiên hoặc tàu hũ ky\n• Boa-rô, nước tương, dầu hào chay, tiêu",
                'content' => "1. Trụng mì vừa mềm, xả nhanh qua nước lạnh rồi để ráo.\n2. Xào boa-rô cho thơm, thêm rau củ và nấm.\n3. Cho mì vào đảo nhanh tay, nêm nước tương và dầu hào chay.\n4. Thêm đậu hũ chiên, rắc tiêu và dùng nóng.\n\nMẹo: Xào trên lửa lớn để rau giữ màu và mì không bị bở.",
                'health_tips' => "Tăng tỷ lệ rau củ so với mì để món ăn nhẹ bụng và giàu chất xơ hơn.",
                'image_url' => $this->cover('mi-xao-rau-cu'),
                'prep_minutes' => 25,
                'servings' => 3,
                'difficulty' => 'de',
                'is_featured' => false,
                'sort_order' => 8,
            ],
            [
                'title' => 'Canh khổ qua chay',
                'slug' => 'canh-kho-qua-chay',
                'excerpt' => 'Canh khổ qua thanh mát, nhân đậu hũ nấm bùi nhẹ, hợp cho bữa cơm chay gia đình.',
                'ingredients' => "• 3 trái khổ qua\n• 200g đậu hũ trắng bóp ráo\n• Nấm mèo, miến, cà rốt băm\n• Nước dùng rau củ\n• Muối, tiêu, hạt nêm chay, ngò rí",
                'content' => "1. Khổ qua bỏ ruột, rửa sạch, có thể chần sơ để giảm đắng.\n2. Trộn đậu hũ với nấm mèo, miến, cà rốt, muối và tiêu làm nhân.\n3. Nhồi nhân vào khổ qua, nấu với nước dùng rau củ đến mềm.\n4. Nêm lại vừa ăn, rắc ngò rí trước khi dùng.\n\nMẹo: Không đậy nắp quá kín khi nấu để nước canh trong và khổ qua giữ màu.",
                'health_tips' => "Khổ qua có vị đắng nhẹ giúp bữa ăn thanh mát; người huyết áp thấp nên dùng lượng vừa phải.",
                'image_url' => $this->cover('canh-kho-qua-chay'),
                'prep_minutes' => 40,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => false,
                'sort_order' => 9,
            ],
            [
                'title' => 'Chả giò chay',
                'slug' => 'cha-gio-chay',
                'excerpt' => 'Chả giò vàng giòn với nhân khoai môn, nấm mèo, miến và rau củ băm nhỏ.',
                'ingredients' => "• Bánh tráng cuốn chả giò\n• Khoai môn bào, cà rốt băm\n• Nấm mèo, miến ngâm mềm\n• Đậu hũ bóp ráo\n• Muối, tiêu, hạt nêm chay\n• Dầu ăn",
                'content' => "1. Trộn khoai môn, cà rốt, nấm mèo, miến và đậu hũ với gia vị.\n2. Cuốn nhân vừa phải, mép bánh tráng thấm ít nước để dính.\n3. Chiên lửa vừa đến khi chả giò vàng giòn.\n4. Để ráo dầu, dùng với rau sống và nước chấm chay.\n\nMẹo: Không cuốn quá chặt để chả giò không bị nứt khi chiên.",
                'health_tips' => "Dùng giấy thấm dầu sau khi chiên, ăn kèm nhiều rau sống để món ăn cân bằng hơn.",
                'image_url' => $this->cover('cha-gio-chay'),
                'prep_minutes' => 45,
                'servings' => 4,
                'difficulty' => 'trung-binh',
                'is_featured' => false,
                'sort_order' => 10,
            ],
        ];

        VegetarianRecipe::query()
            ->whereIn('slug', [
                'canh-nam-huong-dau-hu-non',
                'pho-chay-rau-cu',
                'goi-du-du-chay',
                'com-rang-dua-bao-chay',
                'chao-nam-linh-chi-dau-xanh',
            ])
            ->delete();

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
