<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Search engine indexing
    |--------------------------------------------------------------------------
    |
    | When false, robots.txt disallows all crawlers and sitemap returns 404.
    | Defaults to true only in the production environment.
    |
    */

    'indexing_enabled' => env('SEO_INDEXING_ENABLED', env('APP_ENV') === 'production'),

    'default_description' => env(
        'SEO_DEFAULT_DESCRIPTION',
        'Kinh Học Phật Giáo — đọc kinh Phật online, thiền định, máy niệm và tiện ích thực hành Phật giáo mỗi ngày.'
    ),

    /*
    |--------------------------------------------------------------------------
    | Sitemap cache
    |--------------------------------------------------------------------------
    */

    'sitemap_cache_seconds' => (int) env('SEO_SITEMAP_CACHE_SECONDS', 3600),

    /*
    |--------------------------------------------------------------------------
    | Paths disallowed in robots.txt (path prefixes)
    |--------------------------------------------------------------------------
    */

    'robots_disallow' => [
        '/dashboard',
        '/dang-nhap',
        '/dang-ky',
        '/tai-khoan',
        '/dang-xuat',
        '/scriptures/*/pdf',
        '/livewire',
    ],

    /*
    |--------------------------------------------------------------------------
    | Crawlers explicitly welcomed in robots.txt
    |--------------------------------------------------------------------------
    |
    | Each entry gets Allow: / plus the disallowed admin paths above.
    | Includes Google and common AI/search crawlers.
    |
    */

    'robots_user_agents' => [
        '*',
        'Googlebot',
        'Googlebot-Image',
        'Google-Extended',
        'GPTBot',
        'ChatGPT-User',
        'ClaudeBot',
        'anthropic-ai',
        'PerplexityBot',
        'Bytespider',
        'CCBot',
        'Amazonbot',
        'Applebot-Extended',
        'cohere-ai',
        'Meta-ExternalAgent',
        'FacebookBot',
        'Diffbot',
        'Omgilibot',
        'YouBot',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap URL priorities & change frequencies
    |--------------------------------------------------------------------------
    */

    'priorities' => [
        'home' => '1.0',
        'tools' => '0.7',
        'tools_doc_kinh' => '0.9',
        'scriptures' => '0.8',
        'posts' => '0.7',
    ],

    'changefreq' => [
        'home' => 'daily',
        'tools' => 'monthly',
        'tools_doc_kinh' => 'weekly',
        'scriptures' => 'monthly',
        'posts' => 'weekly',
    ],

];
