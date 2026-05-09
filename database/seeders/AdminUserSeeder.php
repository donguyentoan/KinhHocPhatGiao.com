<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['phone' => '0344842232'],
            [
                'name' => 'Quản trị',
                'email' => '0344842232@phone.local',
                'password' => 'Aa123123!',
                'is_admin' => true,
            ]
        );
    }
}
