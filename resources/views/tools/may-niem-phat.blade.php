@php
    $audioBase = 'audio/may-niem-phat';
    $chants = [
        [
            'label' => 'Niệm Nam Mô A Di Đà Phật',
            'audio' => '02-nam-mo-a-di-da-phat-loop.mp3',
        ],
        [
            'label' => 'Niệm Nam Mô Bổn Sư Thích Ca Mâu Ni Phật',
            'audio' => '03-nam-mo-thich-ca-loop.mp3',
        ],
        [
            'label' => 'Niệm Nam Mô Đại Bi Quan Thế Âm Bồ Tát',
            'audio' => '04-nam-mo-quan-the-am-loop.mp3',
        ],
        [
            'label' => 'Niệm Nam Mô Đại Thế Chí Bồ Tát',
            'audio' => '05-nam-mo-dai-the-chi-loop.mp3',
        ],
        [
            'label' => 'Niệm Nam Mô Địa Tạng Vương Bồ Tát',
            'audio' => '06-nam-mo-dia-tang-loop.mp3',
        ],
        [
            'label' => 'Niệm Nam Mô Dược Sư Lưu Ly Quang Vương Phật',
            'audio' => '07-nam-mo-duoc-su-loop.mp3',
        ],
    ];
@endphp

<x-layouts.tool title="Máy niệm Phật">
    <p class="text-[#6b5346] text-base max-w-3xl leading-relaxed mb-6">
        Chọn câu niệm bên dưới. Bấm một lần để bắt đầu, bấm lại để dừng.
    </p>

    <ul class="grid sm:grid-cols-2 gap-3 lg:gap-4" id="may-niem-list">
        @foreach ($chants as $c)
            <li>
                <button
                    type="button"
                    class="may-niem-row w-full flex items-center justify-between gap-3 rounded-2xl border border-[#e8e0d4] bg-white px-4 py-3.5 text-left shadow-sm hover:border-[#c9a77c]/60 hover:shadow transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/50"
                    data-audio="{{ asset($audioBase.'/'.$c['audio']) }}"
                >
                    <span class="font-semibold text-[#1a1512] text-sm leading-snug block min-w-0">{{ $c['label'] }}</span>
                    <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-[#8b5e34]/35 text-[#8b5e34]" aria-hidden="true">
                        <i class="fa-solid fa-play text-sm may-niem-icon-play"></i>
                        <i class="fa-solid fa-volume-high text-sm may-niem-icon-speak hidden"></i>
                    </span>
                </button>
            </li>
        @endforeach
    </ul>

    <script>
        (function () {
            var rows = document.querySelectorAll('.may-niem-row');
            var currentAudio = null;
            var currentBtn = null;

            function stopRowAudio() {
                if (currentAudio) {
                    currentAudio.pause();
                    currentAudio.currentTime = 0;
                    currentAudio = null;
                }
            }

            function setPlaying(btn, on) {
                rows.forEach(function (r) {
                    var p = r.querySelector('.may-niem-icon-play');
                    var s = r.querySelector('.may-niem-icon-speak');
                    if (r === btn && on) {
                        p.classList.add('hidden');
                        s.classList.remove('hidden');
                    } else {
                        p.classList.remove('hidden');
                        s.classList.add('hidden');
                    }
                });
            }

            rows.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var src = btn.getAttribute('data-audio');
                    if (!src) return;

                    if (currentBtn === btn && currentAudio && !currentAudio.paused) {
                        stopRowAudio();
                        setPlaying(null, false);
                        currentBtn = null;
                        return;
                    }

                    stopRowAudio();
                    setPlaying(null, false);
                    currentBtn = btn;

                    var a = new Audio(src);
                    a.loop = true;
                    currentAudio = a;
                    a.preload = 'auto';
                    setPlaying(btn, true);
                    a.onerror = function () {
                        if (currentAudio === a) {
                            currentAudio = null;
                            currentBtn = null;
                        }
                        setPlaying(btn, false);
                    };
                    var p = a.play();
                    if (p && typeof p.catch === 'function') {
                        p.catch(function () {
                            setPlaying(btn, false);
                            currentAudio = null;
                            currentBtn = null;
                        });
                    }
                });
            });
        })();
    </script>
</x-layouts.tool>
