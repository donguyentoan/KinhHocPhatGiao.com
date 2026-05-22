<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('utilities')->where('name', 'Cây Bồ Đề Pháp Cú')->exists();

        if ($exists) {
            DB::table('utilities')->where('name', 'Cây Bồ Đề Pháp Cú')->update([
                'link_url' => '/tien-ich/hai-loc-phap-cu',
                'is_active' => true,
            ]);

            return;
        }

        $maxOrder = (int) DB::table('utilities')->max('sort_order');

        DB::table('utilities')->insert([
            'name' => 'Cây Bồ Đề Pháp Cú',
            'icon_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK3vqaAlAVrF3ICG82_XpZPi4ebsNR1HEd-Q&s',
            'link_url' => '/tien-ich/hai-loc-phap-cu',
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('utilities')->where('name', 'Cây Bồ Đề Pháp Cú')->delete();
    }
};
