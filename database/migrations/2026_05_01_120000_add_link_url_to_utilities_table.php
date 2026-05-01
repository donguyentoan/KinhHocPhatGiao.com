<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('utilities', function (Blueprint $table) {
            $table->string('link_url', 2048)->nullable()->after('icon_url');
        });

        $map = [
            'Máy niệm phật' => '/tien-ich/may-niem-phat',
            'Đọc kinh' => '/#thu-vien-kinh-dien',
            'Ngồi thiền' => '/tien-ich/ngoi-thien',
            'Chuông mõ' => '/tien-ich/chuong-mo',
            'Lần chuỗi hạt' => '/tien-ich/lan-chuoi-hat',
            'Nhạc thiền' => '/tien-ich/nhac-thien',
            'Sự kiện trong năm' => '/tien-ich/su-kien-trong-nam',
            'Liên hệ hỗ trợ' => '/tien-ich/lien-he-ho-tro',
        ];

        foreach ($map as $name => $url) {
            DB::table('utilities')->where('name', $name)->update(['link_url' => $url]);
        }
    }

    public function down(): void
    {
        Schema::table('utilities', function (Blueprint $table) {
            $table->dropColumn('link_url');
        });
    }
};
