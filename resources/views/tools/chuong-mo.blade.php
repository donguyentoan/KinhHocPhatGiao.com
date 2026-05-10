<x-layouts.tool title="Chuông mõ">
    <div id="cm-root" class="space-y-8 lg:space-y-10">
        {{-- Hub: lưới thẻ — bố cục web --}}
        <div id="cm-hub" class="space-y-6">
            <p class="text-[#6b5346] text-base max-w-3xl leading-relaxed">
                Chọn cách gõ — nhấn để nghe tiếng chuông hoặc mõ (tổng hợp trên trình duyệt, Web Audio API).
            </p>
            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-6">
                <button type="button" data-cm-screen="dual" class="cm-hub-row group text-left rounded-2xl border border-[#e8e0d4] bg-white p-5 lg:p-6 shadow-sm hover:shadow-md hover:border-[#c9a77c]/55 transition-all">
                    <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?w=480&h=360&fit=crop&q=80" alt="" class="w-full aspect-[4/3] object-cover rounded-xl mb-4 border border-[#ebe4d9]">
                    <span class="font-bold text-lg text-[#1a1512] group-hover:text-[#8b5e34] transition-colors">Gõ chuông mõ thủ công</span>
                    <span class="block text-sm text-[#8a7d72] mt-2">Chuông và mõ cạnh nhau trên một màn hình.</span>
                </button>
                <button type="button" data-cm-screen="mo" class="cm-hub-row group text-left rounded-2xl border border-[#e8e0d4] bg-white p-5 lg:p-6 shadow-sm hover:shadow-md hover:border-[#c9a77c]/55 transition-all">
                    <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=480&h=360&fit=crop&q=80" alt="" class="w-full aspect-[4/3] object-cover rounded-xl mb-4 border border-[#ebe4d9]">
                    <span class="font-bold text-lg text-[#1a1512] group-hover:text-[#8b5e34] transition-colors">Gõ mõ</span>
                    <span class="block text-sm text-[#8a7d72] mt-2">Chỉ tiếng mõ, giao diện tập trung.</span>
                </button>
                <button type="button" data-cm-screen="bell" class="cm-hub-row group text-left rounded-2xl border border-[#e8e0d4] bg-white p-5 lg:p-6 shadow-sm hover:shadow-md hover:border-[#c9a77c]/55 transition-all sm:col-span-2 xl:col-span-1">
                    <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?w=480&h=360&fit=crop&q=80" alt="" class="w-full aspect-[4/3] object-cover rounded-xl mb-4 border border-[#ebe4d9]">
                    <span class="font-bold text-lg text-[#1a1512] group-hover:text-[#8b5e34] transition-colors">Gõ chuông</span>
                    <span class="block text-sm text-[#8a7d72] mt-2">Chỉ tiếng chuông, vòng tròn lớn.</span>
                </button>
            </div>
        </div>

        @php
            $cmIntervals = [0, 1, 2, 3, 5, 10];
        @endphp

        {{-- Gõ thủ công --}}
        <div id="cm-dual" class="cm-panel hidden">
            <div class="lg:grid lg:grid-cols-12 lg:gap-10 xl:gap-12 lg:items-start">
                <aside class="lg:col-span-4 xl:col-span-3 space-y-4 lg:sticky lg:top-32">
                    <button type="button" data-cm-back class="inline-flex items-center gap-2 text-sm font-bold text-[#8b5e34] hover:underline">
                        <i class="fa-solid fa-chevron-left"></i> Tất cả chế độ
                    </button>
                    <div class="rounded-2xl border border-[#e8e0d4] bg-[#f3ebe0] px-4 py-4 space-y-4 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#8a7d72]">Điều khiển</p>
                        <label class="flex flex-col gap-2 text-sm font-semibold text-[#5c4d42]">
                            <span>Thời gian lặp</span>
                            <select class="cm-interval w-full rounded-lg border border-[#d4c9b8] bg-white px-3 py-2 text-sm font-bold text-[#1a1512]">
                                @foreach ($cmIntervals as $s)
                                    <option value="{{ $s }}">{{ $s }} giây</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="flex items-center justify-between gap-3 text-sm font-semibold text-[#5c4d42] cursor-pointer select-none">
                            <span>Lặp lại</span>
                            <span class="relative inline-flex h-7 w-12 shrink-0 items-center rounded-full bg-[#dcc8b0] transition-colors has-[:checked]:bg-[#c9a77c]">
                                <input type="checkbox" class="cm-repeat peer sr-only">
                                <span class="absolute left-1 top-1 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5 pointer-events-none"></span>
                            </span>
                        </label>
                    </div>
                    <p class="hidden lg:block text-sm text-[#8a7d72] leading-relaxed">Nhấn vào ảnh chuông hoặc mõ để phát âm. Bật lặp để tự động gõ lại sau khoảng thời gian đã chọn.</p>
                </aside>
                <div class="lg:col-span-8 xl:col-span-9 mt-8 lg:mt-0">
                    <div class="grid md:grid-cols-2 gap-8 xl:gap-10">
                        <button type="button" class="cm-hit-bell group flex flex-col items-center gap-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34] rounded-2xl p-2" aria-label="Gõ chuông">
                            <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?w=560&h=560&fit=crop&q=80" alt="" class="w-full max-w-md mx-auto aspect-square object-cover rounded-2xl shadow-lg border border-[#e0d8cc] group-hover:shadow-xl group-active:scale-[0.99] transition-all">
                            <span class="text-sm font-semibold text-[#5c4d42]">Chuông</span>
                        </button>
                        <button type="button" class="cm-hit-mo group flex flex-col items-center gap-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34] rounded-2xl p-2" aria-label="Gõ mõ">
                            <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=560&h=560&fit=crop&q=80" alt="" class="w-full max-w-md mx-auto aspect-square object-cover rounded-2xl shadow-lg border border-[#e0d8cc] group-hover:shadow-xl group-active:scale-[0.99] transition-all">
                            <span class="text-sm font-semibold text-[#5c4d42]">Mõ</span>
                        </button>
                    </div>
                    <p class="text-center text-sm text-[#8a7d72] mt-8 lg:hidden">Chạm vào chuông/mõ để bắt đầu gõ</p>
                </div>
            </div>
        </div>

        {{-- Gõ chuông --}}
        <div id="cm-bell" class="cm-panel hidden">
            <div class="lg:grid lg:grid-cols-12 lg:gap-10 xl:gap-12 lg:items-start">
                <aside class="lg:col-span-4 xl:col-span-3 space-y-4 lg:sticky lg:top-32">
                    <button type="button" data-cm-back class="inline-flex items-center gap-2 text-sm font-bold text-[#8b5e34] hover:underline">
                        <i class="fa-solid fa-chevron-left"></i> Tất cả chế độ
                    </button>
                    <div class="rounded-2xl border border-[#e8e0d4] bg-[#f3ebe0] px-4 py-4 space-y-4 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#8a7d72]">Điều khiển</p>
                        <label class="flex flex-col gap-2 text-sm font-semibold text-[#5c4d42]">
                            <span>Thời gian lặp</span>
                            <select class="cm-interval w-full rounded-lg border border-[#d4c9b8] bg-white px-3 py-2 text-sm font-bold text-[#1a1512]">
                                @foreach ($cmIntervals as $s)
                                    <option value="{{ $s }}">{{ $s }} giây</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="flex items-center justify-between gap-3 text-sm font-semibold text-[#5c4d42] cursor-pointer select-none">
                            <span>Lặp lại</span>
                            <span class="relative inline-flex h-7 w-12 shrink-0 items-center rounded-full bg-[#dcc8b0] transition-colors has-[:checked]:bg-[#c9a77c]">
                                <input type="checkbox" class="cm-repeat peer sr-only">
                                <span class="absolute left-1 top-1 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                            </span>
                        </label>
                    </div>
                    <p class="hidden lg:block text-sm text-[#8a7d72] leading-relaxed">Nhấn vào ảnh để gõ chuông. Âm thanh ngắn, phù hợp trước/sau giờ tụng.</p>
                </aside>
                <div class="lg:col-span-8 xl:col-span-9 mt-8 lg:mt-0 flex flex-col items-center">
                    <button type="button" class="cm-hit-bell-only w-full max-w-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34] rounded-full overflow-hidden border-4 border-[#c9a77c]/45 shadow-2xl" aria-label="Gõ chuông">
                        <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?w=720&h=720&fit=crop&q=80" alt="" class="w-full aspect-square object-cover hover:brightness-95 transition-[filter]">
                    </button>
                    <p class="text-center text-sm text-[#8a7d72] mt-8">Nhấn vào ảnh chuông để gõ</p>
                </div>
            </div>
        </div>

        {{-- Gõ mõ --}}
        <div id="cm-mo" class="cm-panel hidden">
            <div class="lg:grid lg:grid-cols-12 lg:gap-10 xl:gap-12 lg:items-start">
                <aside class="lg:col-span-4 xl:col-span-3 space-y-4 lg:sticky lg:top-32">
                    <button type="button" data-cm-back class="inline-flex items-center gap-2 text-sm font-bold text-[#8b5e34] hover:underline">
                        <i class="fa-solid fa-chevron-left"></i> Tất cả chế độ
                    </button>
                    <div class="rounded-2xl border border-[#e8e0d4] bg-[#f3ebe0] px-4 py-4 space-y-4 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#8a7d72]">Điều khiển</p>
                        <label class="flex flex-col gap-2 text-sm font-semibold text-[#5c4d42]">
                            <span>Thời gian lặp</span>
                            <select class="cm-interval w-full rounded-lg border border-[#d4c9b8] bg-white px-3 py-2 text-sm font-bold text-[#1a1512]">
                                @foreach ($cmIntervals as $s)
                                    <option value="{{ $s }}">{{ $s }} giây</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="flex items-center justify-between gap-3 text-sm font-semibold text-[#5c4d42] cursor-pointer select-none">
                            <span>Lặp lại</span>
                            <span class="relative inline-flex h-7 w-12 shrink-0 items-center rounded-full bg-[#dcc8b0] transition-colors has-[:checked]:bg-[#c9a77c]">
                                <input type="checkbox" class="cm-repeat peer sr-only">
                                <span class="absolute left-1 top-1 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                            </span>
                        </label>
                    </div>
                    <p class="hidden lg:block text-sm text-[#8a7d72] leading-relaxed">Nhấn vào ảnh mõ để nghe tiếng gõ ngắn.</p>
                </aside>
                <div class="lg:col-span-8 xl:col-span-9 mt-8 lg:mt-0 flex flex-col items-center">
                    <button type="button" class="cm-hit-mo-only w-full max-w-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34] rounded-2xl overflow-hidden border border-[#e0d8cc] shadow-xl" aria-label="Gõ mõ">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=720&h=720&fit=crop&q=80" alt="" class="w-full aspect-square object-cover hover:brightness-95 transition-[filter]">
                    </button>
                    <p class="text-center text-sm text-[#8a7d72] mt-8">Nhấn vào ảnh mõ để gõ</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var root = document.getElementById('cm-root');
            if (!root) return;

            var hub = document.getElementById('cm-hub');
            var panels = root.querySelectorAll('.cm-panel');
            var ctx = null;
            var repeatTimer = null;

            function audioCtx() {
                if (!ctx) ctx = new (window.AudioContext || window.webkitAudioContext)();
                if (ctx.state === 'suspended') ctx.resume();
                return ctx;
            }

            function bellSound() {
                try {
                    var c = audioCtx();
                    var o = c.createOscillator();
                    var g = c.createGain();
                    o.connect(g); g.connect(c.destination);
                    o.frequency.value = 830;
                    o.type = 'sine';
                    var now = c.currentTime;
                    g.gain.setValueAtTime(0.001, now);
                    g.gain.exponentialRampToValueAtTime(0.22, now + 0.02);
                    g.gain.exponentialRampToValueAtTime(0.001, now + 1.15);
                    o.start(now);
                    o.stop(now + 1.2);
                } catch (e) { console.warn(e); }
            }

            function moSound() {
                try {
                    var c = audioCtx();
                    var o = c.createOscillator();
                    var g = c.createGain();
                    o.connect(g); g.connect(c.destination);
                    o.type = 'triangle';
                    var now = c.currentTime;
                    o.frequency.setValueAtTime(220, now);
                    o.frequency.exponentialRampToValueAtTime(90, now + 0.06);
                    g.gain.setValueAtTime(0.001, now);
                    g.gain.exponentialRampToValueAtTime(0.35, now + 0.01);
                    g.gain.exponentialRampToValueAtTime(0.001, now + 0.18);
                    o.start(now);
                    o.stop(now + 0.2);
                } catch (e) { console.warn(e); }
            }

            function clearRepeat() {
                if (repeatTimer) {
                    clearTimeout(repeatTimer);
                    repeatTimer = null;
                }
            }

            function scheduleRepeat(panel, playFn) {
                clearRepeat();
                var rep = panel.querySelector('.cm-repeat');
                var sel = panel.querySelector('.cm-interval');
                if (!rep || !rep.checked) return;
                var sec = sel ? parseInt(sel.value, 10) || 0 : 0;
                var delay = Math.max(0, sec) * 1000 + 50;
                repeatTimer = setTimeout(function loop() {
                    playFn();
                    if (rep.checked) {
                        repeatTimer = setTimeout(loop, delay);
                    }
                }, delay);
            }

            function showScreen(id) {
                clearRepeat();
                hub.classList.toggle('hidden', id !== 'hub');
                panels.forEach(function (p) {
                    p.classList.toggle('hidden', p.id !== 'cm-' + id);
                });
            }

            root.querySelectorAll('[data-cm-screen]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    showScreen(btn.getAttribute('data-cm-screen'));
                });
            });

            root.querySelectorAll('[data-cm-back]').forEach(function (btn) {
                btn.addEventListener('click', function () { showScreen('hub'); });
            });

            function bindDual(panel) {
                var bBtn = panel.querySelector('.cm-hit-bell');
                var mBtn = panel.querySelector('.cm-hit-mo');
                if (bBtn) {
                    bBtn.addEventListener('click', function () {
                        bellSound();
                        scheduleRepeat(panel, function () { bellSound(); });
                    });
                }
                if (mBtn) {
                    mBtn.addEventListener('click', function () {
                        moSound();
                        scheduleRepeat(panel, function () { moSound(); });
                    });
                }
            }

            function bindBellOnly(panel) {
                var bBtn = panel.querySelector('.cm-hit-bell-only');
                if (bBtn) {
                    bBtn.addEventListener('click', function () {
                        bellSound();
                        scheduleRepeat(panel, function () { bellSound(); });
                    });
                }
            }

            function bindMoOnly(panel) {
                var mBtn = panel.querySelector('.cm-hit-mo-only');
                if (mBtn) {
                    mBtn.addEventListener('click', function () {
                        moSound();
                        scheduleRepeat(panel, function () { moSound(); });
                    });
                }
            }

            var dual = document.getElementById('cm-dual');
            var bell = document.getElementById('cm-bell');
            var mo = document.getElementById('cm-mo');
            if (dual) bindDual(dual);
            if (bell) bindBellOnly(bell);
            if (mo) bindMoOnly(mo);

            root.querySelectorAll('.cm-repeat').forEach(function (cb) {
                cb.addEventListener('change', function () { if (!cb.checked) clearRepeat(); });
            });
        })();
    </script>
</x-layouts.tool>
