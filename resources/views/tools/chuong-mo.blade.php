@php
    $asset = fn (string $name) => '/tools/chuong-mo/' . $name;
    $imgBell = $asset('commons-nepalese-singing-bowl.jpg');
    $imgMo = $asset('commons-mokugyo-2.jpg');
    // Bát hát một nhịp gõ (angeschlagen) — tránh file “gõ + cọ” nghe như hai tiếng
    $bellSampleUrl = 'https://upload.wikimedia.org/wikipedia/commons/transcoded/2/25/SingingBowl1.ogg/SingingBowl1.ogg.mp3';
    // Mõ (mokugyo) thật — CC0, Freesound / jonopodmore (Kōya-san)
    $moSampleUrl = $asset('mokugyo-koyasan-cc0.mp3');
    $cmIntervals = [0, 1, 2, 3, 5, 10];
@endphp

<x-layouts.tool title="Chuông mõ">
    <div id="cm-root" class="max-w-5xl mx-auto w-full space-y-8">
        <p class="text-[#5c4a3d] text-sm sm:text-base leading-relaxed max-w-3xl">
            Chọn chế độ bên dưới. Bấm vào ảnh chuông (bát hát) hoặc mõ để nghe; có thể bật gõ lặp theo khoảng thời gian.
        </p>

        {{-- Hub: lưới thẻ web --}}
        <div id="cm-hub" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <button type="button" data-cm-screen="dual" class="cm-hub-card group flex flex-col rounded-xl border border-[#e5dcd0] bg-white p-4 text-left shadow-sm transition hover:border-[#c9a77c] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#c9a77c]">
                <span class="flex aspect-[4/3] w-full overflow-hidden rounded-lg bg-[#f5f0e8] mb-3 ring-1 ring-black/5" aria-hidden="true">
                    <img src="{{ $imgBell }}" alt="" class="h-full w-1/2 object-cover object-center transition group-hover:opacity-95" loading="lazy" decoding="async">
                    <img src="{{ $imgMo }}" alt="" class="h-full w-1/2 object-cover object-center transition group-hover:opacity-95" loading="lazy" decoding="async">
                </span>
                <span class="font-semibold text-[#1a1512]">Gõ chuông mõ thủ công</span>
                
            </button>
            <button type="button" data-cm-screen="mo" class="cm-hub-card group flex flex-col rounded-xl border border-[#e5dcd0] bg-white p-4 text-left shadow-sm transition hover:border-[#c9a77c] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#c9a77c]">
                <span class="aspect-[4/3] w-full overflow-hidden rounded-lg bg-[#f5f0e8] mb-3 ring-1 ring-black/5">
                    <img src="{{ $imgMo }}" alt="" class="h-full w-full object-cover transition group-hover:opacity-95" loading="lazy" decoding="async">
                </span>
                <span class="font-semibold text-[#1a1512]">Gõ mõ</span>

            </button>
            <button type="button" data-cm-screen="bell" class="cm-hub-card group flex flex-col rounded-xl border border-[#e5dcd0] bg-white p-4 text-left shadow-sm transition hover:border-[#c9a77c] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#c9a77c] sm:col-span-2 lg:col-span-1">
                <span class="aspect-[4/3] w-full overflow-hidden rounded-lg bg-[#f5f0e8] mb-3 ring-1 ring-black/5">
                    <img src="{{ $imgBell }}" alt="" class="h-full w-full object-cover transition group-hover:opacity-95" loading="lazy" decoding="async">
                </span>
                <span class="font-semibold text-[#1a1512]">Gõ chuông</span>
               
            </button>
        </div>

        {{-- Gõ thủ công --}}
        <section id="cm-dual" class="cm-panel hidden rounded-xl border border-[#e5dcd0] bg-white p-6 sm:p-8 shadow-sm">
            <button type="button" data-cm-back class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-[#8b5e34] hover:text-[#6f4a2b] hover:underline">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Chọn chế độ khác
            </button>
            <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#1a1512] mb-4">Gõ thủ công</h2>
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
                <div class="flex flex-col items-center">
                    <button type="button" class="cm-hit-bell w-full max-w-sm rounded-xl border border-transparent p-4 transition hover:bg-[#faf8f5] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#c9a77c] active:scale-[0.98]" aria-label="Gõ chuông">
                        <img src="{{ $imgBell }}" alt="" class="mx-auto w-full max-h-72 object-contain drop-shadow-md" loading="lazy" decoding="async">
                    </button>
                    <p class="mt-3 text-sm text-[#7a6a5c] text-center">Bấm để gõ chuông</p>
                </div>
                <div class="flex flex-col items-center">
                    <button type="button" class="cm-hit-mo w-full max-w-sm rounded-xl border border-transparent p-4 transition hover:bg-[#faf8f5] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#c9a77c] active:scale-[0.98]" aria-label="Gõ mõ">
                        <img src="{{ $imgMo }}" alt="" class="mx-auto w-full max-h-72 object-contain" loading="lazy" decoding="async">
                    </button>
                    <p class="mt-3 text-sm text-[#7a6a5c] text-center">Bấm để gõ mõ</p>
                </div>
            </div>
        </section>

        {{-- Gõ chuông --}}
        <section id="cm-bell" class="cm-panel hidden rounded-xl border border-[#e5dcd0] bg-white p-6 sm:p-8 shadow-sm">
            <button type="button" data-cm-back class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-[#8b5e34] hover:text-[#6f4a2b] hover:underline">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Chọn chế độ khác
            </button>
            <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#1a1512] mb-4">Gõ chuông</h2>
            @include('tools.partials.chuong-mo-control-bar', ['cmIntervals' => $cmIntervals])
            <div class="mt-10 flex flex-col items-center">
                <button type="button" class="cm-hit-bell-only w-full max-w-md rounded-xl border border-transparent p-6 transition hover:bg-[#faf8f5] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#c9a77c] active:scale-[0.98]" aria-label="Gõ chuông">
                    <img src="{{ $imgBell }}" alt="" class="mx-auto w-full max-h-80 object-contain drop-shadow-lg" loading="lazy" decoding="async">
                </button>
                <p class="mt-4 text-sm text-[#7a6a5c]">Bấm vào ảnh để gõ bát.</p>
            </div>
        </section>

        {{-- Gõ mõ --}}
        <section id="cm-mo" class="cm-panel hidden rounded-xl border border-[#e5dcd0] bg-white p-6 sm:p-8 shadow-sm">
            <button type="button" data-cm-back class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-[#8b5e34] hover:text-[#6f4a2b] hover:underline">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Chọn chế độ khác
            </button>
            <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#1a1512] mb-4">Gõ mõ</h2>
            @include('tools.partials.chuong-mo-control-bar', ['cmIntervals' => $cmIntervals])
            <div class="mt-10 flex flex-col items-center">
                <button type="button" class="cm-hit-mo-only w-full max-w-md rounded-xl border border-transparent p-6 transition hover:bg-[#faf8f5] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#c9a77c] active:scale-[0.98]" aria-label="Gõ mõ">
                    <img src="{{ $imgMo }}" alt="" class="mx-auto w-full max-h-80 object-contain" loading="lazy" decoding="async">
                </button>
                <p class="mt-4 text-sm text-[#7a6a5c]">Bấm vào ảnh để gõ mõ.</p>
            </div>
        </section>

     
    </div>

    <script>
        (function () {
            var root = document.getElementById('cm-root');
            if (!root) return;

            var BELL_SAMPLE = @json($bellSampleUrl);
            var BELL_CLIP_SEC = 11;
            var MO_SAMPLE = @json($moSampleUrl);
            var MO_CLIP_SEC = 2.35;

            var hub = document.getElementById('cm-hub');
            var panels = root.querySelectorAll('.cm-panel');
            var ctx = null;
            var repeatTimer = null;
            var bellStopTimer = null;
            var moStopTimer = null;
            var bellAudio = null;
            var moAudio = null;
            var bellSampleOk = true;
            var moSampleOk = true;

            function audioCtx() {
                if (!ctx) ctx = new (window.AudioContext || window.webkitAudioContext)();
                if (ctx.state === 'suspended') ctx.resume();
                return ctx;
            }

            function ensureBellAudio() {
                if (bellAudio) return;
                bellAudio = new Audio();
                bellAudio.preload = 'auto';
                bellAudio.src = BELL_SAMPLE;
                bellAudio.addEventListener('error', function () { bellSampleOk = false; });
            }

            function ensureMoAudio() {
                if (moAudio) return;
                moAudio = new Audio();
                moAudio.preload = 'auto';
                moAudio.src = MO_SAMPLE;
                moAudio.addEventListener('error', function () { moSampleOk = false; });
            }

            function bellFromSample() {
                ensureBellAudio();
                try {
                    bellAudio.pause();
                    bellAudio.currentTime = 0;
                    var p = bellAudio.play();
                    if (p && typeof p.catch === 'function') {
                        p.catch(function () { bellSampleOk = false; bellSynthFallback(); });
                    }
                    if (bellStopTimer) clearTimeout(bellStopTimer);
                    bellStopTimer = setTimeout(function () { try { bellAudio.pause(); } catch (e) {} }, BELL_CLIP_SEC * 1000);
                } catch (e) {
                    bellSampleOk = false;
                    bellSynthFallback();
                }
            }

            function moFromSample() {
                ensureMoAudio();
                try {
                    moAudio.pause();
                    moAudio.currentTime = 0;
                    var p = moAudio.play();
                    if (p && typeof p.catch === 'function') {
                        p.catch(function () { moSampleOk = false; moSynthFallback(); });
                    }
                    if (moStopTimer) clearTimeout(moStopTimer);
                    moStopTimer = setTimeout(function () { try { moAudio.pause(); } catch (e) {} }, MO_CLIP_SEC * 1000);
                } catch (e) {
                    moSampleOk = false;
                    moSynthFallback();
                }
            }

            function bellSynthFallback() {
                try {
                    var c = audioCtx();
                    var now = c.currentTime;
                    var base = 195;
                    var ratios = [1, 2.4, 3.8, 5.5];
                    var master = c.createGain();
                    master.gain.value = 0.72;
                    var lp = c.createBiquadFilter();
                    lp.type = 'lowpass';
                    lp.frequency.value = 4200;
                    lp.Q.value = 0.5;
                    master.connect(lp);
                    lp.connect(c.destination);

                    ratios.forEach(function (r, i) {
                        var o = c.createOscillator();
                        var g = c.createGain();
                        o.type = 'sine';
                        o.frequency.value = base * r;
                        o.connect(g);
                        g.connect(master);
                        var peak = 0.12 * Math.pow(0.52, i);
                        var attack = 0.006 + i * 0.003;
                        var decay = 3.2 + i * 1.1;
                        g.gain.setValueAtTime(0.0008, now);
                        g.gain.exponentialRampToValueAtTime(Math.max(peak, 0.02), now + attack);
                        g.gain.exponentialRampToValueAtTime(0.0008, now + decay);
                        o.start(now);
                        o.stop(now + decay + 0.12);
                    });
                } catch (e) { console.warn(e); }
            }

            /** Dự phòng: gần tiếng mõ rỗng (thấp, cốc ngắn) khi không tải được MP3 */
            function moSynthFallback() {
                try {
                    var c = audioCtx();
                    var now = c.currentTime;
                    var sr = c.sampleRate;
                    var body = c.createBiquadFilter();
                    body.type = 'bandpass';
                    body.frequency.value = 285;
                    body.Q.value = 1.35;
                    var gBody = c.createGain();
                    body.connect(gBody);
                    gBody.connect(c.destination);
                    gBody.gain.setValueAtTime(0.001, now);
                    gBody.gain.linearRampToValueAtTime(0.42, now + 0.0025);
                    gBody.gain.exponentialRampToValueAtTime(0.001, now + 0.14);
                    [1, 1.48, 2.21].forEach(function (m, i) {
                        var o = c.createOscillator();
                        var g = c.createGain();
                        o.type = 'sine';
                        o.frequency.value = 168 * m;
                        o.connect(g);
                        g.connect(body);
                        var pk = 0.55 * Math.pow(0.45, i);
                        g.gain.setValueAtTime(0.0008, now);
                        g.gain.linearRampToValueAtTime(pk, now + 0.0018 + i * 0.0004);
                        g.gain.exponentialRampToValueAtTime(0.0008, now + 0.11 + i * 0.02);
                        o.start(now);
                        o.stop(now + 0.2);
                    });

                    var clickN = Math.floor(sr * 0.014);
                    var clickBuf = c.createBuffer(1, clickN, sr);
                    var cd = clickBuf.getChannelData(0);
                    for (var j = 0; j < clickN; j++) {
                        cd[j] = (Math.random() * 2 - 1) * Math.exp(-j / (sr * 0.0028));
                    }
                    var clickSrc = c.createBufferSource();
                    clickSrc.buffer = clickBuf;
                    var hp = c.createBiquadFilter();
                    hp.type = 'highpass';
                    hp.frequency.value = 1400;
                    var gClick = c.createGain();
                    clickSrc.connect(hp);
                    hp.connect(gClick);
                    gClick.connect(c.destination);
                    gClick.gain.setValueAtTime(0.28, now);
                    gClick.gain.exponentialRampToValueAtTime(0.001, now + 0.022);
                    clickSrc.start(now);
                    clickSrc.stop(now + 0.03);
                } catch (e) { console.warn(e); }
            }

            function bellSound() {
                if (bellSampleOk === false) {
                    bellSynthFallback();
                    return;
                }
                bellFromSample();
            }

            function moSound() {
                if (moSampleOk === false) {
                    moSynthFallback();
                    return;
                }
                moFromSample();
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
                if (sec <= 0) return;
                var delay = sec * 1000;
                repeatTimer = setTimeout(function loop() {
                    playFn();
                    if (rep.checked) {
                        var s = sel ? parseInt(sel.value, 10) || 0 : 0;
                        if (s > 0) repeatTimer = setTimeout(loop, s * 1000);
                    }
                }, delay);
            }

            function showScreen(id) {
                clearRepeat();
                if (hub) hub.classList.toggle('hidden', id !== 'hub');
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
                        scheduleRepeat(panel, bellSound);
                    });
                }
                if (mBtn) {
                    mBtn.addEventListener('click', function () {
                        moSound();
                        scheduleRepeat(panel, moSound);
                    });
                }
            }

            function bindBellOnly(panel) {
                var bBtn = panel.querySelector('.cm-hit-bell-only');
                if (bBtn) {
                    bBtn.addEventListener('click', function () {
                        bellSound();
                        scheduleRepeat(panel, bellSound);
                    });
                }
            }

            function bindMoOnly(panel) {
                var mBtn = panel.querySelector('.cm-hit-mo-only');
                if (mBtn) {
                    mBtn.addEventListener('click', function () {
                        moSound();
                        scheduleRepeat(panel, moSound);
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
