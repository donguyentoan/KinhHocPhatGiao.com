<?php

namespace Tests\Feature;

use App\Services\SitemapBuilder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SeoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.url' => 'https://kinhhocphatgiaocom.test',
            'seo.indexing_enabled' => true,
            'seo.sitemap_cache_seconds' => 0,
        ]);

        URL::forceRootUrl('https://kinhhocphatgiaocom.test');

        Cache::flush();
    }

    public function test_robots_txt_lists_disallowed_paths_and_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $this->assertStringContainsString('text/plain', (string) $response->headers->get('Content-Type'));

        $body = $response->getContent();
        $this->assertStringContainsString('User-agent: *', $body);
        $this->assertStringContainsString('Disallow: /dashboard', $body);
        $this->assertStringContainsString('Disallow: /scriptures/*/pdf', $body);
        $this->assertStringContainsString('Sitemap: '.route('seo.sitemap'), $body);
    }

    public function test_robots_txt_blocks_all_crawlers_when_indexing_disabled(): void
    {
        config(['seo.indexing_enabled' => false]);

        $response = $this->get('/robots.txt');

        $response->assertOk();
        $this->assertStringContainsString('Disallow: /', $response->getContent());
        $this->assertStringNotContainsString('Sitemap:', $response->getContent());
    }

    public function test_sitemap_xml_is_valid_and_includes_core_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringContainsString('application/xml', (string) $response->headers->get('Content-Type'));

        $xml = $response->getContent();
        $this->assertNotFalse(simplexml_load_string($xml));

        $this->assertStringContainsString('<loc>'.route('home').'</loc>', $xml);
        $this->assertStringContainsString('<loc>'.route('tools.show', 'doc-kinh').'</loc>', $xml);
        $this->assertStringContainsString('<loc>'.route('tools.show', 'may-niem-phat').'</loc>', $xml);
    }

    public function test_sitemap_returns_not_found_when_indexing_disabled(): void
    {
        config(['seo.indexing_enabled' => false]);

        $this->get('/sitemap.xml')->assertNotFound();
    }

    public function test_home_page_includes_canonical_link(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $this->assertStringContainsString(
            'rel="canonical" href="'.route('home').'"',
            $response->getContent()
        );
    }

    public function test_sitemap_builder_deduplicates_locations(): void
    {
        $builder = new SitemapBuilder;

        $deduped = $builder->dedupeByLocation([
            [
                'loc' => 'https://example.test/a',
                'lastmod' => null,
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
            [
                'loc' => 'https://example.test/a',
                'lastmod' => null,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
        ]);

        $this->assertCount(1, $deduped);
        $this->assertSame('https://example.test/a', $deduped[0]['loc']);
    }
}
