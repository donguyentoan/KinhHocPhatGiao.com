<?php

namespace App\Console\Commands;

use App\Services\SitemapBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate
                            {--path=public/sitemap.xml : Relative path under the project root}';

    protected $description = 'Write sitemap.xml to disk (for static deploy or CDN upload)';

    public function handle(SitemapBuilder $builder): int
    {
        if (! config('seo.indexing_enabled')) {
            $this->warn('SEO_INDEXING_ENABLED is false — sitemap will not be generated for crawlers at runtime either.');

            return self::FAILURE;
        }

        $relativePath = (string) $this->option('path');
        $absolutePath = base_path($relativePath);
        $directory = dirname($absolutePath);

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($absolutePath, $builder->toXml());

        $this->info('Sitemap written to '.$absolutePath);

        return self::SUCCESS;
    }
}
