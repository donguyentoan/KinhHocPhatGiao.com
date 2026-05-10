@php
    $tracks = [
        ['title' => 'Bát Nhã Tâm Kinh', 'dur' => '5:38', 'yt' => 'nXCy9fT8_OQ', 'thumb' => null],
        ['title' => 'Peaceful Healing (Chữa lành)', 'dur' => '2:59', 'yt' => '1ZYbU82GVz4', 'thumb' => null],
        ['title' => 'Namo A Mi Tuo Fo', 'dur' => '3:43', 'yt' => 'WQK9K7yM29I', 'thumb' => null],
        ['title' => 'Bamboo water relaxation', 'dur' => '9:49', 'yt' => 'bP6oDocTd_I', 'thumb' => null],
        ['title' => 'Thư giãn (Relaxing Music Part 1)', 'dur' => '21:52', 'yt' => '4vIQHrwiBX0', 'thumb' => null],
        ['title' => 'Thiền sâu (Deep Meditation)', 'dur' => '3:04', 'yt' => 'lTRiuFIWV54', 'thumb' => null],
        ['title' => 'Tĩnh lặng (Trance of Stillness)', 'dur' => '9:14', 'yt' => '_4kHxtUYMLA', 'thumb' => null],
        ['title' => 'Nīlakaṇṭha Dhāraṇī', 'dur' => '11:54', 'yt' => 'jfl5Bj0k_OK', 'thumb' => null],
        ['title' => 'Budha Music (nhạc thiền)', 'dur' => '5:58', 'yt' => '1ZYbU82GVz4', 'thumb' => null],
    ];
@endphp

<x-layouts.tool title="Nhạc thiền">
    <p class="text-[#6b5346] text-base max-w-3xl leading-relaxed mb-8">
        Chọn bài trong danh sách bên trái (trên màn hình lớn) — video phát ở khung bên phải. Có thể đổi mã YouTube trong file giao diện khi cần.
    </p>

    <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-10 xl:gap-12 lg:items-start">
        <div class="lg:col-span-5 xl:col-span-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#8a7d72] mb-3">Danh sách</h2>
            <ul class="rounded-2xl border border-[#e8e0d4] bg-white overflow-hidden divide-y divide-[#efe8dc] shadow-sm max-h-[70vh] lg:max-h-[calc(100vh-12rem)] overflow-y-auto" id="nhac-list">
                @foreach ($tracks as $t)
                    @php
                        $vid = $t['yt'];
                        $thumbUrl = $t['thumb'] ?? "https://img.youtube.com/vi/{$vid}/mqdefault.jpg";
                    @endphp
                    <li>
                        <div class="flex items-center gap-2 px-3 py-2.5 sm:px-4">
                            <button type="button" class="nhac-play flex flex-1 min-w-0 items-center gap-3 text-left rounded-xl hover:bg-[#faf6f0]/90 transition-colors py-1.5 px-2 -my-1 -mx-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40" data-yt="{{ $vid }}">
                                <img src="{{ $thumbUrl }}" alt="" class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl object-cover flex-shrink-0 border border-[#e8e0d4] bg-[#f5f0e8]">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-[#1a1512] text-sm leading-snug">{{ $t['title'] }}</p>
                                    <p class="text-xs text-[#8a7d72] mt-0.5">{{ $t['dur'] }}</p>
                                </div>
                            </button>
                            <a href="https://www.youtube.com/watch?v={{ $vid }}" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border border-[#d4c9b8] text-[#8b5e34] hover:bg-[#efe7d5]" title="Mở trên YouTube" aria-label="Mở trên YouTube">
                                <i class="fa-solid fa-up-right-from-square text-xs"></i>
                            </a>
                        </div>
                    </li>
                @endforeach
                <li>
                    <button type="button" id="nhac-silence" class="w-full flex items-center gap-3 px-3 py-3 sm:px-4 text-left hover:bg-[#faf6f0]/90 transition-colors">
                        <span class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-xl bg-[#f3ebe0] border border-[#dcc8b0] text-[#8b5e34]" aria-hidden="true">
                            <i class="fa-solid fa-music text-[#b07d4f] line-through decoration-2"></i>
                        </span>
                        <div>
                            <p class="font-bold text-[#8b5e34] text-sm">Không nhạc</p>
                            <p class="text-xs text-[#a08b7a]">Thiền trong im lặng</p>
                        </div>
                    </button>
                </li>
            </ul>
        </div>

        <div class="lg:col-span-7 xl:col-span-8 mt-8 lg:mt-0 lg:sticky lg:top-40 self-start w-full">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#8a7d72] mb-3 lg:sr-only">Đang phát</h2>
            <div class="rounded-2xl overflow-hidden border border-[#e8e0d4] bg-black aspect-video shadow-lg min-h-[240px]">
                <iframe id="nhac-iframe" class="w-full h-full min-h-[240px]" src="about:blank" data-src-base="https://www.youtube.com/embed/" title="Nhạc thiền" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <p class="text-sm text-[#8a7d72] mt-4 text-center lg:text-left">Khung cố định bên phải trên desktop; cuộn danh sách bên trái để đổi bài.</p>
        </div>
    </div>

    <script>
        (function () {
            var iframe = document.getElementById('nhac-iframe');
            var base = iframe.getAttribute('data-src-base');
            document.querySelectorAll('.nhac-play').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = btn.getAttribute('data-yt');
                    if (!id || !iframe) return;
                    iframe.src = base + id + '?rel=0&autoplay=1';
                });
            });
            var silence = document.getElementById('nhac-silence');
            if (silence && iframe) {
                silence.addEventListener('click', function () {
                    iframe.src = 'about:blank';
                });
            }
        })();
    </script>
</x-layouts.tool>
