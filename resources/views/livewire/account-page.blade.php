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
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-[#4a2c11]">Biểu đồ 14 ngày tu học</h2>
                <span class="text-sm text-[#8b5e34]">Đơn vị: số hoạt động/ngày</span>
            </div>
            <div class="flex flex-wrap gap-3 mb-4">
                <div class="px-3 py-2 rounded-lg bg-[#efe7d5] text-[#4a2c11] text-sm">
                    Thiền hôm nay: <span class="font-semibold">{{ $todayMeditationMinutes }} phút</span>
                </div>
                <div class="px-3 py-2 rounded-lg bg-[#efe7d5] text-[#4a2c11] text-sm">
                    Thiền 7 ngày: <span class="font-semibold">{{ $weeklyMeditationMinutes }} phút</span>
                </div>
            </div>

            <div class="grid grid-cols-7 md:grid-cols-14 gap-2 items-end h-44">
                @foreach($practiceChart as $day)
                    @php
                        $height = max(8, (int) round(($day['count'] / $chartMax) * 100));
                    @endphp
                    <div class="flex flex-col items-center justify-end gap-2 h-full">
                        <div class="w-full max-w-[22px] rounded-t-md {{ $day['is_today'] ? 'bg-[#4a2c11]' : 'bg-[#8b5e34]/80' }}"
                             style="height: {{ $height }}%;">
                        </div>
                        <p class="text-[10px] text-[#8b5e34]">{{ $day['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-[#e5dec9] p-5 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-[#4a2c11]">Nhật ký thao tác</h2>
                <span class="text-sm text-[#8b5e34]">Tổng: {{ $totalActivities }}</span>
            </div>

            @if($activities->isEmpty())
                <p class="text-[#8b5e34]">Bạn chưa có hoạt động nào, hãy bắt đầu đọc kinh hoặc ngồi thiền.</p>
            @else
                <div class="space-y-3">
                    @foreach($activities as $activity)
                        <div class="rounded-xl border border-[#efe7d5] px-4 py-3">
                            <div class="flex justify-between gap-4">
                                <p class="font-medium text-[#4a2c11]">
                                    @if($activity->activity_type === 'scripture_read')
                                        Đọc kinh
                                    @elseif($activity->activity_type === 'meditation_session')
                                        Ngồi thiền
                                    @elseif($activity->activity_type === 'tool_usage')
                                        Dùng tiện ích
                                    @else
                                        Cập nhật thông tin
                                    @endif
                                </p>
                                <p class="text-xs text-[#8b5e34]">{{ $activity->created_at?->format('d/m/Y H:i') }}</p>
                            </div>
                            @if(!empty($activity->meta['title']))
                                <p class="text-sm text-[#8b5e34] mt-1">{{ $activity->meta['title'] }}</p>
                            @elseif($activity->activity_type === 'meditation_session' && !empty($activity->meta['actual_minutes']))
                                <p class="text-sm text-[#8b5e34] mt-1">
                                    Thời lượng thực tế: {{ $activity->meta['actual_minutes'] }} phút
                                </p>
                            @elseif(!empty($activity->meta['slug']))
                                <p class="text-sm text-[#8b5e34] mt-1">{{ $activity->meta['slug'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
