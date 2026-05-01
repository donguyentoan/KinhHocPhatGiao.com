<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Scripture;
use App\Models\ScriptureCategory;
use App\Models\Utility;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.home')]
class HomePage extends Component
{
    public function render()
    {
        $popularScriptures = Scripture::query()->with('category')->latest()->take(4)->get()
            ->map(function (Scripture $scripture) {
                $scripture->image_url = $this->resolveImageUrl($scripture->image_url);

                return $scripture;
            });

        return view('livewire.home-page', [
            'utilities' => Utility::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'categories' => ScriptureCategory::query()->withCount('scriptures')->get(),
            'popularScriptures' => $popularScriptures,
            'popularPosts' => Post::query()->latest('published_at')->take(4)->get(),
        ]);
    }

    private function resolveImageUrl(?string $imageUrl): string
    {
        if (blank($imageUrl)) {
            return '';
        }

        if (!Str::startsWith($imageUrl, '/storage/')) {
            return $imageUrl;
        }

        $relativePath = ltrim(Str::after($imageUrl, '/storage/'), '/');
        $publicPath = public_path('storage/' . $relativePath);
        $storagePath = storage_path('app/public/' . $relativePath);

        if (!file_exists($publicPath) && file_exists($storagePath)) {
            $targetDirectory = dirname($publicPath);
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }
            copy($storagePath, $publicPath);
        }

        return url('/storage/' . $relativePath);
    }
}
