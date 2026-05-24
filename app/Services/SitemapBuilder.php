<?php

namespace App\Services;

use App\Models\Post;
use App\Models\VegetarianRecipe;
use App\Models\Scripture;
use App\Support\ToolSlugs;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use XMLWriter;

class SitemapBuilder
{
    private const SITEMAP_NS = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /** @var list<string> */
    public const SECTIONS = ['main', 'kinh', 'blog', 'tools'];

    /** @var array<string, string> */
    private const SECTION_LABELS = [
        'main' => 'Trang chính',
        'kinh' => 'Kinh Phật',
        'blog' => 'Bài viết',
        'tools' => 'Tiện ích',
    ];

    public static function indexCacheKey(): string
    {
        return 'seo.sitemap.index.xml';
    }

    public static function sectionCacheKey(string $section): string
    {
        return 'seo.sitemap.section.'.$section.'.xml';
    }

    public static function forgetAllCaches(): void
    {
        Cache::forget(self::indexCacheKey());

        foreach (self::SECTIONS as $section) {
            Cache::forget(self::sectionCacheKey($section));
        }
    }

    public static function isValidSection(string $section): bool
    {
        return in_array($section, self::SECTIONS, true);
    }

    public static function sectionLabel(string $section): string
    {
        return self::SECTION_LABELS[$section] ?? $section;
    }

    /**
     * @return list<string>
     */
    public function activeSections(): array
    {
        return array_values(array_filter(
            self::SECTIONS,
            fn (string $section) => $this->sectionEntries($section) !== [],
        ));
    }

    /**
     * @return array<string, list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}>>
     */
    public function groupedEntries(): array
    {
        $grouped = [];

        foreach (self::SECTIONS as $section) {
            $grouped[$section] = $this->sectionEntries($section);
        }

        return $grouped;
    }

    /** @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}> */
    public function entries(): array
    {
        $entries = [];

        foreach (self::SECTIONS as $section) {
            $entries = array_merge($entries, $this->sectionEntries($section));
        }

        return $this->dedupeByLocation($entries);
    }

    /** @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}> */
    public function sectionEntries(string $section): array
    {
        return match ($section) {
            'main' => $this->mainEntries(),
            'kinh' => $this->kinhEntries(),
            'blog' => $this->blogEntries(),
            'tools' => $this->toolEntries(),
            default => [],
        };
    }

    public function toIndexXml(): string
    {
        $writer = new XMLWriter;
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndent(true);
        $writer->setIndentString('  ');
        $writer->startElement('sitemapindex');
        $writer->writeAttribute('xmlns', self::SITEMAP_NS);

        foreach ($this->activeSections() as $section) {
            $writer->startElement('sitemap');
            $writer->writeElement('loc', route('seo.sitemap.section', ['type' => $section]));

            $lastmod = $this->sectionLastmod($section);
            if ($lastmod instanceof CarbonInterface) {
                $writer->writeElement('lastmod', $lastmod->utc()->format('Y-m-d\TH:i:s\Z'));
            }

            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();

        return $writer->outputMemory();
    }

    public function toSectionXml(string $section): string
    {
        $entries = $this->dedupeByLocation($this->sectionEntries($section));

        $writer = new XMLWriter;
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndent(true);
        $writer->setIndentString('  ');
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', self::SITEMAP_NS);

        if ($entries !== []) {
            $writer->writeComment(' '.self::sectionLabel($section).' ');
        }

        foreach ($entries as $entry) {
            $this->writeUrlElement($writer, $entry);
        }

        $writer->endElement();
        $writer->endDocument();

        return $writer->outputMemory();
    }

    /**
     * @return array<string, string>
     */
    public function sectionFilesForDisk(string $directory = 'public/sitemaps'): array
    {
        $files = [];

        foreach ($this->activeSections() as $section) {
            $files[$directory.'/'.$section.'.xml'] = $this->toSectionXml($section);
        }

        return $files;
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

    /** @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}> */
    private function mainEntries(): array
    {
        return [
            $this->entry(
                route('home'),
                $this->latestContentTimestamp(),
                config('seo.changefreq.home'),
                config('seo.priorities.home'),
            ),
        ];
    }

    /** @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}> */
    private function kinhEntries(): array
    {
        $entries = [
            $this->entry(
                route('tools.show', 'doc-kinh'),
                null,
                config('seo.changefreq.tools_doc_kinh'),
                config('seo.priorities.tools_doc_kinh'),
            ),
        ];

        Scripture::query()
            ->orderBy('title')
            ->orderBy('id')
            ->get(['id', 'title', 'updated_at'])
            ->each(function (Scripture $scripture) use (&$entries) {
                $entries[] = $this->entry(
                    route('scriptures.read', $scripture),
                    $scripture->updated_at,
                    config('seo.changefreq.scriptures'),
                    config('seo.priorities.scriptures'),
                );
            });

        return $entries;
    }

    /** @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}> */
    private function blogEntries(): array
    {
        $entries = [
            $this->entry(
                route('recipes.index'),
                VegetarianRecipe::query()->published()->max('updated_at'),
                config('seo.changefreq.posts'),
                config('seo.priorities.posts'),
            ),
        ];

        Post::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->orderBy('title')
            ->orderBy('id')
            ->get(['id', 'title', 'updated_at', 'published_at'])
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

        VegetarianRecipe::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderBy('title')
            ->orderBy('id')
            ->get(['slug', 'title', 'updated_at', 'published_at'])
            ->each(function (VegetarianRecipe $recipe) use (&$entries) {
                $lastmod = $recipe->updated_at;
                if ($recipe->published_at && ($lastmod === null || $recipe->published_at->gt($lastmod))) {
                    $lastmod = $recipe->published_at;
                }

                $entries[] = $this->entry(
                    route('recipes.show', $recipe),
                    $lastmod,
                    config('seo.changefreq.posts'),
                    config('seo.priorities.posts'),
                );
            });

        return $entries;
    }

    /** @return list<array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}> */
    private function toolEntries(): array
    {
        $entries = [];

        foreach (ToolSlugs::all() as $slug) {
            if ($slug === 'doc-kinh') {
                continue;
            }

            $entries[] = $this->entry(
                route('tools.show', $slug),
                null,
                config('seo.changefreq.tools'),
                config('seo.priorities.tools'),
            );
        }

        return $entries;
    }

    /**
     * @param  array{loc: string, lastmod: ?CarbonInterface, changefreq: string, priority: string}  $entry
     */
    private function writeUrlElement(XMLWriter $writer, array $entry): void
    {
        $writer->startElement('url');
        $writer->writeElement('loc', $entry['loc']);

        if ($entry['lastmod'] instanceof CarbonInterface) {
            $writer->writeElement('lastmod', $entry['lastmod']->utc()->format('Y-m-d\TH:i:s\Z'));
        }

        $writer->writeElement('changefreq', $entry['changefreq']);
        $writer->writeElement('priority', $entry['priority']);
        $writer->endElement();
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

    private function sectionLastmod(string $section): ?CarbonInterface
    {
        $timestamps = Collection::make($this->sectionEntries($section))
            ->pluck('lastmod')
            ->filter(fn ($value) => $value instanceof CarbonInterface)
            ->values();

        if ($timestamps->isEmpty()) {
            return null;
        }

        return $timestamps->sortByDesc(fn (CarbonInterface $value) => $value->getTimestamp())->first();
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

        return $latest ? Carbon::parse($latest) : null;
    }
}
