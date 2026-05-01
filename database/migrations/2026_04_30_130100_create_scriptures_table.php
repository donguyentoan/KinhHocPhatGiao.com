<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scriptures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->unsignedInteger('duration_minutes')->default(0);
            $table->unsignedInteger('chant_count')->default(0);
            $table->string('image_url')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('scripture_categories')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scriptures');
    }
};
