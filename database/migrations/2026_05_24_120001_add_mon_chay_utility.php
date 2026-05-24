<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('utilities')->where('link_url', '/mon-chay')->exists();
        if ($exists) {
            return;
        }

        $maxOrder = (int) DB::table('utilities')->max('sort_order');

        DB::table('utilities')->insert([
            'name' => 'Món chay thanh đạm',
            'icon_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=128&q=80',
            'link_url' => '/mon-chay',
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('utilities')->where('link_url', '/mon-chay')->delete();
    }
};
