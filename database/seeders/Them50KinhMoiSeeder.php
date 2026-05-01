<?php

namespace Database\Seeders;

use App\Models\Scripture;
use App\Models\ScriptureCategory;
use Illuminate\Database\Seeder;

class Them50KinhMoiSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = ScriptureCategory::query()->firstOrCreate(
            ['name' => 'Hệ Thống Kinh'],
            ['description' => 'Các bộ kinh căn bản từ sơ cấp đến đại thừa.', 'color_class' => 'text-[#8b5e34]']
        )->id;

        $rows = [
            ['title' => 'Kinh sưu tầm 001 - 01KinhHoaNghiemTap1 THICH TRI TINH', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/01KinhHoaNghiemTap1_THICH_TRI_TINH.pdf', 'path' => 'scriptures/pdf/001-01kinhhoanghiemtap1-thich-tri-tinh.pdf'],
            ['title' => 'Kinh sưu tầm 002 - 02KinhHoaNghiemTap2 THICH TRI TINH', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/02KinhHoaNghiemTap2_THICH_TRI_TINH.pdf', 'path' => 'scriptures/pdf/002-02kinhhoanghiemtap2-thich-tri-tinh.pdf'],
            ['title' => 'Kinh sưu tầm 003 - 03KinhHoaNghiemTap3 THICH TRI TINH', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/03KinhHoaNghiemTap3_THICH_TRI_TINH.pdf', 'path' => 'scriptures/pdf/003-03kinhhoanghiemtap3-thich-tri-tinh.pdf'],
            ['title' => 'Kinh sưu tầm 004 - 04KinhHoaNghiemTap4 THICH TRI TINH', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/04KinhHoaNghiemTap4_THICH_TRI_TINH.pdf', 'path' => 'scriptures/pdf/004-04kinhhoanghiemtap4-thich-tri-tinh.pdf'],
            ['title' => 'Kinh sưu tầm 005 - 50 Hien Tuong Am Ma', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/50-Hien-Tuong-Am-Ma.pdf', 'path' => 'scriptures/pdf/005-50-hien-tuong-am-ma.pdf'],
            ['title' => 'Kinh sưu tầm 006 - AMLUATVOTINH', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/AMLUATVOTINH.pdf', 'path' => 'scriptures/pdf/006-amluatvotinh.pdf'],
            ['title' => 'Kinh sưu tầm 007 - Bat Chanh Dao Tu Dieu De', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Bat_Chanh_Dao__Tu_Dieu_De.pdf', 'path' => 'scriptures/pdf/007-bat-chanh-dao-tu-dieu-de.pdf'],
            ['title' => 'Kinh sưu tầm 008 - BÁT CHÁNH ĐẠO', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/B%C3%81T%20-%20CH%C3%81NH%20-%20%C4%90%E1%BA%A0O.pdf', 'path' => 'scriptures/pdf/008-bat-chanh-ao.pdf'],
            ['title' => 'Kinh sưu tầm 009 - BÁT CHÁNH ĐẠO', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/B%C3%81T%20CH%C3%81NH%20%C4%90%E1%BA%A0O.pdf', 'path' => 'scriptures/pdf/009-bat-chanh-ao.pdf'],
            ['title' => 'Kinh sưu tầm 010 - CHUDAIBIGIANGGIAI', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/CHUDAIBIGIANGGIAI.pdf', 'path' => 'scriptures/pdf/010-chudaibigianggiai.pdf'],
            ['title' => 'Kinh sưu tầm 011 - Chu Thu Lang Nghiem', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Chu-Thu-Lang-Nghiem.pdf', 'path' => 'scriptures/pdf/011-chu-thu-lang-nghiem.pdf'],
            ['title' => 'Kinh sưu tầm 012 - ChuThuLangNghiem', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/ChuThuLangNghiem.pdf', 'path' => 'scriptures/pdf/012-chuthulangnghiem.pdf'],
            ['title' => 'Kinh sưu tầm 013 - DATMATOSU', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/DATMATOSU.pdf', 'path' => 'scriptures/pdf/013-datmatosu.pdf'],
            ['title' => 'Kinh sưu tầm 014 - Dieu Phap Lien Hoa Kinh', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Dieu_Phap_Lien_Hoa_Kinh.pdf', 'path' => 'scriptures/pdf/014-dieu-phap-lien-hoa-kinh.pdf'],
            ['title' => 'Kinh sưu tầm 015 - Giang Giai Kinh Lang Nghiem', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Giang-Giai-Kinh-Lang-Nghiem.pdf', 'path' => 'scriptures/pdf/015-giang-giai-kinh-lang-nghiem.pdf'],
            ['title' => 'Kinh sưu tầm 016 - HUONGQUECUCLAC', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/HUONGQUECUCLAC.pdf', 'path' => 'scriptures/pdf/016-huongquecuclac.pdf'],
            ['title' => 'Kinh sưu tầm 017 - KINH LANG NGHIEM', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINH-LANG-NGHIEM.pdf', 'path' => 'scriptures/pdf/017-kinh-lang-nghiem.pdf'],
            ['title' => 'Kinh sưu tầm 018 - KINH THU LANG NGHIEM', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINH-THU-LANG-NGHIEM.pdf', 'path' => 'scriptures/pdf/018-kinh-thu-lang-nghiem.pdf'],
            ['title' => 'Kinh sưu tầm 019 - KINH VO LUONG THO', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINH-VO-LUONG-THO.pdf', 'path' => 'scriptures/pdf/019-kinh-vo-luong-tho.pdf'],
            ['title' => 'Kinh sưu tầm 020 - KINHBATNHA Q2', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHBATNHA-Q2.pdf', 'path' => 'scriptures/pdf/020-kinhbatnha-q2.pdf'],
            ['title' => 'Kinh sưu tầm 021 - KINHDAIBIDALANI', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHDAIBIDALANI.pdf', 'path' => 'scriptures/pdf/021-kinhdaibidalani.pdf'],
            ['title' => 'Kinh sưu tầm 022 - KINHHOANGHIEM Q1', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHHOANGHIEM-Q1.pdf', 'path' => 'scriptures/pdf/022-kinhhoanghiem-q1.pdf'],
            ['title' => 'Kinh sưu tầm 023 - KINHHOANGHIEM Q2', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHHOANGHIEM-Q2.pdf', 'path' => 'scriptures/pdf/023-kinhhoanghiem-q2.pdf'],
            ['title' => 'Kinh sưu tầm 024 - KINHHOANGHIEMDAIPHUONGQUANGPHAT Q3', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHHOANGHIEMDAIPHUONGQUANGPHAT-Q3.pdf', 'path' => 'scriptures/pdf/024-kinhhoanghiemdaiphuongquangphat-q3.pdf'],
            ['title' => 'Kinh sưu tầm 025 - KINHKIMCANGBATNHABALAMATDA', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHKIMCANGBATNHABALAMATDA.pdf', 'path' => 'scriptures/pdf/025-kinhkimcangbatnhabalamatda.pdf'],
            ['title' => 'Kinh sưu tầm 026 - KINHLUONGHOANGSAM', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHLUONGHOANGSAM.pdf', 'path' => 'scriptures/pdf/026-kinhluonghoangsam.pdf'],
            ['title' => 'Kinh sưu tầm 027 - KINHMAHABATNHABALAMAT Q1', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHMAHABATNHABALAMAT-Q1.pdf', 'path' => 'scriptures/pdf/027-kinhmahabatnhabalamat-q1.pdf'],
            ['title' => 'Kinh sưu tầm 028 - KINHMAHABATNHABALAMAT Q3', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHMAHABATNHABALAMAT-Q3.pdf', 'path' => 'scriptures/pdf/028-kinhmahabatnhabalamat-q3.pdf'],
            ['title' => 'Kinh sưu tầm 029 - KINHTHULANGNGHIEM GIANG GIAI', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHTHULANGNGHIEM-GIANG-GIAI.pdf', 'path' => 'scriptures/pdf/029-kinhthulangnghiem-giang-giai.pdf'],
            ['title' => 'Kinh sưu tầm 030 - KINHTHULANGNGHIEM', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KINHTHULANGNGHIEM.pdf', 'path' => 'scriptures/pdf/030-kinhthulangnghiem.pdf'],
            ['title' => 'Kinh sưu tầm 031 - Kinh Tứ Niệm Xứ', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinh%20T%E1%BB%A9%20Ni%E1%BB%87m%20X%E1%BB%A9.pdf', 'path' => 'scriptures/pdf/031-kinh-tu-niem-xu.pdf'],
            ['title' => 'Kinh sưu tầm 032 - Kinh Dia Tang Giang Giai', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinh-Dia-Tang-Giang-Giai.pdf', 'path' => 'scriptures/pdf/032-kinh-dia-tang-giang-giai.pdf'],
            ['title' => 'Kinh sưu tầm 033 - Kinh Dia Tang Giang Ky', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinh-Dia-Tang-Giang-Ky.pdf', 'path' => 'scriptures/pdf/033-kinh-dia-tang-giang-ky.pdf'],
            ['title' => 'Kinh sưu tầm 034 - Kinh Lăng Nghiêm Giang Giai Hoa Thuong Tuyen Hoa', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinh-L%C4%83ng-Nghi%C3%AAm-Giang-Giai-Hoa-Thuong-Tuyen-Hoa.pdf', 'path' => 'scriptures/pdf/034-kinh-lang-nghiem-giang-giai-hoa-thuong-tuyen-hoa.pdf'],
            ['title' => 'Kinh sưu tầm 035 - Kinh Tu Niem Xu', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinh-Tu-Niem-Xu.pdf', 'path' => 'scriptures/pdf/035-kinh-tu-niem-xu.pdf'],
            ['title' => 'Kinh sưu tầm 036 - KinhDiaTang', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhDiaTang.pdf', 'path' => 'scriptures/pdf/036-kinhdiatang.pdf'],
            ['title' => 'Kinh sưu tầm 037 - KinhDiaTangBoTat', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhDiaTangBoTat.pdf', 'path' => 'scriptures/pdf/037-kinhdiatangbotat.pdf'],
            ['title' => 'Kinh sưu tầm 038 - KinhDiaTangBoTatBonNguyen', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhDiaTangBoTatBonNguyen.pdf', 'path' => 'scriptures/pdf/038-kinhdiatangbotatbonnguyen.pdf'],
            ['title' => 'Kinh sưu tầm 039 - KinhDiaTangGiangKy', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhDiaTangGiangKy.pdf', 'path' => 'scriptures/pdf/039-kinhdiatanggiangky.pdf'],
            ['title' => 'Kinh sưu tầm 040 - KinhHoaNghiem', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhHoaNghiem.pdf', 'path' => 'scriptures/pdf/040-kinhhoanghiem.pdf'],
            ['title' => 'Kinh sưu tầm 041 - KinhLangNghiem', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhLangNghiem.pdf', 'path' => 'scriptures/pdf/041-kinhlangnghiem.pdf'],
            ['title' => 'Kinh sưu tầm 042 - KinhPhapHoa', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhPhapHoa.pdf', 'path' => 'scriptures/pdf/042-kinhphaphoa.pdf'],
            ['title' => 'Kinh sưu tầm 043 - KinhPhatDanhTonThangDaRaNi', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/KinhPhatDanhTonThangDaRaNi.pdf', 'path' => 'scriptures/pdf/043-kinhphatdanhtonthangdarani.pdf'],
            ['title' => 'Kinh sưu tầm 044 - Kinh Hoa Nghiem Dai Phuong.Quang', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinh_Hoa_Nghiem_Dai_Phuong.Quang.pdf', 'path' => 'scriptures/pdf/044-kinh-hoa-nghiem-dai-phuong-quang.pdf'],
            ['title' => 'Kinh sưu tầm 045 - Kinh Tu Niem Xu', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinh_Tu_Niem_Xu.pdf', 'path' => 'scriptures/pdf/045-kinh-tu-niem-xu.pdf'],
            ['title' => 'Kinh sưu tầm 046 - Kinhtuniemxu', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Kinhtuniemxu.pdf', 'path' => 'scriptures/pdf/046-kinhtuniemxu.pdf'],
            ['title' => 'Kinh sưu tầm 047 - LinhVanCuaTroiDatCuuTheGioi', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/LinhVanCuaTroiDatCuuTheGioi.pdf', 'path' => 'scriptures/pdf/047-linhvancuatroidatcuuthegioi.pdf'],
            ['title' => 'Kinh sưu tầm 048 - PHAPBAODANKINH', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/PHAPBAODANKINH.pdf', 'path' => 'scriptures/pdf/048-phapbaodankinh.pdf'],
            ['title' => 'Kinh sưu tầm 049 - Phap Bao Dan Kinh Giang Giai PDF', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/Phap-Bao-Dan-Kinh-Giang-Giai-PDF.pdf', 'path' => 'scriptures/pdf/049-phap-bao-dan-kinh-giang-giai-pdf.pdf'],
            ['title' => 'Kinh sưu tầm 050 - QUANVOLUONGTHOKINH', 'summary' => 'Nguồn PDF công khai: https://raw.githubusercontent.com/kinhlangnghiem/nammoadidaphat/master/QUANVOLUONGTHOKINH.pdf', 'path' => 'scriptures/pdf/050-quanvoluongthokinh.pdf'],
        ];

        foreach ($rows as $row) {
            Scripture::query()->updateOrCreate(
                ['title' => $row['title']],
                [
                    'summary' => $row['summary'],
                    'content_text' => null,
                    'content_file_path' => $row['path'],
                    'duration_minutes' => 45,
                    'chant_count' => 0,
                    'image_url' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&q=80&w=500',
                    'reader_mode' => 'pdf',
                    'category_id' => $categoryId,
                ]
            );
        }
    }
}
