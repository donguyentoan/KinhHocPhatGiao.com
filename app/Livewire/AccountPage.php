<?php

namespace App\Livewire;

use App\Models\PracticeActivity;
use App\Support\PracticeTracker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.home')]
class AccountPage extends Component
{
    public string $dharmaName = '';

    public function saveName(): void
    {
        $validated = $this->validate([
            'dharmaName' => ['required', 'string', 'max:100'],
        ]);

        app(PracticeTracker::class)->saveDharmaName($validated['dharmaName']);

        session()->flash('success', 'Đã cập nhật pháp danh.');
    }

    public function mount(): void
    {
        $profile = app(PracticeTracker::class)->currentProfile();
        $this->dharmaName = $profile->dharma_name;
    }

    public function render()
    {
        $tracker = app(PracticeTracker::class);
        $profile = $tracker->currentProfile();

        $baseQuery = PracticeActivity::query()->where('practice_profile_id', $profile->id);
        $activities = PracticeActivity::query()
            ->where('practice_profile_id', $profile->id)
            ->latest()
            ->take(20)
            ->get();
        $dailyCounts = PracticeActivity::query()
            ->where('practice_profile_id', $profile->id)
            ->whereDate('practiced_on', '>=', Carbon::today()->subDays(13))
            ->select('practiced_on', DB::raw('count(*) as total'))
            ->groupBy('practiced_on')
            ->pluck('total', 'practiced_on');

        $practiceChart = collect(range(13, 0))
            ->map(function (int $daysAgo) use ($dailyCounts) {
                $date = Carbon::today()->subDays($daysAgo);
                $dateKey = $date->toDateString();

                return [
                    'label' => $date->format('d/m'),
                    'short_day' => mb_substr($date->locale('vi')->dayName, 0, 3),
                    'count' => (int) ($dailyCounts[$dateKey] ?? 0),
                    'is_today' => $daysAgo === 0,
                ];
            });
        $meditationSessions = PracticeActivity::query()
            ->where('practice_profile_id', $profile->id)
            ->where('activity_type', 'meditation_session')
            ->whereDate('practiced_on', '>=', Carbon::today()->subDays(13))
            ->get(['practiced_on', 'meta']);

        $dailyMeditationMinutes = $meditationSessions
            ->groupBy(fn (PracticeActivity $activity) => $activity->practiced_on->toDateString())
            ->map(function ($items) {
                $seconds = $items->sum(function (PracticeActivity $activity) {
                    $meta = $activity->meta ?? [];
                    $actualSeconds = (int) ($meta['actual_seconds'] ?? 0);
                    if ($actualSeconds > 0) {
                        return $actualSeconds;
                    }

                    return ((int) ($meta['planned_minutes'] ?? 0)) * 60;
                });

                return round($seconds / 60, 1);
            });

        $todayMeditationMinutes = (float) ($dailyMeditationMinutes[Carbon::today()->toDateString()] ?? 0);
        $weeklyMeditationMinutes = (float) $dailyMeditationMinutes
            ->filter(function (float $minutes, string $date) {
                return Carbon::parse($date)->greaterThanOrEqualTo(Carbon::today()->subDays(6));
            })
            ->sum();

        return view('livewire.account-page', [
            'profile' => $profile,
            'streak' => $tracker->currentStreak($profile),
            'readingCount' => (clone $baseQuery)->where('activity_type', 'scripture_read')->count(),
            'meditationCount' => (clone $baseQuery)->where('activity_type', 'meditation_session')->count(),
            'totalActivities' => (clone $baseQuery)->count(),
            'activities' => $activities,
            'practiceChart' => $practiceChart,
            'chartMax' => max(1, (int) $practiceChart->max('count')),
            'todayMeditationMinutes' => $todayMeditationMinutes,
            'weeklyMeditationMinutes' => round($weeklyMeditationMinutes, 1),
        ]);
    }
}
