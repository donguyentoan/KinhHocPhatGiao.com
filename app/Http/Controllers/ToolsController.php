<?php

namespace App\Http\Controllers;

use App\Models\Scripture;
use App\Models\ScriptureCategory;
use App\Support\PracticeTracker;
use App\Support\ToolSlugs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ToolsController extends Controller
{
    public function show(string $slug, PracticeTracker $tracker, Request $request): View
    {
        if (! ToolSlugs::isValid($slug)) {
            abort(404);
        }

        $tracker->logActivity('tool_usage', null, ['slug' => $slug]);

        if ($slug === 'doc-kinh') {
            $q = trim((string) $request->query('q', ''));
            if (mb_strlen($q) > 200) {
                $q = mb_substr($q, 0, 200);
            }

            $categoryId = $request->integer('category') ?: null;
            $activeCategory = $categoryId !== null
                ? ScriptureCategory::query()->find($categoryId)
                : null;
            if ($activeCategory === null) {
                $categoryId = null;
            }

            $like = $q !== '' ? '%'.addcslashes($q, '%_\\').'%' : null;

            $scriptures = Scripture::query()
                ->with('category')
                ->when($categoryId !== null, fn ($query) => $query->where('category_id', $categoryId))
                ->when($like !== null, function ($query) use ($like) {
                    $query->where(function ($sub) use ($like) {
                        $sub->where('title', 'like', $like)
                            ->orWhereHas('category', fn ($c) => $c->where('name', 'like', $like));
                    });
                })
                ->orderBy('title')
                ->paginate(20)
                ->withQueryString();

            return view(ToolSlugs::SLUG_TO_VIEW[$slug], [
                'scriptures' => $scriptures,
                'searchQuery' => $q,
                'activeCategory' => $activeCategory,
            ]);
        }

        return view(ToolSlugs::SLUG_TO_VIEW[$slug]);
    }

    public function startMeditation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'planned_minutes' => ['nullable', 'integer', 'min:1', 'max:240'],
        ]);

        $request->session()->put('meditation.started_at', now()->toIso8601String());
        $request->session()->put('meditation.planned_minutes', $validated['planned_minutes'] ?? null);

        return response()->json([
            'message' => 'Đã bắt đầu phiên thiền.',
        ]);
    }

    public function completeMeditation(Request $request, PracticeTracker $tracker): JsonResponse
    {
        $validated = $request->validate([
            'actual_seconds' => ['required', 'integer', 'min:1', 'max:14400'],
            'planned_minutes' => ['nullable', 'integer', 'min:1', 'max:240'],
        ]);

        $startedAt = $request->session()->pull('meditation.started_at');
        $plannedMinutes = $validated['planned_minutes'] ?? $request->session()->pull('meditation.planned_minutes');

        $tracker->logActivity('meditation_session', null, [
            'slug' => 'ngoi-thien',
            'started_at' => $startedAt,
            'planned_minutes' => $plannedMinutes,
            'actual_seconds' => $validated['actual_seconds'],
            'actual_minutes' => round($validated['actual_seconds'] / 60, 1),
        ]);

        return response()->json([
            'message' => 'Đã lưu phiên thiền.',
        ]);
    }
}
