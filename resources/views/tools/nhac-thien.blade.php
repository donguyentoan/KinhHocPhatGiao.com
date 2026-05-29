@php
    $tracks = [
        ['title' => 'Bát Nhã Tâm Kinh', 'dur' => '5:46', 'yt' => 'Dh4sRaJkRaw', 'thumb' => null],
        ['title' => 'Peaceful Healing (Chữa lành)', 'dur' => '3:00:22', 'yt' => '1ZYbU82GVz4', 'thumb' => null],
        ['title' => 'Namo A Mi Tuo Fo', 'dur' => '5:23', 'yt' => 'CMjUtQMVo3c', 'thumb' => null],
        ['title' => 'Bamboo water relaxation', 'dur' => '12:15', 'yt' => 'QF-rTcpyjvg', 'thumb' => null],
        ['title' => 'Thư giãn (Relaxing Music)', 'dur' => '20:20', 'yt' => '8LV2hTWr48k', 'thumb' => null],
        ['title' => 'Thiền sâu (Deep Meditation)', 'dur' => '1:01:14', 'yt' => 'lTRiuFIWV54', 'thumb' => null],
        ['title' => 'Tĩnh lặng (Deep Stillness)', 'dur' => '9:00', 'yt' => 'H8W8NloQIII', 'thumb' => null],
        ['title' => 'Nīlakaṇṭha Dhāraṇī (Đại Bi chú)', 'dur' => '31:35', 'yt' => 'Df_pGKwDJDU', 'thumb' => null],
        ['title' => 'Nhạc thiền năng lượng tích cực', 'dur' => '10:24', 'yt' => 'BWMcR35D-cE', 'thumb' => null],
    ];
@endphp

<x-layouts.tool title="Nhạc thiền">
    <p class="text-[#6b5346] text-sm sm:text-base max-w-3xl leading-relaxed mb-5 sm:mb-8">
        <span class="lg:hidden">Chọn bài trong danh sách — video YouTube phát ngay bên dưới.</span>
        <span class="hidden lg:inline">Chọn bài trong danh sách bên trái — video phát ở khung bên phải. Có thể đổi mã YouTube trong file giao diện khi cần.</span>
    </p>

    <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-10 xl:gap-12 lg:items-start">
        <div class="lg:col-span-5 xl:col-span-4 min-w-0">
            <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#8a7d72] mb-2 sm:mb-3">Danh sách</h2>
            <ul
                class="rounded-2xl border border-[#e8e0d4] bg-white overflow-hidden divide-y divide-[#efe8dc] shadow-sm overflow-y-auto overscroll-contain max-h-[min(42vh,22rem)] sm:max-h-[min(46vh,26rem)] lg:max-h-[calc(100vh-12rem)]"
                id="nhac-list"
            >
                @foreach ($tracks as $t)
                    @php
                        $vid = $t['yt'];
                        $thumbUrl = $t['thumb'] ?? "https://img.youtube.com/vi/{$vid}/mqdefault.jpg";
                    @endphp
                    <li>
                        <div class="flex items-center gap-2 px-3 py-2.5 sm:px-4">
                            <button
                                type="button"
                                class="nhac-play flex flex-1 min-w-0 items-center gap-2.5 sm:gap-3 text-left rounded-xl hover:bg-[#faf6f0]/90 transition-colors py-1.5 px-2 -my-1 -mx-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40 border-2 border-transparent"
                                data-yt="{{ $vid }}"
                                data-title="{{ $t['title'] }}"
                            >
                                <img src="{{ $thumbUrl }}" alt="" class="w-11 h-11 sm:w-14 sm:h-14 rounded-xl object-cover flex-shrink-0 border border-[#e8e0d4] bg-[#f5f0e8]" loading="lazy" decoding="async">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-[#1a1512] text-sm leading-snug line-clamp-2">{{ $t['title'] }}</p>
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
                    <button type="button" id="nhac-silence" class="nhac-play w-full flex items-center gap-2.5 sm:gap-3 px-3 py-3 sm:px-4 text-left hover:bg-[#faf6f0]/90 transition-colors border-2 border-transparent rounded-xl" data-yt="" data-title="Im lặng">
                        <span class="flex h-11 w-11 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-xl bg-[#f3ebe0] border border-[#dcc8b0] text-[#8b5e34]" aria-hidden="true">
                            <i class="fa-solid fa-music text-[#b07d4f] line-through decoration-2"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="font-bold text-[#8b5e34] text-sm">Không nhạc</p>
                            <p class="text-xs text-[#a08b7a]">Thiền trong im lặng</p>
                        </div>
                    </button>
                </li>
            </ul>
        </div>

        <div class="lg:col-span-7 xl:col-span-8 mt-5 sm:mt-6 lg:mt-0 lg:sticky lg:top-40 self-start w-full min-w-0">
            <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#8a7d72] mb-2 sm:mb-3">Đang phát</h2>
            <p id="nhac-now-title" class="text-sm font-semibold text-[#4a2c11] mb-2 line-clamp-2 min-h-[1.25rem] lg:sr-only">Chưa chọn bài</p>
            <div class="rounded-2xl overflow-hidden border border-[#e8e0d4] bg-[#1a1512] shadow-lg w-full aspect-video max-h-[min(52vw,13.5rem)] sm:max-h-[min(48vw,15rem)] lg:max-h-none lg:min-h-[240px]">
                <iframe
                    id="nhac-iframe"
                    class="w-full h-full min-h-[11rem] sm:min-h-[13rem] lg:min-h-[240px]"
                    src="about:blank"
                    data-src-base="https://www.youtube.com/embed/"
                    title="Nhạc thiền"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>
            <p class="text-xs sm:text-sm text-[#8a7d72] mt-3 text-center leading-relaxed lg:hidden">
                Vuốt danh sách phía trên để đổi bài.
            </p>
            <p class="hidden lg:block text-sm text-[#8a7d72] mt-4">
                Khung cố định bên phải trên desktop; cuộn danh sách bên trái để đổi bài.
            </p>
        </div>
    </div>

    <script>
        (function () {
            var iframe = document.getElementById('nhac-iframe');
            var base = iframe ? iframe.getAttribute('data-src-base') : '';
            var nowTitle = document.getElementById('nhac-now-title');
            var playBtns = document.querySelectorAll('.nhac-play');

            function setActive(btn) {
                playBtns.forEach(function (b) {
                    var on = b === btn;
                    b.classList.toggle('bg-[#faf6f0]', on);
                    b.classList.toggle('border-[#c9a77c]/60', on);
                    b.setAttribute('aria-pressed', on ? 'true' : 'false');
                });
            }

            playBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = btn.getAttribute('data-yt');
                    var title = btn.getAttribute('data-title') || 'Đang phát';
                    setActive(btn);
                    if (nowTitle) {
                        nowTitle.textContent = title;
                    }
                    if (!iframe) return;
                    if (!id) {
                        iframe.src = 'about:blank';
                        if (nowTitle) nowTitle.textContent = 'Im lặng';
                        return;
                    }
                    iframe.src = base + id + '?rel=0&autoplay=1';
                });
            });
        })();
    </script>
</x-layouts.tool>
