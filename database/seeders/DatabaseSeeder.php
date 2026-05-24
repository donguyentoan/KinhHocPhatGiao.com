<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            BuddhistContentSeeder::class,
            PostArticlesSeeder::class,
            VegetarianRecipeSeeder::class,
            DiaTangKinhSeeder::class,
            PhapHoaSamHoiNguoiAoTrangSeeder::class,
            ThemNhieuKinhSeeder::class,
            Them50KinhMoiSeeder::class,
            DailyWishSeeder::class,
            QuizQuestionSeeder::class,
        ]);
    }
}
