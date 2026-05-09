<?php

namespace Database\Seeders;

use App\Models\DailyWish;
use Illuminate\Database\Seeder;

class DailyWishSeeder extends Seeder
{
    public function run(): void
    {
        if (DailyWish::query()->exists()) {
            return;
        }

        $path = resource_path('data/daily_wishes.json');
        if (! is_readable($path)) {
            return;
        }

        $decoded = json_decode((string) file_get_contents($path), true);
        if (! is_array($decoded)) {
            return;
        }

        foreach ($decoded as $index => $row) {
            if (! is_array($row) || empty($row['text'])) {
                continue;
            }

            DailyWish::query()->create([
                'text' => (string) $row['text'],
                'icon' => in_array($row['icon'] ?? '', ['lotus', 'light', 'meditation'], true)
                    ? $row['icon']
                    : 'lotus',
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
