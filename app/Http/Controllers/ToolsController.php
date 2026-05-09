<?php

namespace App\Http\Controllers;

use App\Support\PracticeTracker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ToolsController extends Controller
{
    private const SLUG_TO_VIEW = [
        'may-niem-phat' => 'tools.may-niem-phat',
        'ngoi-thien' => 'tools.ngoi-thien',
        'chuong-mo' => 'tools.chuong-mo',
        'lan-chuoi-hat' => 'tools.lan-chuoi-hat',
        'nhac-thien' => 'tools.nhac-thien',
        'su-kien-trong-nam' => 'tools.su-kien-trong-nam',
        'lien-he-ho-tro' => 'tools.lien-he-ho-tro',
    ];

    public function show(string $slug, PracticeTracker $tracker): View
    {
        if (! isset(self::SLUG_TO_VIEW[$slug])) {
            abort(404);
        }

        $tracker->logActivity('tool_usage', null, ['slug' => $slug]);

        return view(self::SLUG_TO_VIEW[$slug]);
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
