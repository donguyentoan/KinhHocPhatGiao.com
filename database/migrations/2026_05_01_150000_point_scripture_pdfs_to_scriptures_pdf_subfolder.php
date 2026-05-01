<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * PDF tải về / lưu trữ nằm trong storage/app/public/scriptures/pdf/.
 * Cập nhật bản ghi đã seed với đường dẫn cũ (trực tiếp dưới scriptures/).
 */
return new class extends Migration
{
    private const OLD_PATH = 'scriptures/kinh-dia-tang-bo-tat-bon-nguyen.pdf';

    private const NEW_PATH = 'scriptures/pdf/kinh-dia-tang-bo-tat-bon-nguyen.pdf';

    public function up(): void
    {
        DB::table('scriptures')
            ->where('content_file_path', self::OLD_PATH)
            ->update([
                'content_file_path' => self::NEW_PATH,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('scriptures')
            ->where('content_file_path', self::NEW_PATH)
            ->update([
                'content_file_path' => self::OLD_PATH,
                'updated_at' => now(),
            ]);
    }
};
