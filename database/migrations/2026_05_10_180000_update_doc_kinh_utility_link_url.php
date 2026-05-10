<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('utilities')->where('name', 'Đọc kinh')->update([
            'link_url' => '/tien-ich/doc-kinh',
        ]);
    }

    public function down(): void
    {
        DB::table('utilities')->where('name', 'Đọc kinh')->update([
            'link_url' => '/#thu-vien-kinh-dien',
        ]);
    }
};
