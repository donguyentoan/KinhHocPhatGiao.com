<?php

namespace App\Console\Commands;

use App\Services\SitemapBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate
                            {--index-path=public/sitemap.xml : Relative path for the sitemap index}
                            {--section-dir=public/sitemaps : Relative directory for section sitemaps}';

    protected $description = 'Write sitemap index and section sitemaps to disk (for static deploy or CDN upload)';

    public function handle(SitemapBuilder $builder): int
    {
        if (! config('seo.indexing_enabled')) {
            $this->warn('SEO_INDEXING_ENABLED is false — sitemap will not be generated for crawlers at runtime either.');

            return self::FAILURE;
        }

        $indexPath = base_path((string) $this->option('index-path'));
        $sectionDir = (string) $this->option('section-dir');

        $this->ensureDirectory(dirname($indexPath));
        File::put($indexPath, $builder->toIndexXml());
        $this->info('Sitemap index written to '.$indexPath);

        foreach ($builder->sectionFilesForDisk($sectionDir) as $relativePath => $xml) {
            $absolutePath = base_path($relativePath);
            $this->ensureDirectory(dirname($absolutePath));
            File::put($absolutePath, $xml);
            $this->line('  · '.$relativePath);
        }

        return self::SUCCESS;
    }

    private function ensureDirectory(string $directory): void
    {
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }
}
