<x-layouts.tool title="Ngồi thiền">
    <div class="bg-white/70 border border-[#e5dec9] rounded-3xl p-8 shadow-sm">
        <p class="text-sm text-[#6b4f2c] mb-6 text-center">Chọn thời lượng, nhấn Bắt đầu. Hãy giữ lưng thẳng, thả lỏng vai, chú ý nhẹ nhàng vào hơi thở.</p>
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            @foreach ([5, 10, 15, 20, 30] as $m)
                <button type="button" class="duration-btn px-4 py-2 rounded-full text-sm font-semibold border border-[#8b5e34]/30 hover:bg-[#8b5e34]/10" data-min="{{ $m }}">{{ $m }} phút</button>
            @endforeach
        </div>
        <div class="text-center font-serif text-6xl md:text-7xl font-bold text-[#4a2c11] tabular-nums mb-8" id="timer-display">00:00</div>
        <div class="flex flex-wrap justify-center gap-3">
            <button type="button" id="btn-start" class="px-8 py-3 rounded-full bg-[#4a2c11] text-white font-bold hover:bg-[#8b5e34]">Bắt đầu</button>
            <button type="button" id="btn-pause" class="px-6 py-3 rounded-full border-2 border-[#8b5e34]/40 font-semibold hover:bg-[#efe7d5]">Tạm dừng</button>
            <button type="button" id="btn-stop" class="px-6 py-3 rounded-full border-2 border-[#8b5e34]/40 font-semibold hover:bg-[#efe7d5]">Dừng hẳn</button>
        </div>
    </div>
    <script>
        (function () {
            let totalSec = 0, remain = 0, id = null, running = false;
            const display = document.getElementById('timer-display');
            function fmt(s) {
                const m = Math.floor(s / 60), sec = s % 60;
                return String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
            }
            function tick() {
                if (remain <= 0) { clearInterval(id); id = null; running = false; display.textContent = fmt(0); return; }
                remain--; display.textContent = fmt(remain);
            }
            document.querySelectorAll('.duration-btn').forEach(function (b) {
                b.addEventListener('click', function () {
                    if (running) return;
                    totalSec = parseInt(b.dataset.min, 10) * 60;
                    remain = totalSec;
                    display.textContent = fmt(remain);
                });
            });
            document.getElementById('btn-start').onclick = function () {
                if (remain <= 0 && totalSec > 0) remain = totalSec;
                if (remain <= 0) { alert('Chọn số phút trước.'); return; }
                if (id) return;
                running = true;
                id = setInterval(tick, 1000);
            };
            document.getElementById('btn-pause').onclick = function () {
                if (id) { clearInterval(id); id = null; running = false; }
            };
            document.getElementById('btn-stop').onclick = function () {
                if (id) { clearInterval(id); id = null; }
                running = false;
                remain = totalSec;
                display.textContent = fmt(remain);
            };
        })();
    </script>
</x-layouts.tool>
