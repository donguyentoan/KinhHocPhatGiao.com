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
        'content',
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

    /** Nội dung hiển thị trên trang chi tiết (ưu tiên content, sau đó excerpt). */
    public function body(): string
    {
        if (filled($this->content)) {
            return $this->content;
        }

        return $this->excerpt ?? '';
    }

    /** Mô tả ngắn cho danh sách / SEO khi chưa có excerpt. */
    public function teaser(): string
    {
        if (filled($this->excerpt)) {
            return $this->excerpt;
        }

        return Str::limit(preg_replace('/\s+/', ' ', $this->body()), 160);
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
