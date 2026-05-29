<?php

namespace App\Http\Controllers;

use App\Models\Scripture;
use App\Support\PracticeTracker;
use Illuminate\Support\Str;

class ScriptureReaderController extends Controller
{
    public function show(Scripture $scripture, PracticeTracker $tracker)
    {
        $scripture->loadMissing('category');

        $tracker->logActivity('scripture_read', $scripture, [
            'title' => $scripture->title,
            'category_name' => $scripture->category?->name,
        ]);

        $readerMode = in_array($scripture->reader_mode, ['auto', 'pdf', 'content'], true)
            ? $scripture->reader_mode
            : 'auto';
        $hasPdfSource = filled($scripture->content_file_path) && Str::endsWith(strtolower((string) $scripture->content_file_path), '.pdf');
        $shouldUsePdf = $hasPdfSource && ($readerMode === 'pdf' || $readerMode === 'auto');

        $pdfUrl = null;
        if ($shouldUsePdf) {
            $pdfUrl = route('scriptures.pdf', $scripture);
        }

        $rawContent = trim((string) ($scripture->content_text ?: $scripture->summary));
        $content = preg_replace("/\r\n|\r/", "\n", $rawContent) ?: '';
        if ($hasPdfSource) {
            $content = $this->cleanPdfArtifacts($content);
        }
        $lines = array_map(static fn (string $line) => trim($line), explode("\n", $content));
        $blocks = $this->normalizeSutraBlocks($lines);

        if (empty($blocks)) {
            $blocks = ['Chưa có nội dung để hiển thị. Vui lòng cập nhật tệp nội dung trong Dashboard.'];
        }

        $pages = $this->paginateBlocksForBook($blocks);

        return view('scriptures.reader', [
            'scripture' => $scripture,
            'pages' => $pages,
            'pdfUrl' => $pdfUrl,
        ]);
    }

    public function pdf(Scripture $scripture)
    {
        $relativePath = (string) $scripture->content_file_path;
        $isPdfSource = $relativePath !== '' && Str::endsWith(strtolower($relativePath), '.pdf');
        abort_unless($isPdfSource, 404);

        $absolutePath = $this->resolveStoredFilePath($relativePath);
        abort_unless($absolutePath !== null, 404);

        return response()->file($absolutePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($absolutePath) . '"',
        ]);
    }

    private function resolveStoredFilePath(string $relativePath): ?string
    {
        $normalized = ltrim($relativePath, '/');
        $candidatePaths = [
            storage_path('app/public/' . $normalized),
            storage_path('app/' . $normalized),
        ];

        if (Str::startsWith($normalized, 'public/')) {
            $candidatePaths[] = storage_path('app/' . $normalized);
            $candidatePaths[] = storage_path('app/public/' . substr($normalized, strlen('public/')));
        }

        foreach ($candidatePaths as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    private function paginateBlocksForBook(array $blocks): array
    {
        $maxCharsPerVisualLine = 28;
        $maxLinesPerPage = 20;
        $pages = [];
        $currentPageLines = [];
        $currentLineCount = 0;

        foreach ($blocks as $block) {
            $blockLines = $this->wrapTextByWords($block, $maxCharsPerVisualLine);
            if (empty($blockLines)) {
                continue;
            }

            // Keep compact spacing between blocks for sutra reading.
            $blockWithSpacing = $blockLines;

            if (($currentLineCount + count($blockWithSpacing)) <= $maxLinesPerPage) {
                $currentPageLines = array_merge($currentPageLines, $blockWithSpacing);
                $currentLineCount = count($currentPageLines);
                continue;
            }

            // Move whole block to next page if it doesn't fit current page.
            if (count($blockLines) <= $maxLinesPerPage) {
                if (!empty($currentPageLines)) {
                    $pages[] = implode("\n", $currentPageLines);
                }
                $currentPageLines = $blockLines;
                $currentLineCount = count($currentPageLines);
                continue;
            }

            // Very long block: split across pages safely.
            if (!empty($currentPageLines)) {
                $pages[] = implode("\n", $currentPageLines);
                $currentPageLines = [];
                $currentLineCount = 0;
            }

            $chunks = array_chunk($blockLines, $maxLinesPerPage);
            foreach ($chunks as $index => $chunk) {
                if ($index < count($chunks) - 1) {
                    $pages[] = implode("\n", $chunk);
                } else {
                    $currentPageLines = $chunk;
                    $currentLineCount = count($currentPageLines);
                }
            }
        }

        if (!empty($currentPageLines)) {
            $pages[] = implode("\n", $currentPageLines);
        }

        return $pages;
    }

    private function cleanPdfArtifacts(string $content): string
    {
        $content = str_replace("\u{00A0}", ' ', $content); // non-breaking spaces
        $content = preg_replace('/[ \t]+/u', ' ', $content) ?: $content;
        $content = preg_replace('/\n{3,}/u', "\n\n", $content) ?: $content;

        $lines = explode("\n", $content);
        $cleaned = [];
        $seenKinhTitle = false;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                $cleaned[] = '';
                continue;
            }

            // Drop common PDF page-number/footer patterns.
            if (preg_match('/^\d+$/u', $line) === 1) {
                continue;
            }
            if (preg_match('/^\d+\s*[•\.\-]\s*\d+$/u', $line) === 1) {
                continue;
            }
            if (preg_match('/^O\s*\d+\s*[•\.\-]\s*\d+$/u', $line) === 1) {
                continue;
            }

            // Keep only the first repeated running title line.
            if (preg_match('/^KINH\s+A-?DI-?ĐÀ$/iu', $line) === 1) {
                if ($seenKinhTitle) {
                    continue;
                }
                $seenKinhTitle = true;
            }

            $cleaned[] = $line;
        }

        return trim(implode("\n", $cleaned));
    }

    private function normalizeSutraBlocks(array $lines): array
    {
        $blocks = [];
        $currentNumberedBlock = '';
        $inNumberedSection = false;

        foreach ($lines as $rawLine) {
            $line = trim(preg_replace('/\s+/u', ' ', $rawLine) ?? $rawLine);
            if ($line === '') {
                continue;
            }

            $isNumberedLine = preg_match('/^\d+\.\s*/u', $line) === 1;
            $isHeading = preg_match('/^[\p{Lu}\d\s\-\(\)\:]+$/u', $line) === 1 && mb_strlen($line) >= 5;

            if ($isHeading) {
                if ($currentNumberedBlock !== '') {
                    $blocks[] = $currentNumberedBlock;
                    $currentNumberedBlock = '';
                }
                $blocks[] = $line;
                continue;
            }

            if ($isNumberedLine) {
                $inNumberedSection = true;
                if ($currentNumberedBlock !== '') {
                    $blocks[] = $currentNumberedBlock;
                }
                $currentNumberedBlock = $line;
                continue;
            }

            if ($inNumberedSection) {
                if ($currentNumberedBlock === '') {
                    $currentNumberedBlock = $line;
                } else {
                    $currentNumberedBlock .= ' ' . $line;
                }
                continue;
            }

            if (!empty($blocks)) {
                $lastIndex = count($blocks) - 1;
                $last = $blocks[$lastIndex];
                $canMerge = preg_match('/[\.!\?:;)]$/u', $last) !== 1 && mb_strlen($line) < 45;
                if ($canMerge) {
                    $blocks[$lastIndex] = trim($last . ' ' . $line);
                } else {
                    $blocks[] = $line;
                }
            } else {
                $blocks[] = $line;
            }
        }

        if ($currentNumberedBlock !== '') {
            $blocks[] = $currentNumberedBlock;
        }

        return $blocks;
    }

    private function wrapTextByWords(string $text, int $maxCharsPerLine): array
    {
        $parts = preg_split('/\n/u', $text) ?: [$text];
        $lines = [];

        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }

            if (mb_strlen($part) <= $maxCharsPerLine) {
                $lines[] = $part;
                continue;
            }

            $words = preg_split('/\s+/u', $part) ?: [];
            $line = '';

            foreach ($words as $word) {
                $candidate = trim($line . ' ' . $word);
                if ($line !== '' && mb_strlen($candidate) > $maxCharsPerLine) {
                    $lines[] = $line;
                    $line = $word;
                } else {
                    $line = $candidate;
                }
            }

            if ($line !== '') {
                $lines[] = $line;
            }
        }

        return $lines;
    }
}
