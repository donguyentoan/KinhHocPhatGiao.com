<x-layouts.tool title="Ngồi thiền">
    <div class="max-w-3xl mx-auto">
    <p class="text-[#6b5346] text-base mb-6 leading-relaxed">Chọn thời lượng, nhấn <strong>Bắt đầu</strong>. Lưng thẳng, vai thả lỏng, nhẹ nhàng theo dõi hơi thở.</p>

    <div class="rounded-2xl border border-[#e8e0d4] bg-white p-6 sm:p-8 shadow-sm space-y-6">
        <div class="rounded-2xl bg-[#f7f2eb] border border-[#e8e0d4] px-3 py-3">
            <p class="text-center text-xs font-bold uppercase tracking-wider text-[#8a7d72] mb-2">Thời lượng</p>
            <div class="flex flex-wrap justify-center gap-2">
                @foreach ([5, 10, 15, 20, 30] as $m)
                    <button type="button" class="duration-btn px-4 py-2 rounded-full text-sm font-bold border border-[#d4c9b8] bg-white text-[#4a2c11] hover:border-[#8b5e34] hover:bg-[#faf6f0] data-min="{{ $m }}">{{ $m }} phút</button>
                @endforeach
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
    </div>
    </div>

    <script>
        (function () {
            let totalSec = 0, remain = 0, elapsedSec = 0, id = null, running = false, startedOnServer = false, completing = false;
            const display = document.getElementById('timer-display');
            const sessionMessage = document.getElementById('session-message');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            function fmt(s) {
                const m = Math.floor(s / 60), sec = s % 60;
                return String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
            }
            function tick() {
                if (remain <= 0) {
                    clearInterval(id); id = null; running = false; display.textContent = fmt(0);
                    autoCompleteIfNeeded();
                    return;
                }
                remain--;
                elapsedSec++;
                display.textContent = fmt(remain);
                if (remain <= 0) {
                    clearInterval(id); id = null; running = false;
                    autoCompleteIfNeeded();
                }
            }
            document.querySelectorAll('.duration-btn').forEach(function (b) {
                b.addEventListener('click', function () {
                    if (running) return;
                    totalSec = parseInt(b.dataset.min, 10) * 60;
                    remain = totalSec;
                    elapsedSec = 0;
                    display.textContent = fmt(remain);
                    sessionMessage.textContent = '';
                });
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
                if (remain <= 0) { alert('Chọn số phút trước.'); return; }
                if (id) return;

                try {
                    if (!startedOnServer) {
                        await postJson("{{ route('tools.meditation.start') }}", {
                            planned_minutes: Math.floor(totalSec / 60)
                        });
                        startedOnServer = true;
                    }
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
                display.textContent = fmt(remain);
                sessionMessage.textContent = 'Đã dừng phiên. Có thể bấm Bắt đầu lại.';
            };

            document.getElementById('btn-complete').onclick = function () {
                completeSession(false);
            };
        })();
    </script>
</x-layouts.tool>
