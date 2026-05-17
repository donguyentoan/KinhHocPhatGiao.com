<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Scripture;
use App\Support\ToolSlugs;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use XMLWriter;

class SitemapBuilder
{
    private const SITEMAP_NS = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /** @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}> */
    public function entries(): array
    {
        $entries = [];

        $entries[] = $this->entry(
            route('home'),
            $this->latestContentTimestamp(),
            config('seo.changefreq.home'),
            config('seo.priorities.home'),
        );

        foreach (ToolSlugs::all() as $slug) {
            $isDocKinh = $slug === 'doc-kinh';

            $entries[] = $this->entry(
                route('tools.show', $slug),
                null,
                config($isDocKinh ? 'seo.changefreq.tools_doc_kinh' : 'seo.changefreq.tools'),
                config($isDocKinh ? 'seo.priorities.tools_doc_kinh' : 'seo.priorities.tools'),
            );
        }

        Scripture::query()
            ->orderBy('id')
            ->get(['id', 'updated_at'])
            ->each(function (Scripture $scripture) use (&$entries) {
                $entries[] = $this->entry(
                    route('scriptures.read', $scripture),
                    $scripture->updated_at,
                    config('seo.changefreq.scriptures'),
                    config('seo.priorities.scriptures'),
                );
            });

        Post::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('id')
            ->get(['id', 'updated_at', 'published_at'])
            ->each(function (Post $post) use (&$entries) {
                $lastmod = $post->updated_at;
                if ($post->published_at && ($lastmod === null || $post->published_at->gt($lastmod))) {
                    $lastmod = $post->published_at;
                }

                $entries[] = $this->entry(
                    route('posts.show', $post),
                    $lastmod,
                    config('seo.changefreq.posts'),
                    config('seo.priorities.posts'),
                );
            });

        return $this->dedupeByLocation($entries);
    }

    public function toXml(): string
    {
        $writer = new XMLWriter;
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndent(true);
        $writer->setIndentString('  ');
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', self::SITEMAP_NS);

        foreach ($this->entries() as $entry) {
            $writer->startElement('url');
            $writer->writeElement('loc', $entry['loc']);

            if ($entry['lastmod'] instanceof CarbonInterface) {
                $writer->writeElement('lastmod', $entry['lastmod']->utc()->format('Y-m-d\TH:i:s\Z'));
            }

            $writer->writeElement('changefreq', $entry['changefreq']);
            $writer->writeElement('priority', $entry['priority']);
            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();

        return $writer->outputMemory();
    }

    /**
     * @param  list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}>  $entries
     * @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}>
     */
    public function dedupeByLocation(array $entries): array
    {
        $seen = [];

        return Collection::make($entries)
            ->filter(function (array $entry) use (&$seen) {
                if (isset($seen[$entry['loc']])) {
                    return false;
                }

                $seen[$entry['loc']] = true;

                return true;
            })
            ->values()
            ->all();
    }

    private function entry(
        string $loc,
        ?CarbonInterface $lastmod,
        string $changefreq,
        string $priority,
    ): array {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function latestContentTimestamp(): ?CarbonInterface
    {
        $scriptureLatest = Scripture::query()->max('updated_at');
        $postLatest = Post::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->max('updated_at');

        $candidates = array_filter([$scriptureLatest, $postLatest]);

        if ($candidates === []) {
            return null;
        }

        $latest = max($candidates);

        return $latest ? \Illuminate\Support\Carbon::parse($latest) : null;
    }
}
