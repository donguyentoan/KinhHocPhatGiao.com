<x-layouts.tool title="Lần chuỗi hạt">
    <div class="lg:flex lg:items-start lg:justify-center lg:gap-16 xl:gap-24">
    <div class="rounded-2xl border border-[#e8e0d4] bg-white px-5 py-4 flex items-center justify-between gap-4 shadow-sm mb-8 lg:mb-0 lg:flex-col lg:items-stretch lg:min-w-[220px] lg:shrink-0">
        <span class="text-sm font-bold text-[#5c4d42] lg:text-center">Số đếm</span>
        <div class="flex items-center gap-2 lg:justify-center">
            <span id="bead-count" class="tabular-nums min-w-[3rem] text-center rounded-lg bg-[#efe7d5] border border-[#e0d5c8] px-4 py-2 text-2xl font-bold text-[#1a1512]">0</span>
            <button type="button" id="bead-reset" class="flex h-11 w-11 items-center justify-center rounded-full border border-[#d4c9b8] text-[#8b5e34] hover:bg-[#faf6f0]" title="Đặt lại" aria-label="Đặt lại số đếm">
                <i class="fa-solid fa-rotate-left"></i>
            </button>
        </div>
        <p class="hidden lg:block text-xs text-[#8a7d72] text-center leading-relaxed mt-2">Mỗi lần chạm chuỗi là một niệm. Dữ liệu lưu cục bộ trên trình duyệt.</p>
    </div>

    <div class="flex flex-col items-center py-2 lg:py-0 lg:flex-1">
        <button type="button" id="bead-tap-zone" class="relative flex flex-col items-center focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34] rounded-3xl py-4" aria-label="Lần thêm một hạt">
            <span class="absolute top-0 bottom-0 w-0.5 bg-gradient-to-b from-[#c4a574] via-[#8b5e34] to-[#5c4030] rounded-full" aria-hidden="true"></span>
            @foreach (range(0, 6) as $i)
                @php
                    $large = $i === 3;
                @endphp
                <span
                    class="bead-ball relative z-[1] rounded-full bg-gradient-to-br from-[#a67c52] via-[#6b4423] to-[#4a2c11] shadow-md border border-[#3d2314]/30 {{ $large ? 'w-12 h-12 sm:w-14 sm:h-14 -my-1' : 'w-9 h-9 sm:w-10 sm:h-10' }} {{ $i > 0 ? '-mt-3 sm:-mt-3.5' : '' }}"
                    aria-hidden="true"
                ></span>
            @endforeach
        </button>
        <p class="text-sm text-[#8a7d72] mt-8 text-center max-w-md lg:text-left">Chạm vào chuỗi hạt để đếm — mỗi lần tương ứng một niệm.</p>
    </div>
    </div>

    <script>
        (function () {
            var key = 'lanChuoiHatCount';
            var el = document.getElementById('bead-count');
            var n = parseInt(localStorage.getItem(key) || '0', 10) || 0;
            function render() {
                el.textContent = String(n);
                localStorage.setItem(key, String(n));
            }
            render();
            document.getElementById('bead-tap-zone').addEventListener('click', function () {
                n += 1;
                render();
            });
            document.getElementById('bead-reset').addEventListener('click', function () {
                if (confirm('Đặt lại số hạt về 0?')) {
                    n = 0;
                    render();
                }
            });
        })();
    </script>
</x-layouts.tool>
