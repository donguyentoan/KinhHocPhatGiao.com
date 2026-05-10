<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'excerpt',
        'image_url',
        'published_at',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->lte(now());
    }

    /** URL ảnh hiển thị (đồng bộ logic với trang chủ / storage). */
    public function resolvedImageUrl(): string
    {
        $imageUrl = $this->image_url;
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
