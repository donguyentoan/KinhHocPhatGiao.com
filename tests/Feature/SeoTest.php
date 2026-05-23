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
        $this->assertStringContainsString('User-agent: Googlebot', $body);
        $this->assertStringContainsString('User-agent: GPTBot', $body);
        $this->assertStringContainsString('Allow: /', $body);
        $this->assertStringContainsString('Disallow: /dashboard', $body);
        $this->assertStringContainsString('Disallow: /dang-nhap', $body);
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

    public function test_sitemap_index_lists_section_sitemaps(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringContainsString('application/xml', (string) $response->headers->get('Content-Type'));

        $xml = $response->getContent();
        $this->assertNotFalse(simplexml_load_string($xml));
        $this->assertStringContainsString('<sitemapindex', $xml);
        $this->assertStringContainsString('<loc>'.route('seo.sitemap.section', ['type' => 'main']).'</loc>', $xml);
        $this->assertStringContainsString('<loc>'.route('seo.sitemap.section', ['type' => 'kinh']).'</loc>', $xml);
        $this->assertStringContainsString('<loc>'.route('seo.sitemap.section', ['type' => 'tools']).'</loc>', $xml);
    }

    public function test_section_sitemaps_include_expected_urls(): void
    {
        $mainResponse = $this->get('/sitemaps/main.xml');
        $mainResponse->assertOk();
        $mainXml = $mainResponse->getContent();
        $this->assertStringContainsString('<urlset', $mainXml);
        $this->assertStringContainsString('<loc>'.route('home').'</loc>', $mainXml);

        $kinhResponse = $this->get('/sitemaps/kinh.xml');
        $kinhResponse->assertOk();
        $kinhXml = $kinhResponse->getContent();
        $this->assertStringContainsString('<loc>'.route('tools.show', 'doc-kinh').'</loc>', $kinhXml);

        $toolsResponse = $this->get('/sitemaps/tools.xml');
        $toolsResponse->assertOk();
        $toolsXml = $toolsResponse->getContent();
        $this->assertStringContainsString('<loc>'.route('tools.show', 'may-niem-phat').'</loc>', $toolsXml);
        $this->assertStringContainsString('<loc>'.route('tools.show', 'hai-loc-phap-cu').'</loc>', $toolsXml);
        $this->assertStringNotContainsString('<loc>'.route('tools.show', 'doc-kinh').'</loc>', $toolsXml);
    }

    public function test_sitemap_returns_not_found_when_indexing_disabled(): void
    {
        config(['seo.indexing_enabled' => false]);

        $this->get('/sitemap.xml')->assertNotFound();
        $this->get('/sitemaps/main.xml')->assertNotFound();
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

    public function test_sitemap_entries_are_grouped_by_type(): void
    {
        $builder = new SitemapBuilder;
        $locations = array_column($builder->entries(), 'loc');

        $homeIndex = array_search(route('home'), $locations, true);
        $docKinhIndex = array_search(route('tools.show', 'doc-kinh'), $locations, true);
        $toolIndex = array_search(route('tools.show', 'may-niem-phat'), $locations, true);

        $this->assertNotFalse($homeIndex);
        $this->assertNotFalse($docKinhIndex);
        $this->assertNotFalse($toolIndex);

        $this->assertLessThan($docKinhIndex, $homeIndex);
        $this->assertLessThan($toolIndex, $docKinhIndex);

        $scriptureIndex = $this->firstIndexMatching($locations, '#/scriptures/\d+/read$#');
        $postIndex = $this->firstIndexMatching($locations, '#/bai-viet/\d+$#');

        if ($scriptureIndex !== null && $postIndex !== null) {
            $this->assertLessThan($postIndex, $scriptureIndex);
            $this->assertLessThan($toolIndex, $postIndex);
        }

        $indexXml = $builder->toIndexXml();
        $this->assertStringContainsString('<sitemapindex', $indexXml);
        $this->assertStringContainsString(route('seo.sitemap.section', ['type' => 'kinh']), $indexXml);

        $kinhXml = $builder->toSectionXml('kinh');
        $this->assertStringContainsString('<!-- Kinh Phật -->', $kinhXml);
        $this->assertStringContainsString(route('tools.show', 'doc-kinh'), $kinhXml);
    }

    /**
     * @param  list<string>  $locations
     */
    private function firstIndexMatching(array $locations, string $pattern): ?int
    {
        foreach ($locations as $index => $location) {
            if (preg_match($pattern, $location) === 1) {
                return $index;
            }
        }

        return null;
    }
}
