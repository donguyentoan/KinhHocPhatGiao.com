<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Scripture;
use App\Models\ScriptureCategory;
use App\Models\VegetarianRecipe;
use App\Services\SitemapBuilder;
use Illuminate\Support\Facades\View;
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
        $forgetSitemap = static fn () => SitemapBuilder::forgetAllCaches();

        Post::saved($forgetSitemap);
        Post::deleted($forgetSitemap);
        VegetarianRecipe::saved($forgetSitemap);
        VegetarianRecipe::deleted($forgetSitemap);
        Scripture::saved($forgetSitemap);
        Scripture::deleted($forgetSitemap);

        View::composer('components.site-footer', function ($view): void {
            $view->with(
                'footerCategories',
                ScriptureCategory::query()->withCount('scriptures')->orderBy('id')->get()
            );
        });
    }
}
