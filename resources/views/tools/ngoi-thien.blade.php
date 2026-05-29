<x-layouts.tool title="Ngồi thiền">
    <div class="max-w-3xl mx-auto">
    <p class="text-[#6b5346] text-base mb-6 leading-relaxed">Chọn thời lượng, nhấn <strong>Bắt đầu</strong>. Lưng thẳng, vai thả lỏng, nhẹ nhàng theo dõi hơi thở.</p>

    <div class="rounded-2xl border border-[#e8e0d4] bg-white p-6 sm:p-8 shadow-sm space-y-6">
        <div class="rounded-2xl bg-[#f7f2eb] border border-[#e8e0d4] px-3 py-3">
            <p class="text-center text-xs font-bold uppercase tracking-wider text-[#8a7d72] mb-2">Thời lượng</p>
            <div class="flex flex-wrap justify-center gap-2">
                @foreach ([5, 10, 15, 20, 30] as $m)
                    <button type="button" class="duration-btn px-4 py-2 rounded-full text-sm font-bold border border-[#d4c9b8] bg-white text-[#4a2c11] hover:border-[#8b5e34] hover:bg-[#faf6f0] transition-colors" data-min="{{ $m }}">{{ $m }} phút</button>
                @endforeach
                <button type="button" id="duration-btn-custom" class="duration-btn px-4 py-2 rounded-full text-sm font-bold border border-[#d4c9b8] bg-white text-[#4a2c11] hover:border-[#8b5e34] hover:bg-[#faf6f0] transition-colors" data-custom="1">Tùy chỉnh</button>
            </div>
            <div id="custom-duration-panel" class="hidden mt-3 pt-3 border-t border-[#e8e0d4]/80">
                <p class="text-center text-xs text-[#6b5346] mb-2">Nhập thời lượng (1–240 phút)</p>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <label for="custom-minutes" class="sr-only">Số phút</label>
                    <input
                        type="number"
                        id="custom-minutes"
                        min="1"
                        max="240"
                        value="45"
                        inputmode="numeric"
                        class="w-24 px-3 py-2 rounded-full border border-[#d4c9b8] bg-white text-center text-sm font-bold text-[#4a2c11] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/30 focus:border-[#8b5e34]"
                    >
                    <span class="text-sm font-semibold text-[#6b5346]">phút</span>
                    <button type="button" id="custom-apply" class="px-4 py-2 rounded-full bg-[#8b5e34] text-white text-sm font-bold hover:bg-[#6f4a2b]">Áp dụng</button>
                </div>
            </div>
        </div>

        <div class="text-center font-serif text-5xl sm:text-6xl font-bold text-[#1a1512] tabular-nums py-2" id="timer-display">00:00</div>

        <div class="flex flex-wrap justify-center gap-2">
            <button type="button" id="btn-start" class="px-6 py-2.5 rounded-full bg-[#8b5e34] text-white text-sm font-bold hover:bg-[#6f4a2b] shadow-sm">Bắt đầu</button>
            <button type="button" id="btn-pause" class="px-5 py-2.5 rounded-full border-2 border-[#d4c9b8] text-sm font-bold text-[#4a2c11] hover:bg-[#faf6f0]">Tạm dừng</button>
            <button type="button" id="btn-stop" class="px-5 py-2.5 rounded-full border-2 border-[#d4c9b8] text-sm font-bold text-[#4a2c11] hover:bg-[#faf6f0]">Dừng hẳn</button>
            <button type="button" id="btn-complete" class="px-6 py-2.5 rounded-full bg-[#4a2c11] text-white text-sm font-bold hover:bg-[#6f4a2b]">Hoàn thành phiên</button>
        </div>
        <p class="text-center text-sm text-[#8b5e34] min-h-[1.25rem]" id="session-message"></p>

        <div id="timer-complete-banner" class="hidden rounded-2xl border-2 border-[#8b5e34]/40 bg-gradient-to-b from-[#faf6f0] to-[#f0e6d6] px-5 py-5 text-center shadow-md" role="alert" aria-live="assertive">
            <p class="text-lg font-bold text-[#4a2c11] flex items-center justify-center gap-2">
                <i class="fa-solid fa-bell text-[#8b5e34]" aria-hidden="true"></i>
                Đã hết giờ thiền
            </p>
            <p class="mt-2 text-sm text-[#6b5346] leading-relaxed">Nam mô A Di Đà Phật. Từ từ mở mắt, vươn vai nhẹ nhàng.</p>
            <button type="button" id="timer-complete-dismiss" class="mt-4 px-5 py-2 rounded-full bg-[#8b5e34] text-white text-sm font-bold hover:bg-[#6f4a2b]">Đã hiểu</button>
        </div>
    </div>
    </div>

    <script>
        (function () {
            let totalSec = 0, remain = 0, elapsedSec = 0, id = null, running = false, startedOnServer = false, completing = false;
            let finishedNotified = false;
            let audioCtx = null;
            const display = document.getElementById('timer-display');
            const sessionMessage = document.getElementById('session-message');
            const completeBanner = document.getElementById('timer-complete-banner');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            function fmt(s) {
                const n = Number(s);
                if (!Number.isFinite(n) || n < 0) return '00:00';
                const m = Math.floor(n / 60), sec = Math.floor(n % 60);
                return String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
            }
            function getAudioCtx() {
                if (!audioCtx) {
                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                return audioCtx;
            }

            /** Chuông kinh nhẹ (3 hồi) khi hết giờ */
            function playGentleChime() {
                try {
                    var c = getAudioCtx();
                    var now = c.currentTime;
                    var notes = [392, 523.25, 659.25];
                    notes.forEach(function (freq, i) {
                        var t0 = now + i * 0.55;
                        var o = c.createOscillator();
                        var g = c.createGain();
                        o.type = 'sine';
                        o.frequency.value = freq;
                        o.connect(g);
                        g.connect(c.destination);
                        g.gain.setValueAtTime(0.0001, t0);
                        g.gain.exponentialRampToValueAtTime(0.14, t0 + 0.04);
                        g.gain.exponentialRampToValueAtTime(0.0001, t0 + 1.8);
                        o.start(t0);
                        o.stop(t0 + 1.9);
                    });
                } catch (e) { /* trình duyệt chặn audio */ }
            }

            function showCompletionNotice() {
                completeBanner.classList.remove('hidden');
                display.classList.add('text-[#8b5e34]');
                sessionMessage.textContent = 'Phiên thiền đã kết thúc.';
            }

            function hideCompletionNotice() {
                completeBanner.classList.add('hidden');
                display.classList.remove('text-[#8b5e34]');
            }

            function tryBrowserNotify() {
                if (!('Notification' in window) || Notification.permission !== 'granted') return;
                try {
                    new Notification('Đã hết giờ thiền', {
                        body: 'Nam mô A Di Đà Phật — từ từ mở mắt, thư giãn.',
                        icon: '{{ asset('favicon-32x32.png') }}?v=10',
                        tag: 'meditation-done',
                    });
                } catch (e) { /* bỏ qua */ }
            }

            function onTimeUp() {
                if (finishedNotified) return;
                finishedNotified = true;
                clearInterval(id);
                id = null;
                running = false;
                display.textContent = fmt(0);
                showCompletionNotice();
                playGentleChime();
                tryBrowserNotify();
                autoCompleteIfNeeded();
            }

            function tick() {
                if (remain <= 0) {
                    onTimeUp();
                    return;
                }
                remain--;
                elapsedSec++;
                display.textContent = fmt(remain);
                if (remain <= 0) {
                    onTimeUp();
                }
            }

            document.getElementById('timer-complete-dismiss').addEventListener('click', hideCompletionNotice);
            const customPanel = document.getElementById('custom-duration-panel');
            const customMinutesInput = document.getElementById('custom-minutes');
            const customBtn = document.getElementById('duration-btn-custom');

            function setActiveDuration(btn) {
                document.querySelectorAll('.duration-btn').forEach(function (el) {
                    el.classList.remove('border-[#8b5e34]', 'bg-[#8b5e34]', 'text-white', 'shadow-sm');
                    el.classList.add('border-[#d4c9b8]', 'bg-white', 'text-[#4a2c11]');
                });
                if (btn) {
                    btn.classList.remove('border-[#d4c9b8]', 'bg-white', 'text-[#4a2c11]');
                    btn.classList.add('border-[#8b5e34]', 'bg-[#8b5e34]', 'text-white', 'shadow-sm');
                }
            }

            function applyDuration(mins) {
                if (running) return false;
                if (!Number.isFinite(mins) || mins < 1 || mins > 240) {
                    alert('Chọn từ 1 đến 240 phút.');
                    return false;
                }
                totalSec = Math.floor(mins) * 60;
                remain = totalSec;
                elapsedSec = 0;
                display.textContent = fmt(remain);
                sessionMessage.textContent = '';
                finishedNotified = false;
                hideCompletionNotice();
                return true;
            }

            document.querySelectorAll('.duration-btn').forEach(function (b) {
                b.addEventListener('click', function () {
                    if (running) return;
                    if (b.dataset.custom === '1') {
                        customPanel.classList.remove('hidden');
                        customMinutesInput.focus();
                        setActiveDuration(b);
                        return;
                    }
                    customPanel.classList.add('hidden');
                    const mins = parseInt(b.getAttribute('data-min') || '0', 10);
                    if (!applyDuration(mins)) return;
                    setActiveDuration(b);
                });
            });

            document.getElementById('custom-apply').addEventListener('click', function () {
                if (running) return;
                const mins = parseInt(customMinutesInput.value, 10);
                if (!applyDuration(mins)) return;
                setActiveDuration(customBtn);
            });

            customMinutesInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('custom-apply').click();
                }
            });

            async function postJson(url, payload) {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) {
                    throw new Error('Có lỗi khi gửi dữ liệu.');
                }

                return response.json();
            }

            async function completeSession(auto = false) {
                if (completing) return;
                if (!startedOnServer || elapsedSec <= 0) {
                    sessionMessage.textContent = 'Bạn cần bấm Bắt đầu và thiền ít nhất vài giây.';
                    return;
                }

                if (id) {
                    clearInterval(id);
                    id = null;
                    running = false;
                }

                completing = true;
                try {
                    await postJson("{{ route('tools.meditation.complete') }}", {
                        actual_seconds: elapsedSec,
                        planned_minutes: Math.floor(totalSec / 60)
                    });
                    sessionMessage.textContent = auto
                        ? 'Đã tự động lưu phiên thiền khi hết giờ.'
                        : 'Đã lưu phiên thiền thành công.';
                    startedOnServer = false;
                    elapsedSec = 0;
                } catch (error) {
                    sessionMessage.textContent = error.message || 'Không thể lưu phiên thiền.';
                } finally {
                    completing = false;
                }
            }

            function autoCompleteIfNeeded() {
                if (startedOnServer && elapsedSec > 0 && remain <= 0) {
                    completeSession(true);
                }
            }

            document.getElementById('btn-start').onclick = async function () {
                if (remain <= 0 && totalSec > 0) remain = totalSec;
                if (remain <= 0) {
                    alert(totalSec <= 0 ? 'Chọn hoặc nhập thời lượng trước.' : 'Chọn số phút trước.');
                    return;
                }
                if (id) return;

                try {
                    if ('Notification' in window && Notification.permission === 'default') {
                        Notification.requestPermission().catch(function () {});
                    }
                    getAudioCtx();
                    if (!startedOnServer) {
                        await postJson("{{ route('tools.meditation.start') }}", {
                            planned_minutes: Math.floor(totalSec / 60)
                        });
                        startedOnServer = true;
                    }
                    finishedNotified = false;
                    hideCompletionNotice();
                    running = true;
                    id = setInterval(tick, 1000);
                    sessionMessage.textContent = 'Phiên thiền đang diễn ra...';
                } catch (error) {
                    sessionMessage.textContent = error.message || 'Không thể bắt đầu phiên thiền.';
                }
            };
            document.getElementById('btn-pause').onclick = function () {
                if (id) { clearInterval(id); id = null; running = false; }
            };
            document.getElementById('btn-stop').onclick = function () {
                if (id) { clearInterval(id); id = null; }
                running = false;
                remain = totalSec;
                elapsedSec = 0;
                startedOnServer = false;
                finishedNotified = false;
                hideCompletionNotice();
                display.textContent = fmt(remain);
                sessionMessage.textContent = 'Đã dừng phiên. Có thể bấm Bắt đầu lại.';
            };

            document.getElementById('btn-complete').onclick = function () {
                completeSession(false);
            };
        })();
    </script>
</x-layouts.tool>
