<x-layouts.tool title="Máy niệm Phật">
    <div class="bg-white/70 border border-[#e5dec9] rounded-3xl p-8 shadow-sm text-center">
        <p class="text-sm text-[#6b4f2c] mb-6">Nhấn mỗi lần niệm một câu. Số đếm được lưu trên trình duyệt của bạn.</p>
        <div id="counter-display" class="font-serif text-7xl md:text-8xl font-bold text-[#4a2c11] tabular-nums mb-8">0</div>
        <div class="flex flex-wrap justify-center gap-3">
            <button type="button" id="btn-inc" class="px-8 py-4 rounded-full bg-[#4a2c11] text-white font-bold hover:bg-[#8b5e34] transition-colors shadow-lg">+1 niệm Phật</button>
            <button type="button" id="btn-reset" class="px-6 py-4 rounded-full border-2 border-[#8b5e34]/40 font-semibold hover:bg-[#efe7d5] transition-colors">Đặt lại</button>
        </div>
        <p class="text-xs text-[#8b5e34]/70 mt-8">Gợi ý: có thể đặt mục tiêu 108 hoặc 1080 câu mỗi ngày.</p>
    </div>
    <script>
        (function () {
            const key = 'mayNiemPhatCount';
            const el = document.getElementById('counter-display');
            let n = parseInt(localStorage.getItem(key) || '0', 10) || 0;
            function render() { el.textContent = String(n); localStorage.setItem(key, String(n)); }
            render();
            document.getElementById('btn-inc').onclick = function () { n += 1; render(); };
            document.getElementById('btn-reset').onclick = function () { if (confirm('Đặt lại số đếm về 0?')) { n = 0; render(); } };
        })();
    </script>
</x-layouts.tool>
