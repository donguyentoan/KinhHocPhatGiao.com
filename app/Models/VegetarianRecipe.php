<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VegetarianRecipe extends Model
{
    use HasFactory;

    public const DIFFICULTY_DE = 'de';

    public const DIFFICULTY_TRUNG_BINH = 'trung-binh';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'ingredients',
        'content',
        'health_tips',
        'image_url',
        'prep_minutes',
        'servings',
        'difficulty',
        'published_at',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'prep_minutes' => 'integer',
        'servings' => 'integer',
        'sort_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->lte(now());
    }

    public function teaser(): string
    {
        if (filled($this->excerpt)) {
            return $this->excerpt;
        }

        return Str::limit(preg_replace('/\s+/', ' ', (string) $this->content), 160);
    }

    public function difficultyLabel(): string
    {
        return match ($this->difficulty) {
            self::DIFFICULTY_TRUNG_BINH => 'Trung bình',
            default => 'Dễ',
        };
    }

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

    public static function slugFromTitle(string $title): string
    {
        return Str::slug($title) ?: 'mon-chay';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('published_at');
    }
}
