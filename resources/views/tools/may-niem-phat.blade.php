@php
    $chants = [
        ['label' => 'Niệm A Di Đà Phật', 'speak' => 'A Di Đà Phật'],
        ['label' => 'Niệm Nam Mô A Di Đà Phật', 'speak' => 'Nam Mô A Di Đà Phật'],
        ['label' => 'Niệm Nam Mô Bổn Sư Thích Ca Mâu Ni Phật', 'speak' => 'Nam Mô Bổn Sư Thích Ca Mâu Ni Phật'],
        ['label' => 'Niệm Nam Mô Đại Bi Quan Thế Âm Bồ Tát', 'speak' => 'Nam Mô Đại Bi Quan Thế Âm Bồ Tát'],
        ['label' => 'Niệm Nam Mô Đại Thế Chí Bồ Tát', 'speak' => 'Nam Mô Đại Thế Chí Bồ Tát'],
        ['label' => 'Niệm Nam Mô Địa Tạng Vương Bồ Tát', 'speak' => 'Nam Mô Địa Tạng Vương Bồ Tát'],
        ['label' => 'Niệm Nam Mô Dược Sư Lưu Ly Quang Vương Phật', 'speak' => 'Nam Mô Dược Sư Lưu Ly Quang Vương Phật'],
    ];
@endphp

<x-layouts.tool title="Máy niệm Phật">
    <p class="text-[#6b5346] text-base max-w-3xl leading-relaxed mb-6">Nhấn dòng để nghe câu niệm (đọc bằng giọng máy trên trình duyệt). Có thể niệm theo sau khi nghe.</p>
    <ul class="grid sm:grid-cols-2 gap-3 lg:gap-4" id="may-niem-list">
        @foreach ($chants as $i => $c)
            <li>
                <button
                    type="button"
                    class="may-niem-row w-full flex items-center justify-between gap-3 rounded-2xl border border-[#e8e0d4] bg-white px-4 py-3.5 text-left shadow-sm hover:border-[#c9a77c]/60 hover:shadow transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/50"
                    data-speak="{{ $c['speak'] }}"
                >
                    <span class="font-semibold text-[#1a1512] text-sm leading-snug">{{ $c['label'] }}</span>
                    <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-[#8b5e34]/35 text-[#8b5e34]" aria-hidden="true">
                        <i class="fa-solid fa-play text-sm may-niem-icon-play"></i>
                        <i class="fa-solid fa-volume-high text-sm may-niem-icon-speak hidden"></i>
                    </span>
                </button>
            </li>
        @endforeach
    </ul>
    <p class="text-xs text-[#8a7d72] mt-8 max-w-3xl">Nếu không nghe được, hãy kiểm tra quyền âm thanh trình duyệt và chọn giọng tiếng Việt nếu có.</p>

    <script>
        (function () {
            var rows = document.querySelectorAll('.may-niem-row');
            if (!rows.length) return;
            if (!window.speechSynthesis) {
                var list = document.getElementById('may-niem-list');
                if (list) {
                    list.insertAdjacentHTML('afterend', '<p class="text-amber-900 text-sm text-center mt-3">Trình duyệt không hỗ trợ đọc thoại — bạn vẫn có thể đọc thầm theo từng dòng.</p>');
                }
                return;
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
                    var text = btn.getAttribute('data-speak') || '';
                    window.speechSynthesis.cancel();
                    var u = new SpeechSynthesisUtterance(text);
                    u.lang = 'vi-VN';
                    u.rate = 0.82;
                    u.onstart = function () { setPlaying(btn, true); };
                    u.onend = function () { setPlaying(btn, false); };
                    u.onerror = function () { setPlaying(btn, false); };
                    window.speechSynthesis.speak(u);
                });
            });
        })();
    </script>
</x-layouts.tool>
