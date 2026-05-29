<?php

namespace App\Models;

use App\Models\Concerns\ResolvesStorageImageUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    use ResolvesStorageImageUrl;

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

    public function resolvedImageUrl(): string
    {
        return $this->resolveStorageImageUrl($this->image_url);
    }
}
