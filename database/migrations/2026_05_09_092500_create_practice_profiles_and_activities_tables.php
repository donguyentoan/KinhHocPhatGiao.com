<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practice_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('session_key', 120)->unique();
            $table->string('dharma_name')->default('Thiện hữu');
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });

        Schema::create('practice_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_profile_id')->constrained()->cascadeOnDelete();
            $table->string('activity_type', 50);
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->date('practiced_on');
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['practice_profile_id', 'practiced_on']);
            $table->index(['activity_type', 'practiced_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practice_activities');
        Schema::dropIfExists('practice_profiles');
    }
};
