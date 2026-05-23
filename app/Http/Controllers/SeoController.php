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

        return $this->plainResponse($this->buildRobotsTxt());
    }

    private function buildRobotsTxt(): string
    {
        $lines = [];
        $disallow = config('seo.robots_disallow', []);
        $userAgents = config('seo.robots_user_agents', ['*']);

        foreach ($userAgents as $userAgent) {
            $lines[] = 'User-agent: '.$userAgent;
            $lines[] = 'Allow: /';

            foreach ($disallow as $path) {
                $lines[] = 'Disallow: '.$path;
            }

            $lines[] = '';
        }

        $lines[] = 'Sitemap: '.route('seo.sitemap');

        return implode("\n", $lines)."\n";
    }

    public function sitemap(SitemapBuilder $builder): Response
    {
        if (! config('seo.indexing_enabled')) {
            abort(404);
        }

        return $this->xmlResponse(
            SitemapBuilder::indexCacheKey(),
            fn () => $builder->toIndexXml(),
        );
    }

    public function sitemapSection(string $type, SitemapBuilder $builder): Response
    {
        if (! config('seo.indexing_enabled')) {
            abort(404);
        }

        if (! SitemapBuilder::isValidSection($type)) {
            abort(404);
        }

        if ($builder->sectionEntries($type) === []) {
            abort(404);
        }

        return $this->xmlResponse(
            SitemapBuilder::sectionCacheKey($type),
            fn () => $builder->toSectionXml($type),
        );
    }

    private function xmlResponse(string $cacheKey, callable $generator): Response
    {
        $cacheSeconds = max(0, (int) config('seo.sitemap_cache_seconds', 3600));

        $xml = $cacheSeconds > 0
            ? Cache::remember($cacheKey, $cacheSeconds, $generator)
            : $generator();

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
