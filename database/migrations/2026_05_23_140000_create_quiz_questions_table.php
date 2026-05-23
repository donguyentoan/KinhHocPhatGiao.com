<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('topic', 120);
            $table->text('question');
            $table->string('option_a', 500);
            $table->string('option_b', 500);
            $table->string('option_c', 500);
            $table->string('option_d', 500);
            $table->char('correct_answer', 1);
            $table->text('explanation');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
