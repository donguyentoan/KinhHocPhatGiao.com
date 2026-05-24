<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostArticlesSeeder extends Seeder
{
    /** Ảnh trong storage/app/public/posts/ (chạy scripts/download_post_cover_images.py). */
    private function cover(string $slug): string
    {
        return '/storage/posts/'.$slug.'.jpg';
    }

    public function run(): void
    {
        $articles = [
            [
                'title' => 'Truyện cổ Phật giáo: Một lời ác ý, trăm năm chịu khổ',
                'excerpt' => 'Người xưa có câu: "Ác giả ác báo, thiện giả thiện lai" — chỉ một lời nói không hay cũng có thể vươn thành nghiệp lực kéo dài qua nhiều đời.',
                'image_url' => $this->cover('mot-loi-ac-y'),
                'published_at' => now()->subDays(2),
                'is_featured' => true,
                'content' => <<<'TEXT'
Xưa kia có một vị tỳ kheo tu hành chánh niệm. Một hôm, khi đi khất thực, ngài gặp một đứa trẻ nhỏ nô đùa trên đường. Trong lúc vội vã, đứa trẻ vô ý va vào chân ngài. Vị tỳ kheo bực bội, buột miệng: "Sao con dám cản đường ta! Con này chắc chắn sẽ bị đọa địa ngục!"

Câu nói ấy tưởng chừng thoáng qua, nhưng trong tâm đứa trẻ đã gieo hạt sợ hãi sâu sắc. Khi lớn lên, cậu bé luôn ám ảnh bởi hình ảnh địa ngục, sống trong lo âu, khó an lạc. Sau này, nhờ duyên lành gặp được chư Phật, cậu mới hiểu: nghiệp không nằm ở lời người khác định mệnh mình, mà ở chính tâm mình tiếp nhận và phóng thích thế nào.

Câu chuyện nhắc chúng ta: lời nói là nghiệp. Một câu chê bai, một lời nguyền rủa, một tiếng la mắng — đều có thể làm tổn thương người nghe lâu dài. Ngược lại, một lời an ủi, một lời khuyến khích chân thành, có thể mở ra ánh sáng trong tâm người đang chìm trong bóng tối.

**Bài học thực hành**

- Trước khi nói, hãy dừng một hơi thở: lời này có làm người khác an lạc hơn không?
- Nếu đã vô ý nói lời không hay, hãy sám hối và xin lỗi ngay, không để nghiệp âm kéo dài.
- Khi nghe lời ác từ người khác, đừng ôm lấy làm chân lý về bản thân — giữ tâm thanh tịnh, quay về thực hành chánh niệm.

Ác giả ác báo, thiện giả thiện lai. Giữ miệng nhẹ nhàng, tâm sẽ dần thanh tịnh; thanh tịnh lâu ngày, đường tu hành cũng bớt chông gai.
TEXT,
            ],
            [
                'title' => 'Ác giả ác báo theo quan điểm của nhà Phật',
                'excerpt' => 'Đức Phật khai thị quy luật nghiệp không thiên vị ai: hạt giống nào gieo, quả ấy sẽ đến — nhưng không phải định mệnh tuyệt đối.',
                'image_url' => $this->cover('ac-gia-ac-bao'),
                'published_at' => now()->subDays(4),
                'is_featured' => true,
                'content' => <<<'TEXT'
Câu "ác giả ác báo, thiện giả thiện lai" thường bị hiểu như một bản án cố định. Trong Phật giáo, đây là **quy luật nhân quả** (karma): mỗi hành động — thân, khẩu, ý — đều gieo hạt giống trong tâm thức, và trong điều kiện thích hợp, hạt ấy sẽ nảy mầm.

**Ác báo** không có nghĩa là "trời phạt" một cách trừng phạt bên ngoài. Khi ta làm điều ác, tâm ta rối loạn, sợ hãi, hối hận; các mối quan hệ xung đột; thân thể căng thẳng — đó chính là "quả" bắt đầu ngay trong hiện tại. Khi thiện hành tích lũy, tâm nhẹ nhàng, người xung quanh tin cậy, cuộc sống có thêm duyên thuận lợi.

Điểm khác biệt quan trọng so với định mệnh: Phật giáo nói **nghiệp có thể chuyển hóa**. Sám hối chân thành, bố thí, trì giới, tu thiền, nghe pháp đúng — đều là cách làm mềm nghiệp xấu và tăng trưởng thiện căn. Một người từng gây tổn thương, nếu quay đầu nhận lỗi và sống có trách nhiệm, vẫn có thể đi trên con đường giải thoát.

**Ứng dụng trong đời sống**

1. Đừng dùng "ác báo" để đe dọa người khác hay tự trừng phạt bản thân vô ích.
2. Mỗi ngày chọn một việc thiện nhỏ: giúp đỡ, nói lời dịu dàng, từ bi với chính mình.
3. Khi gặp khó khăn, hãy hỏi: "Ta đang học bài gì?" thay vì chỉ hỏi "Ai đã làm ơn ta?"

Hiểu đúng nghiệp là hiểu trách nhiệm — không oán trời oán người, mà tự làm chủ hạt giống mình gieo hôm nay.
TEXT,
            ],
            [
                'title' => 'Có nên thờ cốt tại nhà? Người mất đã tái sinh thì việc cúng giỗ...',
                'excerpt' => 'Nhiều gia đình đặt tro cốt tại nhà để tiện tưởng niệm — nhưng theo Phật giáo, điều quan trọng là tâm hiếu và việc làm phước, không chỉ hình thức thờ cúng.',
                'image_url' => $this->cover('tho-cot-tai-nha'),
                'published_at' => now()->subDays(5),
                'is_featured' => false,
                'content' => <<<'TEXT'
Câu hỏi "có nên thờ cốt tại nhà" thường xuất phát từ tình cảm gia đình và nhu cầu tưởng nhớ người đã khuất. Trong Phật giáo, không có một quy định cứng nhắc cấm hay bắt buộc — song có vài điểm nên cân nhắc để hành động đúng với giáo lý và không gây lo âu cho các thành viên.

**Về tái sinh**

Khi thân xác tan rã, dòng tâm thức theo nghiệp lực mà chuyển — có thể trong vòng 49 ngày (theo truyền thống phổ biến ở Việt Nam) hoặc theo từng trường hợp. Người thân **không còn "ở trong" bát tro** như một linh hồn cố định. Thờ cốt nếu hiểu là "người ấy vẫn ở đây, không đi đâu được" dễ dẫn đến bám chấp, khiến cả người sống lẫn hướng đi của người mất đều nặng nề hơn.

**Việc nên làm thay vì chỉ thờ hình thức**

- Tụng kinh, niệm Phật, hồi hướng công đức cho người mất (Kinh A Di Đà, Địa Tạng, v.v.).
- Bố thí, giúp người nghèo, phóng sinh (nếu phù hợp), làm việc thiện mang tên người thân.
- Sống hiếu thảo với người còn sống: đó là cách tưởng nhớ bền vững nhất.

**Thờ cốt tại nhà — nếu gia đình vẫn chọn**

Hãy giữ không gian trang nghiêm, sạch sẽ, hạn chế tiếng ồn, rượu chè, cãi vã gần bàn thờ. Mỗi lần thắp hương, nên kết hợp lời nguyện ngắn: "Nguyện công đức này hồi hướng đến [...], mong người được an lạc, siêu thoát."

**Cúng giỗ khi người thân đã tái sinh**

Lễ giỗ không "vô ích" nếu ta hiểu đúng: đó là dịp con cháu sum họp, nhớ ơn, làm phước chung. Người mất nếu đã tái sinh vẫn có thể hưởng duyên thiện từ hồi hướng của người thân — như ánh sáng soi đường, không nhất thiết là "ăn" mâm cơm trên bàn thờ.

Tóm lại: tình cảm hiếu đạo là đẹp; hãy chuyển tình cảm ấy thành **phước báu và tâm thanh tịnh**, không chỉ dựa vào việc đặt tro hay số lần khấn vái.
TEXT,
            ],
            [
                'title' => 'Người mất trong 49 ngày rất trông mong người thân làm phước',
                'excerpt' => 'Theo Kinh Địa Tạng, trong giai đoạn trung ấm, người mất đặc biệt cần sự hồi hướng phước báu từ người thân còn sống.',
                'image_url' => $this->cover('muoi-chin-ngay-phuoc'),
                'published_at' => now()->subDays(6),
                'is_featured' => false,
                'content' => <<<'TEXT'
Trong *Địa Tạng Bồ Tát Bổn Nguyện Kinh*, Đức Phật dạy: sau khi mạng vong, chúng sinh trong vòng bốn mươi chín ngày thường ở trạng thái trung ấm — chưa hoàn toàn đầu thai, vẫn còn mong mỏi sự giúp đỡ từ gia quyến.

**Vì sao 49 ngày quan trọng?**

Mỗi tuần (thất) có thể có một "cơ duyên" thử nghiệm nghiệp lực — cảnh giới hiện lên theo tâm thức và nghiệp đã tạo. Người thân sống nếu biết tụng kinh, niệm Phật, bố thí, giữ giới, sám hối, sẽ tạo **công đức hồi hướng** giúp giảm bớt khổ ách, tăng duyên lành cho người mất.

**Việc nên làm cụ thể**

• Tụng Kinh Địa Tạng, A Di Đà — mỗi ngày hoặc mỗi tuần, tâm thành kính.
• Bố thí cháo, quần áo, tiền từ thiện — ghi rõ hồi hướng tên người mất.
• Giữ giới, ăn chay nhẹ nhàng — tránh sát sinh, rượu thịt trong kỳ tang.
• Sám hối, sửa đổi thói xấu — đừng để tang chỉ còn hình thức mà thiếu hành động chân thành.

**Điều nên tránh**

- Cãi vã chia tài sản ngay khi tang chưa yên.
- Đánh bạc, uống rượu, hành động trái đạo đức lấy cớ "cúng cho mẹ".
- Tin vào mê tín dị đoan, lừa đảo "cầu siêu" tốn kém mà không có chánh kiến.

**Lời nguyện gợi ý**

"Nam mô Địa Tạng Vương Bồ Tát. Con nguyện công đức tụng kinh / bố thí / trì giới hôm nay hồi hướng đến [...]. Mong người được nghe pháp, giảm khổ, sớm được siêu thoát, tái sinh cảnh giới an lạc."

49 ngày không phải phép màu — đó là khoảng thời gian vàng để cả gia đình **sống có trách nhiệm với nghiệp**, biến nỗi đau thành động lực tu tập. Người mất trông mong điều ấy hơn là chỉ một bàn cơm cúng.
TEXT,
            ],
            [
                'title' => 'Thiền hơi thở: 5 phút mỗi sáng cho người bận rộn',
                'excerpt' => 'Không cần ngồi cả giờ — chỉ vài phút chánh niệm với hơi thở đã có thể đặt nền tảng an lạc cho cả ngày.',
                'image_url' => $this->cover('thien-hoi-tho'),
                'published_at' => now()->subDays(1),
                'is_featured' => true,
                'content' => <<<'TEXT'
Nhiều người nghĩ thiền là dành cho người rảnh rỗi, ngồi trong chùa hàng giờ. Thực tế, **thiền hơi thở** (ānāpānasati) là con đường ngắn gọn mà Đức Phật thường khuyên dạy — phù hợp với người đi làm, nuôi con, lịch trình dày đặc.

**Chuẩn bị (30 giây)**

- Ngồi thẳng lưng trên ghế hoặc đệm, chân đặt sát sàn.
- Tắt thông báo điện thoại, hoặc để máy ở chế độ im lặng.
- Đặt ý: "Năm phút này dành cho tâm thanh tịnh."

**Cách thực hành (5 phút)**

1. **Phút 1–2:** Theo dõi hơi vào, hơi ra tự nhiên. Không ép thở sâu. Ghi nhận: "đang thở vào", "đang thở ra".
2. **Phút 3–4:** Khi tâm lang thang (công việc, tin nhắn, lo lắng), nhẹ nhàng biết "tâm đã đi" và đưa về hơi thở — không tự trách.
3. **Phút 5:** Hồi hướng: "Nguyện sự an lạc này lan tỏa đến gia đình và mọi chúng sinh."

**Mẹo giữ đều**

- Gắn với thói quen có sẵn: sau khi rửa mặt, trước khi mở email.
- Bắt đầu bằng 3 phút nếu 5 phút vẫn khó; tăng dần khi quen.
- Không cần tư thế ngồi kiết già hoàn hảo — quan trọng là **tỉnh táo và nhẹ nhàng**.

Thiền không phải trốn đời — mà là rèn tâm để đối diện đời bình tĩnh hơn. Năm phút mỗi sáng, kiên trì một tháng, bạn có thể tự cảm nhận sự khác biệt.
TEXT,
            ],
            [
                'title' => 'Hiểu đúng về nghiệp: không định mệnh, có trách nhiệm',
                'excerpt' => 'Nghiệp trong Phật giáo là quy luật nhân quả có thể chuyển hóa — không phải bản án vĩnh viễn khiến ta bỏ cuộc.',
                'image_url' => $this->cover('hieu-dung-nghiep'),
                'published_at' => now()->subHours(18),
                'is_featured' => false,
                'content' => <<<'TEXT'
Khi gặp nạn, người ta hay hỏi: "Phật có công bằng không?" hoặc "Sao ta khổ thế?" Câu trả lời Phật giáo không nằm ở việc đổ lỗi cho kiếp trước một cách mê tín, mà ở **hiểu nghiệp và chuyển hóa nghiệp**.

**Nghiệp là gì?**

Nghiệp (karma) là xu hướng tâm-thân được hình thành từ hành động lặp lại. Một người hay nóng giận sẽ dễ gây xung đột; một người hay từ bi sẽ được người khác tin tưởng. Quả có thể đến ngay trong đời này, hoặc trong điều kiện duyên chưa chín, có thể biểu hiện sau — đó là lý do ta không nên dùng nghiệp để phán xét người khác.

**Không phải định mệnh**

Nếu mọi thứ đã định sẵn, tu tập sẽ vô nghĩa. Đức Phật dạy: **nghiệp định hướng, duyên quyết định thời điểm, tâm hiện tại có thể chọn cách phản ứng**. Hai người cùng hoàn cảnh khó khăn, một người oán hận, một người chấp nhận và tìm cách giúp đỡ — quả an lạc khác nhau rõ rệt.

**Cách chuyển hóa nghiệp**

- **Sám hối:** Nhận lỗi thật lòng, không biện hộ.
- **Bố thí và giúp người:** Làm mềm tâm tham và ích kỷ.
- **Trì giới:** Giữ điều lành, tránh tạo thêm nghiệp xấu.
- **Tu thiền, nghe pháp:** Tăng trí tuệ, thấy rõ bản chất khổ — vô minh.

**Một câu nhớ**

"Quá khứ đã qua không sửa được từng giây — nhưng khoảnh khắc này vẫn là hạt giống mới."

Hiểu nghiệp đúng giúp ta bớt than oán, thêm hành động. Đó là tinh thần tích cực của đạo Phật, không phải sự bi quan.
TEXT,
            ],
            [
                'title' => 'Lễ Vu Lan và ý nghĩa hiếu đạo trong Phật giáo',
                'excerpt' => 'Rằm tháng Bảy không chỉ là ngày cúng — đó là dịp nhớ ơn sinh thành và nuôi dưỡng tâm từ bi qua hành động cụ thể.',
                'image_url' => $this->cover('le-vu-lan-hieu-dao'),
                'published_at' => now()->subHours(6),
                'is_featured' => false,
                'content' => <<<'TEXT'
Lễ Vu Lan (rằm tháng Bảy) gắn với câu chuyện Mục Kiền Liên cứu mẹ — tôn vinh **hiếu đạo** và lòng biết ơn. Trong Phật giáo Việt Nam, đây là dịp con cháu về chùa, tụng kinh, mặc áo hoa đà, hồi hướng công đức cho cha mẹ còn sống và đã khuất.

**Ý nghĩa sâu hơn hình thức**

Hiếu không chỉ là mua quà, làm lễ một ngày. Hiếu là:
- Lắng nghe cha mẹ khi còn có thể.
- Sửa đổi thói xấu để cha mẹ bớt lo.
- Làm việc thiện hồi hướng cho người đã mất, thay vì chỉ khóc than.

Áo hoa đà: hoa đỏ — cha mẹ còn sống; hoa trắng — cha mẹ đã mất. Đó là biểu tượng nhắc ta **sống hiếu khi người thân còn ở bên**, không đợi đến khi không còn cơ hội.

**Việc nên làm trong dịp Vu Lan**

1. Về thăm, nói lời yêu thương, xin lỗi nếu từng làm cha mẹ buồn.
2. Tụng kinh Vu Lan, Báo Hiếu Phụng Mẫu, hoặc Kinh A Di Đà — tại chùa hoặc tại nhà trang nghiêm.
3. Bố thí, giúp người già neo đơn, trẻ mồ côi — mang tên cha mẹ hồi hướng.
4. Giữ giới, ăn chay ít nhất trong ngày rằm — nuôi lòng từ bi.

**Tránh lệch lạc**

- Vu Lan thành cuộc đua sắm lễ, tiệc tùng ồn ào.
- Cúng kiến thiết nhưng vẫn hành động bất thiện với cha mẹ hoặc anh em.

Vu Lan là **mùa của tâm biết ơn**. Dù không phải tháng Bảy, mỗi ngày vẫn có thể là Vu Lan nếu ta sống hiếu thảo và hồi hướng phước báu — đó mới là đạo hiếu đúng nghĩa Phật giáo.
TEXT,
            ],
        ];

        foreach ($articles as $row) {
            Post::query()->updateOrCreate(
                ['title' => $row['title']],
                $row
            );
        }
    }
}
