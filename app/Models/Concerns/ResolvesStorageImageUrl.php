<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait ResolvesStorageImageUrl
{
    /** URL ảnh hiển thị — chuẩn hóa /storage/ giống trang chủ. */
    protected function resolveStorageImageUrl(?string $imageUrl): string
    {
        if (blank($imageUrl)) {
            return '';
        }

        if (! Str::startsWith($imageUrl, '/storage/')) {
            return $imageUrl;
        }

        $relativePath = ltrim(Str::after($imageUrl, '/storage/'), '/');
        $publicPath = public_path('storage/'.$relativePath);
        $storagePath = storage_path('app/public/'.$relativePath);

        if (! file_exists($publicPath) && file_exists($storagePath)) {
            $targetDirectory = dirname($publicPath);
            if (! is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }
            copy($storagePath, $publicPath);
        }

        return url('/storage/'.$relativePath);
    }
}
