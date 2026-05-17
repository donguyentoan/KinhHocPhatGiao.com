<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Scripture;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $forgetSitemap = static fn () => Cache::forget('seo.sitemap.xml');

        Post::saved($forgetSitemap);
        Post::deleted($forgetSitemap);
        Scripture::saved($forgetSitemap);
        Scripture::deleted($forgetSitemap);
    }
}
