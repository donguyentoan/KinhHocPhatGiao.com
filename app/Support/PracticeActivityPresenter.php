<?php

namespace App\Support;

use App\Models\PracticeActivity;
use App\Models\Post;
use App\Models\Scripture;
use App\Models\VegetarianRecipe;

final class PracticeActivityPresenter
{
    /** @var array<string, string> */
    private const TYPE_LABELS = [
        'scripture_read' => 'Đọc kinh',
        'meditation_session' => 'Ngồi thiền',
        'quiz_attempt' => 'Trắc nghiệm',
        'tool_usage' => 'Tiện ích',
        'post_view' => 'Bài viết',
        'recipe_view' => 'Món chay',
        'intro_saved' => 'Lưu pháp danh',
    ];

    /** @var array<string, string> */
    private const TOOL_LABELS = [
        'may-niem-phat' => 'Máy niệm Phật',
        'ngoi-thien' => 'Ngồi thiền',
        'lan-chuoi-hat' => 'Lần chuỗi hạt',
        'nhac-thien' => 'Nhạc thiền',
        'su-kien-trong-nam' => 'Sự kiện trong năm',
        'lien-he-ho-tro' => 'Liên hệ hỗ trợ',
        'doc-kinh' => 'Danh sách đọc kinh',
        'hai-loc-phap-cu' => 'Cây Bồ Đề Pháp Cú',
        'truc-nghiem-phat-giao' => 'Trắc nghiệm Phật giáo',
    ];

    /** @var array<string, string> */
    private const BADGE_CLASSES = [
        'scripture_read' => 'bg-amber-100 text-amber-900',
        'meditation_session' => 'bg-emerald-100 text-emerald-900',
        'quiz_attempt' => 'bg-sky-100 text-sky-900',
        'tool_usage' => 'bg-violet-100 text-violet-900',
        'post_view' => 'bg-rose-100 text-rose-900',
        'recipe_view' => 'bg-lime-100 text-lime-900',
        'intro_saved' => 'bg-[#efe7d5] text-[#4a2c11]',
    ];

    public static function typeLabel(string $type): string
    {
        return self::TYPE_LABELS[$type] ?? $type;
    }

    public static function badgeClass(string $type): string
    {
        return self::BADGE_CLASSES[$type] ?? 'bg-gray-100 text-gray-800';
    }

    public static function iconClass(string $type): string
    {
        return match ($type) {
            'scripture_read' => 'fa-book-open',
            'meditation_session' => 'fa-spa',
            'quiz_attempt' => 'fa-circle-question',
            'tool_usage' => 'fa-puzzle-piece',
            'post_view' => 'fa-newspaper',
            'recipe_view' => 'fa-bowl-food',
            'intro_saved' => 'fa-user-pen',
            default => 'fa-circle-dot',
        };
    }

    /** Màu viền trái / icon trên timeline */
    public static function accentClass(string $type): string
    {
        return match ($type) {
            'scripture_read' => 'border-amber-400 bg-amber-50 text-amber-800',
            'meditation_session' => 'border-emerald-400 bg-emerald-50 text-emerald-800',
            'quiz_attempt' => 'border-sky-400 bg-sky-50 text-sky-800',
            'tool_usage' => 'border-violet-400 bg-violet-50 text-violet-800',
            'post_view' => 'border-rose-400 bg-rose-50 text-rose-800',
            'recipe_view' => 'border-lime-500 bg-lime-50 text-lime-800',
            'intro_saved' => 'border-[#c9a77c] bg-[#faf6f0] text-[#6f4a2b]',
            default => 'border-gray-300 bg-gray-50 text-gray-700',
        };
    }

    /**
     * Dòng tiêu đề chính trên thẻ (tên kinh, món, tiện ích…).
     *
     * @param  array<int, string>  $scriptureTitles
     * @param  array<int, string>  $scriptureCategories
     * @param  array<int, string>  $postTitles
     * @param  array<int, string>  $recipeTitles
     */
    public static function primarySummary(
        PracticeActivity $activity,
        array $scriptureTitles = [],
        array $scriptureCategories = [],
        array $postTitles = [],
        array $recipeTitles = [],
    ): string {
        foreach (self::detailRows($activity, $scriptureTitles, $scriptureCategories, $postTitles, $recipeTitles) as $row) {
            if (in_array($row['label'], [
                'Kinh đã đọc',
                'Tiện ích đã mở',
                'Bài viết đã xem',
                'Món chay đã xem',
                'Bài làm',
                'Pháp danh',
            ], true)) {
                return $row['value'];
            }
        }

        $rows = self::detailRows($activity, $scriptureTitles, $scriptureCategories, $postTitles, $recipeTitles);

        return $rows[0]['value'] ?? '—';
    }

    /**
     * Các dòng chi tiết hiển thị trong lịch sử (nhãn + giá trị).
     *
     * @param  array<int, string>  $scriptureTitles
     * @param  array<int, string>  $scriptureCategories
     * @param  array<int, string>  $postTitles
     * @param  array<int, string>  $recipeTitles
     * @return list<array{label: string, value: string}>
     */
    public static function detailRows(
        PracticeActivity $activity,
        array $scriptureTitles = [],
        array $scriptureCategories = [],
        array $postTitles = [],
        array $recipeTitles = [],
    ): array {
        $meta = $activity->meta ?? [];

        return match ($activity->activity_type) {
            'scripture_read' => self::scriptureRows($activity, $meta, $scriptureTitles, $scriptureCategories),
            'meditation_session' => self::meditationRows($meta),
            'quiz_attempt' => self::quizRows($meta),
            'tool_usage' => self::toolRows($meta),
            'post_view' => self::postRows($activity, $meta, $postTitles),
            'recipe_view' => self::recipeRows($activity, $meta, $recipeTitles),
            'intro_saved' => self::introRows($meta),
            default => [self::row('Ghi chú', (string) ($meta['note'] ?? '—'))],
        };
    }

    /** @return list<string> */
    public static function filterOptions(): array
    {
        return array_keys(self::TYPE_LABELS);
    }

    /**
     * @param  array<int, string>  $titles
     * @param  array<int, string>  $categories
     * @return list<array{label: string, value: string}>
     */
    private static function scriptureRows(
        PracticeActivity $activity,
        array $meta,
        array $titles,
        array $categories,
    ): array {
        $refId = $activity->reference_id ? (int) $activity->reference_id : null;
        $title = trim((string) ($meta['title'] ?? ''));
        if ($title === '' && $refId !== null) {
            $title = (string) ($titles[$refId] ?? '');
        }
        if ($title === '') {
            $title = '— (không lưu tên kinh)';
        }

        $category = trim((string) ($meta['category_name'] ?? ''));
        if ($category === '' && $refId !== null) {
            $category = (string) ($categories[$refId] ?? '');
        }

        $rows = [self::row('Kinh đã đọc', $title)];
        if ($category !== '') {
            $rows[] = self::row('Loại kinh', $category);
        }

        return $rows;
    }

    /** @return list<array{label: string, value: string}> */
    private static function meditationRows(array $meta): array
    {
        $rows = [self::row('Hoạt động', 'Phiên ngồi thiền')];

        $seconds = (int) ($meta['actual_seconds'] ?? 0);
        if ($seconds > 0) {
            $minutes = round($seconds / 60, 1);
            $rows[] = self::row('Thời gian thực tế', $minutes.' phút ('.$seconds.' giây)');
        }

        $planned = (int) ($meta['planned_minutes'] ?? 0);
        if ($planned > 0) {
            $rows[] = self::row('Thời gian đặt sẵn', $planned.' phút');
        }

        if (count($rows) === 1) {
            $rows[] = self::row('Trạng thái', 'Đã hoàn tất phiên');
        }

        return $rows;
    }

    /** @return list<array{label: string, value: string}> */
    private static function quizRows(array $meta): array
    {
        $correct = (int) ($meta['correct_count'] ?? 0);
        $total = max(1, (int) ($meta['total_questions'] ?? 1));
        $percent = (int) ($meta['score_percent'] ?? round(($correct / $total) * 100));

        return [
            self::row('Bài làm', 'Trắc nghiệm Phật giáo'),
            self::row('Số câu đúng', $correct.' / '.$total.' câu'),
            self::row('Tỷ lệ đạt', $percent.'%'),
        ];
    }

    /** @return list<array{label: string, value: string}> */
    private static function toolRows(array $meta): array
    {
        $slug = (string) ($meta['slug'] ?? '');
        $label = self::TOOL_LABELS[$slug] ?? ($slug !== '' ? $slug : 'Không rõ');

        return [
            self::row('Tiện ích đã mở', $label),
        ];
    }

    /**
     * @param  array<int, string>  $titles
     * @return list<array{label: string, value: string}>
     */
    private static function postRows(PracticeActivity $activity, array $meta, array $titles): array
    {
        $refId = $activity->reference_id ? (int) $activity->reference_id : null;
        $title = trim((string) ($meta['title'] ?? ''));
        if ($title === '' && $refId !== null) {
            $title = (string) ($titles[$refId] ?? '');
        }
        if ($title === '') {
            $title = '— (không lưu tên bài)';
        }

        return [
            self::row('Bài viết đã xem', $title),
        ];
    }

    /**
     * @param  array<int, string>  $titles
     * @return list<array{label: string, value: string}>
     */
    private static function recipeRows(PracticeActivity $activity, array $meta, array $titles): array
    {
        $refId = $activity->reference_id ? (int) $activity->reference_id : null;
        $title = trim((string) ($meta['title'] ?? ''));
        if ($title === '' && $refId !== null) {
            $title = (string) ($titles[$refId] ?? '');
        }
        if ($title === '') {
            $title = '— (không lưu tên món)';
        }

        $rows = [self::row('Món chay đã xem', $title)];

        if (! empty($meta['prep_minutes'])) {
            $rows[] = self::row('Thời gian chuẩn bị', (string) $meta['prep_minutes'].' phút');
        }

        return $rows;
    }

    /** @return list<array{label: string, value: string}> */
    private static function introRows(array $meta): array
    {
        if (! empty($meta['skipped'])) {
            return [
                self::row('Hành động', 'Bỏ qua popup giới thiệu'),
                self::row('Pháp danh', 'Thiện hữu (mặc định)'),
            ];
        }

        $name = trim((string) ($meta['dharma_name'] ?? ''));

        return [
            self::row('Hành động', 'Lưu pháp danh lần đầu'),
            self::row('Pháp danh', $name !== '' ? $name : 'Thiện hữu'),
        ];
    }

    /** @return array{label: string, value: string} */
    private static function row(string $label, string $value): array
    {
        return ['label' => $label, 'value' => $value];
    }
}
