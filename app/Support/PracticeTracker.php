<?php

namespace App\Support;

use App\Models\PracticeActivity;
use App\Models\PracticeProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PracticeTracker
{
    private const DEVICE_COOKIE = 'khpg_device_key';

    public function __construct(private readonly Request $request)
    {
    }

    public function existingProfile(): ?PracticeProfile
    {
        $deviceKey = $this->resolveDeviceKey(false);
        if ($deviceKey === null) {
            return null;
        }

        return PracticeProfile::query()
            ->where('session_key', $deviceKey)
            ->first();
    }

    public function currentProfile(): PracticeProfile
    {
        $deviceKey = $this->resolveDeviceKey();

        $profile = PracticeProfile::query()->firstOrCreate(
            ['session_key' => $deviceKey],
            ['dharma_name' => 'Thiện hữu']
        );

        $profile->forceFill(['last_seen_at' => now()])->save();

        return $profile;
    }

    public function saveDharmaName(?string $dharmaName): PracticeProfile
    {
        $profile = $this->currentProfile();
        $cleanName = trim((string) $dharmaName);
        $profile->update([
            'dharma_name' => $cleanName !== '' ? $cleanName : 'Thiện hữu',
        ]);

        return $profile;
    }

    /**
     * Lưu pháp danh lần đầu từ popup giới thiệu và đánh dấu đã hoàn tất intro.
     */
    public function completeIntro(?string $dharmaName, bool $skipped): PracticeProfile
    {
        $profile = $this->currentProfile();
        $cleanName = trim((string) $dharmaName);
        $name = ($skipped || $cleanName === '') ? 'Thiện hữu' : $cleanName;
        $profile->update([
            'dharma_name' => $name,
            'intro_completed_at' => now(),
        ]);

        return $profile->fresh();
    }

    public function needsIntroPopup(PracticeProfile $profile): bool
    {
        return $profile->intro_completed_at === null;
    }

    public function logActivity(
        string $type,
        ?Model $referenceModel = null,
        array $meta = [],
        ?Carbon $date = null
    ): PracticeActivity {
        $profile = $this->currentProfile();

        return PracticeActivity::query()->create([
            'practice_profile_id' => $profile->id,
            'activity_type' => $type,
            'reference_type' => $referenceModel ? $referenceModel::class : null,
            'reference_id' => $referenceModel?->getKey(),
            'practiced_on' => ($date ?? now())->toDateString(),
            'meta' => empty($meta) ? null : $meta,
        ]);
    }

    public function currentStreak(PracticeProfile $profile): int
    {
        $days = PracticeActivity::query()
            ->where('practice_profile_id', $profile->id)
            ->select('practiced_on')
            ->distinct()
            ->orderByDesc('practiced_on')
            ->pluck('practiced_on')
            ->map(static fn ($value) => Carbon::parse($value)->toDateString())
            ->all();

        if (empty($days)) {
            return 0;
        }

        $expected = Carbon::today();
        $firstDay = $days[0];

        if ($firstDay !== $expected->toDateString()) {
            if ($firstDay === $expected->copy()->subDay()->toDateString()) {
                $expected = $expected->subDay();
            } else {
                return 0;
            }
        }

        $streak = 0;

        foreach ($days as $day) {
            if ($day === $expected->toDateString()) {
                $streak++;
                $expected = $expected->subDay();
                continue;
            }

            break;
        }

        return $streak;
    }

    private function resolveDeviceKey(bool $createIfMissing = true): ?string
    {
        $cookieValue = trim((string) $this->request->cookie(self::DEVICE_COOKIE, ''));
        if ($cookieValue !== '') {
            return $cookieValue;
        }

        if (! $createIfMissing) {
            return null;
        }

        $deviceKey = Str::uuid()->toString();
        Cookie::queue(cookie(self::DEVICE_COOKIE, $deviceKey, 60 * 24 * 365 * 5));

        return $deviceKey;
    }
}
