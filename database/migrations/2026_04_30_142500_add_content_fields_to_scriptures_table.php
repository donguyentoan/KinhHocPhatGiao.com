<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scriptures', function (Blueprint $table) {
            $table->longText('content_text')->nullable()->after('summary');
            $table->string('content_file_path')->nullable()->after('content_text');
        });
    }

    public function down(): void
    {
        Schema::table('scriptures', function (Blueprint $table) {
            $table->dropColumn(['content_text', 'content_file_path']);
        });
    }
};
