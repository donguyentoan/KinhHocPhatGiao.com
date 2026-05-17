<?php

namespace App\Http\Controllers;

use App\Services\SitemapBuilder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    public function robots(): Response
    {
        if (! config('seo.indexing_enabled')) {
            return $this->plainResponse("User-agent: *\nDisallow: /\n");
        }

        $lines = [
            'User-agent: *',
        ];

        foreach (config('seo.robots_disallow', []) as $path) {
            $lines[] = 'Disallow: '.$path;
        }

        $lines[] = '';
        $lines[] = 'Sitemap: '.route('seo.sitemap');

        return $this->plainResponse(implode("\n", $lines)."\n");
    }

    public function sitemap(SitemapBuilder $builder): Response
    {
        if (! config('seo.indexing_enabled')) {
            abort(404);
        }

        $cacheSeconds = max(0, (int) config('seo.sitemap_cache_seconds', 3600));

        $xml = $cacheSeconds > 0
            ? Cache::remember('seo.sitemap.xml', $cacheSeconds, fn () => $builder->toXml())
            : $builder->toXml();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age='.$cacheSeconds,
        ]);
    }

    private function plainResponse(string $body): Response
    {
        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
