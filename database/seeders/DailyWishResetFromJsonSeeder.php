<?php

namespace Database\Seeders;

use App\Models\DailyWish;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Xóa toàn bộ daily_wishes và nhập lại từ resources/data/daily_wishes.json.
 * Chạy: php artisan db:seed --class=DailyWishResetFromJsonSeeder
 */
class DailyWishResetFromJsonSeeder extends Seeder
{
    public function run(): void
    {
        $path = resource_path('data/daily_wishes.json');
        if (! is_readable($path)) {
            $this->command?->warn('Không đọc được daily_wishes.json');

            return;
        }

        $decoded = json_decode((string) file_get_contents($path), true);
        if (! is_array($decoded)) {
            $this->command?->warn('JSON không hợp lệ');

            return;
        }

        DB::transaction(function () use ($decoded) {
            DailyWish::query()->delete();

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
        });

        $this->command?->info('Đã đồng bộ '.DailyWish::query()->count().' lời nguyện từ JSON.');
    }
}
