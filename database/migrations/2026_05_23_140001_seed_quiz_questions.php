<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\QuizQuestionSeeder',
            '--force' => true,
        ]);
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('quiz_questions')->truncate();
    }
};
