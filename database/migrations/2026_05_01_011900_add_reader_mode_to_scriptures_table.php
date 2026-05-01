<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scriptures', function (Blueprint $table) {
            $table->string('reader_mode', 20)->default('auto')->after('content_file_path');
        });
    }

    public function down(): void
    {
        Schema::table('scriptures', function (Blueprint $table) {
            $table->dropColumn('reader_mode');
        });
    }
};
