<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('utilities')->where('name', 'Chuông mõ')->delete();
    }

    public function down(): void
    {
        if (DB::table('utilities')->where('name', 'Chuông mõ')->exists()) {
            return;
        }

        $maxOrder = (int) DB::table('utilities')->max('sort_order');

        DB::table('utilities')->insert([
            'name' => 'Chuông mõ',
            'link_url' => '/tien-ich/chuong-mo',
            'icon_url' => null,
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
