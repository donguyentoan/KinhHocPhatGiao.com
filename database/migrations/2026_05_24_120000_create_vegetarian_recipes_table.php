<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vegetarian_recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('content')->nullable();
            $table->text('health_tips')->nullable();
            $table->string('image_url')->nullable();
            $table->unsignedSmallInteger('prep_minutes')->nullable();
            $table->unsignedTinyInteger('servings')->nullable();
            $table->string('difficulty', 20)->default('de');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vegetarian_recipes');
    }
};
