<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    public function run(): void
    {
        if (QuizQuestion::query()->exists()) {
            return;
        }

        $rows = [
            [
                'topic' => 'Tứ Diệu Đế',
                'question' => 'Theo Phật giáo, «Khổ» trong Tứ Diệu Đế chủ yếu nói về điều gì?',
                'option_a' => 'Chỉ là đau ốm thể xác',
                'option_b' => 'Chỉ là buồn bã, lo lắng trong tâm',
                'option_c' => 'Mọi sự không như ý trong đời: sinh, già, bệnh, chết và phiền não',
                'option_d' => 'Chỉ xảy ra với người nghèo khổ',
                'correct_answer' => 'C',
                'explanation' => 'Khổ đế không chỉ là đau đớn vật lý, mà còn là mọi trạng thái bất an, không vừa lòng và luân chuyển trong đời sống.',
            ],
            [
                'topic' => 'Tứ Diệu Đế',
                'question' => 'Tứ Diệu Đế thứ hai — Tập đế — nói về điều gì?',
                'option_a' => 'Con đường tu tập để giải thoát',
                'option_b' => 'Nguyên nhân gây ra khổ',
                'option_c' => 'Sự chấm dứt khổ hoàn toàn',
                'option_d' => 'Hiện tượng khổ trong đời',
                'correct_answer' => 'B',
                'explanation' => 'Tập đế chỉ ra tham ái, chấp thủ và vô minh là gốc rễ khiến khổ sinh khởi.',
            ],
            [
                'topic' => 'Tứ Diệu Đế',
                'question' => 'Đạo đế thứ tư trong Tứ Diệu Đế là gì?',
                'option_a' => 'Bát Chánh Đạo — con đường thực hành',
                'option_b' => 'Ngũ giới',
                'option_c' => 'Thiền định mỗi ngày',
                'option_d' => 'Cúng dường tam bảo',
                'correct_answer' => 'A',
                'explanation' => 'Khổ đế, Tập đế, Diệt đế lần lượt mô tả khổ, nguyên nhân và sự chấm dứt khổ; Đạo đế chính là Bát Chánh Đạo để đi tới giải thoát.',
            ],
            [
                'topic' => 'Bát Chánh Đạo',
                'question' => 'Trong Bát Chánh Đạo, «Chánh kiến» nghĩa là gì?',
                'option_a' => 'Tin vào điều may mắn',
                'option_b' => 'Hiểu đúng về khổ, nhân quả và con đường giải thoát',
                'option_c' => 'Luôn nghĩ tích cực mọi lúc',
                'option_d' => 'Tin theo lời người khác mà không suy xét',
                'correct_answer' => 'B',
                'explanation' => 'Chánh kiến là nền tảng tu học: nhìn đúng bản chất đời sống, tin vào nhân quả và hướng về giải thoát.',
            ],
            [
                'topic' => 'Bát Chánh Đạo',
                'question' => '«Chánh niệm» trong Bát Chánh Đạo là:',
                'option_a' => 'Nhớ thuộc lòng kinh Phật',
                'option_b' => 'Không nghĩ gì cả',
                'option_c' => 'Tỉnh giác, biết rõ những gì đang diễn ra trong thân, thọ, tâm và pháp',
                'option_d' => 'Luôn suy nghĩ về quá khứ',
                'correct_answer' => 'C',
                'explanation' => 'Chánh niệm là giữ tâm tỉnh, quan sát sự vật đúng như nó đang là, không để tâm lang thang.',
            ],
            [
                'topic' => 'Nhân quả',
                'question' => 'Luật nhân quả trong Phật giáo có thể hiểu đơn giản là:',
                'option_a' => 'Việc lành hay dở đều do số phận sắp đặt sẵn',
                'option_b' => 'Hành động thiện ác sẽ mang lại quả tương ứng, dù không phải lúc nào cũng ngay lập tức',
                'option_c' => 'Chỉ người giàu mới chịu quả xấu',
                'option_d' => 'Chỉ có hiệu lực trong chùa',
                'correct_answer' => 'B',
                'explanation' => 'Nhân quả là nguyên lý tự nhiên: gieo nhân thiện thì quả lành, gieo nhân ác thì quả dữ — thời điểm chín muồi tùy duyên.',
            ],
            [
                'topic' => 'Luân hồi',
                'question' => 'Luân hồi trong Phật giáo nghĩa là:',
                'option_a' => 'Con người chỉ sống một kiếp duy nhất',
                'option_b' => 'Một linh hồn cố định chuyển sang thân xác mới',
                'option_c' => 'Dòng tâm thức và nghiệp tiếp nối qua nhiều kiếp sinh tử',
                'option_d' => 'Vũ trụ lặp lại theo chu kỳ cố định',
                'correct_answer' => 'C',
                'explanation' => 'Phật giáo không nói về «linh hồn bất biến», mà nói dòng tâm thức — nghiệp tiếp nối — sinh tử luân hồi cho đến khi giải thoát.',
            ],
            [
                'topic' => 'Ngũ giới',
                'question' => 'Ngũ giới dành cho đệ tử Phật tại gia thường là không:',
                'option_a' => 'Ăn chay mỗi ngày',
                'option_b' => 'Sát sanh, trộm cắp, tà dâm, nói dối, uống rượu say',
                'option_c' => 'Đi chùa vào ngày rằm',
                'option_d' => 'Nghe kinh Phật',
                'correct_answer' => 'B',
                'explanation' => 'Ngũ giới giúp giữ thân, khẩu, ý trong sạch, bảo vệ mình và người khác, là nền tảng đạo đức Phật giáo.',
            ],
            [
                'topic' => 'Lòng từ bi',
                'question' => 'Từ bi trong Phật giáo thường được hiểu là:',
                'option_a' => 'Chỉ thương người thân',
                'option_b' => 'Thương xót, mong muốn mọi chúng sinh được an lạc, thoát khổ',
                'option_c' => 'Luôn chiều theo ý người khác',
                'option_d' => 'Chỉ dành cho tăng ni',
                'correct_answer' => 'B',
                'explanation' => 'Từ bi là lòng thương rộng mở, không phân biệt, mong cho chúng sinh được bình an và giải thoát khỏi khổ.',
            ],
            [
                'topic' => 'Chánh niệm',
                'question' => 'Thực hành chánh niệm trong đời sống hàng ngày có thể là:',
                'option_a' => 'Vừa ăn vừa lướt điện thoại, không để ý gì',
                'option_b' => 'Biết rõ mình đang làm gì, nói gì, suy nghĩ gì ở hiện tại',
                'option_c' => 'Luôn lo lắng về tương lai',
                'option_d' => 'Tránh mọi cảm xúc khó chịu',
                'correct_answer' => 'B',
                'explanation' => 'Chánh niệm là sống tỉnh thức: biết mình đang thở, đi, nói, làm — giúp tâm vững và ít phiền não hơn.',
            ],
        ];

        foreach ($rows as $index => $row) {
            QuizQuestion::query()->create([
                ...$row,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
