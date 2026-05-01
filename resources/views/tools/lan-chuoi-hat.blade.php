<x-layouts.tool title="Lần chuỗi hạt">
    <div class="bg-white/70 border border-[#e5dec9] rounded-3xl p-8 shadow-sm text-center">
        <p class="text-sm text-[#6b4f2c] mb-6">Mỗi lần lần một hạt — nhấn một lần. Số được lưu cục bộ.</p>
        <div class="relative w-48 h-48 mx-auto mb-8 rounded-full bg-gradient-to-br from-[#4a2c11] to-[#8b5e34] flex items-center justify-center shadow-inner">
            <span id="bead-count" class="font-serif text-5xl font-bold text-[#f9f3e6] tabular-nums">0</span>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            <button type="button" id="bead-add" class="px-8 py-4 rounded-full bg-[#4a2c11] text-white font-bold hover:bg-[#8b5e34]">+1 hạt</button>
            <button type="button" id="bead-reset" class="px-6 py-4 rounded-full border-2 border-[#8b5e34]/40 font-semibold hover:bg-[#efe7d5]">Đặt lại</button>
        </div>
        <p class="text-xs text-[#8b5e34]/70 mt-8">Thông thường một vòng chuỗi có 108 hạt; bạn có thể tự đặt mục tiêu.</p>
    </div>
    <script>
        (function () {
            const key = 'lanChuoiHatCount';
            const el = document.getElementById('bead-count');
            let n = parseInt(localStorage.getItem(key) || '0', 10) || 0;
            function render() { el.textContent = String(n); localStorage.setItem(key, String(n)); }
            render();
            document.getElementById('bead-add').onclick = function () { n += 1; render(); };
            document.getElementById('bead-reset').onclick = function () { if (confirm('Đặt lại số hạt về 0?')) { n = 0; render(); } };
        })();
    </script>
</x-layouts.tool>
