<x-layouts.tool title="Chuông mõ">
    <div class="bg-white/70 border border-[#e5dec9] rounded-3xl p-8 shadow-sm text-center">
        <p class="text-sm text-[#6b4f2c] mb-8">Nhấn để nghe tiếng chuông ngắn (tổng hợp trên trình duyệt). Có thể dùng trước và sau giờ tụng niệm.</p>
        <button type="button" id="btn-bell" class="w-40 h-40 mx-auto rounded-full bg-gradient-to-br from-[#c9a227] to-[#8b6914] text-white text-5xl shadow-xl hover:scale-105 transition-transform flex items-center justify-center" aria-label="Gõ chuông">
            <i class="fa-solid fa-bell"></i>
        </button>
        <p class="text-xs text-[#8b5e34]/70 mt-8">Âm thanh phát qua Web Audio API; nếu không nghe được, hãy kiểm tra âm lượng thiết bị.</p>
    </div>
    <script>
        (function () {
            let ctx = null;
            function bell() {
                try {
                    ctx = ctx || new (window.AudioContext || window.webkitAudioContext)();
                    const o = ctx.createOscillator();
                    const g = ctx.createGain();
                    o.connect(g); g.connect(ctx.destination);
                    o.frequency.value = 830;
                    o.type = 'sine';
                    const now = ctx.currentTime;
                    g.gain.setValueAtTime(0.001, now);
                    g.gain.exponentialRampToValueAtTime(0.2, now + 0.02);
                    g.gain.exponentialRampToValueAtTime(0.001, now + 1.2);
                    o.start(now);
                    o.stop(now + 1.25);
                } catch (e) { console.warn(e); }
            }
            document.getElementById('btn-bell').onclick = function () { if (ctx && ctx.state === 'suspended') ctx.resume(); bell(); };
        })();
    </script>
</x-layouts.tool>
