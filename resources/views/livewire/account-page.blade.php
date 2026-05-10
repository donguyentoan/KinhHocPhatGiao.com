<div class="min-h-screen bg-[#f9f3e6] p-4 md:p-8">
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl md:text-3xl font-bold text-[#4a2c11]">Tài khoản tu học</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-[#e5dec9] p-5 md:p-6">
            <p class="text-sm text-[#8b5e34] mb-2">Pháp danh hiện tại</p>
            <div class="flex flex-col md:flex-row gap-3">
                <input
                    type="text"
                    wire:model.defer="dharmaName"
                    class="flex-1 rounded-xl border border-[#e5dec9] px-4 py-2 focus:outline-none"
                    placeholder="Nhập pháp danh"
                >
                <button wire:click="saveName" class="px-5 py-2 rounded-xl bg-[#8b5e34] text-white hover:bg-[#6f4a2b]">
                    Lưu pháp danh
                </button>
            </div>
            @error('dharmaName')
                <p class="text-sm text-red-700 mt-2">{{ $message }}</p>
            @enderror
            @if (session('success'))
                <p class="text-sm text-green-700 mt-2">{{ session('success') }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-[#e5dec9] rounded-2xl p-5">
                <p class="text-sm text-[#8b5e34]">Streak tu học</p>
                <p class="text-3xl font-bold text-[#4a2c11] mt-2">{{ $streak }} ngày</p>
            </div>
            <div class="bg-white border border-[#e5dec9] rounded-2xl p-5">
                <p class="text-sm text-[#8b5e34]">Lượt đọc kinh</p>
                <p class="text-3xl font-bold text-[#4a2c11] mt-2">{{ $readingCount }}</p>
            </div>
            <div class="bg-white border border-[#e5dec9] rounded-2xl p-5">
                <p class="text-sm text-[#8b5e34]">Lượt ngồi thiền</p>
                <p class="text-3xl font-bold text-[#4a2c11] mt-2">{{ $meditationCount }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-[#e5dec9] p-5 md:p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                <h2 class="text-xl font-semibold text-[#4a2c11]">Biểu đồ 14 ngày tu học</h2>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs sm:text-sm text-[#5c4a3d]">
                    <span class="inline-flex items-center gap-2">
                        <span class="h-3 w-3 shrink-0 rounded-sm bg-[#c9a77c]" aria-hidden="true"></span>
                        Đọc kinh <span class="text-[#8b5e34]">(lượt — cột trái)</span>
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <span class="h-3 w-3 shrink-0 rounded-sm bg-[#4a2c11]" aria-hidden="true"></span>
                        Thiền <span class="text-[#8b5e34]">(phút — cột phải)</span>
                    </span>
                </div>
            </div>
            <p class="text-xs text-[#8b5e34] mb-3">Mỗi ngày hai cột cạnh nhau; chiều cao tỉ lệ với cực đại 14 ngày của từng loại.</p>
            <div class="flex flex-wrap gap-3 mb-4">
                <div class="px-3 py-2 rounded-lg bg-[#efe7d5] text-[#4a2c11] text-sm">
                    Thiền hôm nay: <span class="font-semibold">{{ $todayMeditationMinutes }} phút</span>
                </div>
                <div class="px-3 py-2 rounded-lg bg-[#efe7d5] text-[#4a2c11] text-sm">
                    Thiền 7 ngày: <span class="font-semibold">{{ $weeklyMeditationMinutes }} phút</span>
                </div>
            </div>

            <div class="grid grid-cols-7 md:grid-cols-14 gap-x-1 gap-y-1 md:gap-2 items-end h-48">
                @foreach($practiceChart as $day)
                    @php
                        $reads = (int) ($day['reading_count'] ?? 0);
                        $med = (float) ($day['meditation_minutes'] ?? 0);
                        $hRead = $reads <= 0 ? 0 : (int) round(($reads / $chartMaxReads) * 100);
                        $hMed = $med <= 0 ? 0 : (int) round(($med / $chartMaxMinutes) * 100);
                    @endphp
                    <div class="flex min-w-0 flex-col items-center justify-end gap-2 h-full">
                        <div class="flex h-full w-full max-w-[2.75rem] items-end justify-center gap-0.5 px-0.5 {{ $day['is_today'] ? 'rounded-t-md bg-[#faf6f0] ring-1 ring-[#c9a77c]/60' : '' }}">
                            <div class="flex h-full min-h-0 w-1/2 flex-col justify-end" title="{{ $reads > 0 ? $reads.' lượt đọc kinh' : 'Không đọc kinh' }}">
                                <div
                                    class="w-full max-w-[14px] mx-auto rounded-t-sm bg-[#c9a77c] transition-[height]"
                                    style="{{ $hRead > 0 ? 'height: '.$hRead.'%; min-height: 2px;' : 'height: 0;' }}"
                                ></div>
                            </div>
                            <div class="flex h-full min-h-0 w-1/2 flex-col justify-end" title="{{ $med > 0 ? number_format($med, 1, ',', ' ').' phút thiền' : 'Không thiền' }}">
                                <div
                                    class="w-full max-w-[14px] mx-auto rounded-t-sm bg-[#4a2c11] transition-[height]"
                                    style="{{ $hMed > 0 ? 'height: '.$hMed.'%; min-height: 2px;' : 'height: 0;' }}"
                                ></div>
                            </div>
                        </div>
                        <p class="text-[10px] text-[#8b5e34] tabular-nums">{{ $day['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
