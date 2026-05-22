<x-layouts.tool title="Cây Bồ Đề Pháp Cú">
    @push('head')
        <style>
            .phap-cu-leaf { cursor: pointer; transition: filter 0.2s ease; }
            .phap-cu-leaf:hover,
            .phap-cu-leaf:focus-visible { filter: drop-shadow(0 0 5px rgba(139, 94, 52, 0.55)) brightness(1.12); outline: none; }
            #phap-cu-tree-wrap { max-height: min(72vh, 580px); }
            .phap-cu-kinh-ke {
                position: relative;
                background: linear-gradient(180deg, #faf6f0 0%, #f7f2eb 100%);
                border-radius: 1rem;
                padding: 1.5rem 1.25rem 1.35rem;
                border: 1px solid #e8e0d4;
                text-align: center;
            }
            .phap-cu-kinh-ke-quote {
                position: absolute;
                top: 0.75rem;
                left: 1rem;
                font-size: 1.5rem;
                line-height: 1;
                color: #dcc8b0;
            }
            .phap-cu-kinh-text {
                margin: 0;
                font-family: 'Noto Serif Display', Georgia, serif;
                font-style: italic;
                font-size: 1.05rem;
                line-height: 1.75;
                color: #1a1512;
                letter-spacing: 0.01em;
            }
            @keyframes phap-cu-toast-in {
                from { opacity: 0; transform: translateY(8px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .phap-cu-toast-show { animation: phap-cu-toast-in 0.25s ease forwards; }
        </style>
    @endpush

    <div class="max-w-5xl mx-auto space-y-6 lg:space-y-8">
        <p class="text-[#6b5346] text-base leading-relaxed max-w-3xl">
            Tán lá đại thụ che chở <strong class="text-[#1a1512]"><span id="phap-cu-total-display">423</span> câu kinh kệ</strong> Kinh Pháp Cú (bản dịch HT. Thích Minh Châu) — mỗi lá ứng một câu. Hãy lắng lòng, chọn một chiếc lá bạn thấy có duyên nhất để đón nhận lời Phật dạy.
        </p>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8 xl:gap-10 lg:items-start">
            {{-- Hướng dẫn & thao tác --}}
            <div class="lg:col-span-4 xl:col-span-3 space-y-4 order-2 lg:order-1">
                <div class="rounded-2xl border border-[#e8e0d4] bg-white p-5 shadow-sm space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-[#8a7d72]">Cách hái lộc</h2>
                    <ol class="space-y-3 text-sm text-[#5c4a3d] leading-relaxed list-decimal list-inside marker:text-[#8b5e34] marker:font-bold">
                        <li>Chạm vào một chiếc lá trên cây Bồ Đề</li>
                        <li>Hoặc bấm <strong class="text-[#1a1512]">Hái lộc ngẫu nhiên</strong> để Phật pháp chỉ đường</li>
                        <li>Đọc kệ kinh và lời khuyên tu tập, rồi suy ngẫm trong ngày</li>
                    </ol>
                </div>

                <div class="rounded-2xl border border-[#e8e0d4] bg-[#f7f2eb] px-4 py-3 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#8a7d72]">Số lá trên cây</p>
                        <p class="text-2xl font-bold text-[#1a1512] tabular-nums mt-0.5"><span id="phap-cu-leaf-count">423</span></p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white border border-[#e8e0d4] text-[#8b5e34] shadow-inner" aria-hidden="true">
                        <i class="fa-solid fa-leaf text-lg"></i>
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                    <button type="button" id="phap-cu-random-btn" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-full bg-[#8b5e34] hover:bg-[#6f4a2b] text-white text-sm font-bold shadow-sm transition active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/50">
                        <i class="fa-solid fa-shuffle text-sm" aria-hidden="true"></i>
                        Hái lộc ngẫu nhiên
                    </button>
                    <button type="button" id="phap-cu-sound-btn" class="w-full sm:w-auto lg:w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-full border-2 border-[#d4c9b8] bg-white text-[#4a2c11] text-sm font-bold hover:bg-[#faf6f0] transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40" aria-label="Bật tắt âm thanh">
                        <i class="fa-solid fa-volume-high text-sm" aria-hidden="true"></i>
                        <span id="phap-cu-sound-label">Âm thanh</span>
                    </button>
                </div>
            </div>

            {{-- Cây --}}
            <div class="lg:col-span-8 xl:col-span-9 order-1 lg:order-2">
                <div class="rounded-2xl border border-[#e8e0d4] bg-white p-4 sm:p-6 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#8a7d72] mb-3 text-center lg:text-left">Cây Bồ Đề — chạm lá để mở lộc</p>
                    <div id="phap-cu-tree-wrap" class="relative w-full aspect-square max-w-[600px] mx-auto overflow-hidden rounded-2xl ring-1 ring-[#e8e0d4] bg-[#f5f0e8]">
                        <img src="{{ asset('caykhongla.png') }}" alt="Cây Bồ Đề Pháp Cú" class="absolute inset-0 w-full h-full object-cover select-none pointer-events-none" width="600" height="600" loading="eager" decoding="async" />
                        <svg id="phap-cu-tree-svg" class="absolute inset-0 w-full h-full z-10" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <g id="phap-cu-leaves"></g>
                        </svg>
                    </div>
                    <p class="text-center text-xs text-[#8a7d72] mt-4 leading-relaxed">
                        Di chuột hoặc chạm lá sáng lên khi có duyên · Mỗi lá tương ứng đúng một câu trong bộ 423 câu
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal lộc --}}
    <div id="phap-cu-modal" class="hidden fixed inset-0 z-50 bg-[#1a1512]/40 backdrop-blur-[2px] flex items-end sm:items-center justify-center p-0 sm:p-4" role="dialog" aria-modal="true" aria-labelledby="phap-cu-modal-chapter">
        <div id="phap-cu-modal-panel" class="bg-white border border-[#e8e0d4] w-full sm:max-w-lg rounded-t-3xl sm:rounded-2xl p-6 sm:p-8 shadow-2xl relative transform translate-y-4 sm:translate-y-0 opacity-0 transition-all duration-300 max-h-[92vh] overflow-y-auto" onclick="event.stopPropagation()">
            <button type="button" id="phap-cu-modal-close" class="absolute top-4 right-4 w-9 h-9 flex items-center justify-center text-[#8b5e34] hover:text-[#4a2c11] hover:bg-[#faf6f0] rounded-full border border-[#e8e0d4] transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40" aria-label="Đóng">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>

            <div class="text-center pr-8 space-y-2">
                <span class="text-[10px] uppercase tracking-[0.3em] text-[#8a7d72] font-bold block" id="phap-cu-modal-id">PHÁP CÚ</span>
                <h3 id="phap-cu-modal-chapter" class="font-serif text-2xl sm:text-3xl font-bold text-[#5c4630] tracking-wide leading-tight"></h3>
            </div>

            <div class="w-10 h-px bg-[#e8e0d4] mx-auto my-5"></div>

            <div class="phap-cu-kinh-ke">
                <i class="fa-solid fa-quote-left phap-cu-kinh-ke-quote" aria-hidden="true"></i>
                <p id="phap-cu-modal-content" class="phap-cu-kinh-text relative z-10 px-2" aria-live="polite"></p>
            </div>

            <div class="mt-5 rounded-xl border border-[#e8e0d4] bg-[#f7f2eb] px-4 py-4 text-left">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8b5e34] mb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-seedling text-[10px]" aria-hidden="true"></i>
                    Lời khuyên tu tập hành trì
                </p>
                <p class="text-sm text-[#5c4a3d] leading-relaxed" id="phap-cu-modal-advice"></p>
            </div>

            <div class="flex items-center justify-center gap-4 sm:gap-6 pt-5 mt-2 border-t border-[#efe8dc]">
                <button type="button" id="phap-cu-copy-btn" class="text-[#8b5e34] hover:text-[#4a2c11] transition text-xs flex items-center gap-2 font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40 rounded-lg px-1 py-1">
                    <i class="fa-regular fa-copy" aria-hidden="true"></i>
                    <span>Lưu Lời Kinh</span>
                </button>
                <span class="text-[#e8e0d4]" aria-hidden="true">|</span>
                <button type="button" id="phap-cu-modal-done" class="px-6 py-2.5 rounded-full bg-[#8b5e34] hover:bg-[#6f4a2b] text-white text-xs tracking-wider font-bold shadow-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/50">
                    Đóng lại
                </button>
            </div>

            <div id="phap-cu-copy-fallback" class="hidden mt-4 text-left rounded-xl border border-[#e8e0d4] bg-[#faf6f0] p-3">
                <p class="text-xs font-bold text-[#8b5e34] mb-2">Sao chép thủ công</p>
                <textarea id="phap-cu-copy-fallback-text" rows="6" class="w-full text-xs text-[#1a1512] rounded-lg border border-[#e8e0d4] p-2 font-serif leading-relaxed resize-y" readonly></textarea>
                <p class="text-[11px] text-[#8a7d72] mt-1.5">Chọn toàn bộ (Ctrl+A) rồi sao chép (Ctrl+C hoặc Cmd+C).</p>
            </div>
        </div>
    </div>

    <div id="phap-cu-toast" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-[60] px-4 py-2.5 rounded-full bg-[#1a1512] text-[#f9f3e6] text-sm font-semibold shadow-lg" role="status" aria-live="polite"></div>

    <script>
        (function () {
            const DATA_URL = @json(asset('data/kinh-phap-cu.json'));
            const TONG_SO_LA = 423;
            const LEAF_COLORS = [
                'fill-[#FFFBF2] stroke-[#BDAB92]',
                'fill-[#F6ECD5] stroke-[#9E8664]',
                'fill-[#E2D2B8] stroke-[#8F7C60]',
                'fill-[#CFAF80] stroke-[#6E593E]',
                'fill-[#BDA07A] stroke-[#544330]',
                'fill-[#A89270] stroke-[#453A2A]',
                'fill-[#A69083] stroke-[#5C4D44]',
                'fill-[#9FA8A3] stroke-[#5E6662]',
            ];
            const VUNG_TAN = [
                { cx: 400, cy: 300, rx: 250, ry: 130 },
                { cx: 240, cy: 330, rx: 170, ry: 130 },
                { cx: 560, cy: 330, rx: 170, ry: 130 },
                { cx: 180, cy: 420, rx: 140, ry: 120 },
                { cx: 620, cy: 420, rx: 140, ry: 120 },
                { cx: 280, cy: 240, rx: 150, ry: 100 },
                { cx: 520, cy: 240, rx: 150, ry: 100 },
            ];

            let danhSachXam = [];
            let isSoundEnabled = true;
            let kinhKeDangHien = '';
            let verseHienTai = null;
            let toastTimer = null;

            function tenPham(v) {
                return v.chapter ? `Phẩm ${v.chapter}` : 'Kinh Pháp Cú';
            }

            function hienKinhKe(content) {
                kinhKeDangHien = (content || '').trim();
                document.getElementById('phap-cu-modal-content').textContent = kinhKeDangHien;
            }

            function showToast(msg) {
                const el = document.getElementById('phap-cu-toast');
                el.textContent = msg;
                el.classList.remove('hidden');
                el.classList.add('phap-cu-toast-show');
                clearTimeout(toastTimer);
                toastTimer = setTimeout(() => {
                    el.classList.add('hidden');
                    el.classList.remove('phap-cu-toast-show');
                }, 2600);
            }

            function copyTextToClipboard(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    return navigator.clipboard.writeText(text);
                }
                return new Promise((resolve, reject) => {
                    const ta = document.createElement('textarea');
                    ta.value = text;
                    ta.setAttribute('readonly', '');
                    ta.style.cssText = 'position:fixed;left:-9999px;top:0;opacity:0';
                    document.body.appendChild(ta);
                    ta.focus();
                    ta.select();
                    ta.setSelectionRange(0, text.length);
                    let ok = false;
                    try {
                        ok = document.execCommand('copy');
                    } catch (err) {
                        ok = false;
                    }
                    document.body.removeChild(ta);
                    ok ? resolve() : reject(new Error('execCommand failed'));
                });
            }

            const modal = document.getElementById('phap-cu-modal');
            const modalPanel = document.getElementById('phap-cu-modal-panel');
            const leavesEl = document.getElementById('phap-cu-leaves');

            function layDuLieu(verseIndex) {
                const i = Number(verseIndex);
                if (!Number.isFinite(i) || i < 0 || i >= danhSachXam.length) return null;
                return danhSachXam[i];
            }

            function khoiTaoLa() {
                leavesEl.innerHTML = '';
                const viTri = [];
                const mucTieuLa = Math.min(TONG_SO_LA, danhSachXam.length);
                const dMin = 13.2;
                let dem = 0;
                let vong = 0;

                while (dem < mucTieuLa && vong < 150000) {
                    vong++;
                    const vung = VUNG_TAN[dem % VUNG_TAN.length];
                    const alpha = Math.random() * Math.PI * 2;
                    const rFactor = 0.62 + (Math.sqrt(Math.random()) * 0.38);
                    const x = vung.cx + Math.cos(alpha) * rFactor * vung.rx;
                    const y = vung.cy + Math.sin(alpha) * rFactor * vung.ry;

                    if (y > 610 || y < 95 || x < 45 || x > 755) continue;
                    if (y > 435 && x > 345 && x < 455) continue;

                    let trung = false;
                    for (let i = 0; i < viTri.length; i++) {
                        const p = viTri[i];
                        if (Math.hypot(x - p.x, y - p.y) < dMin) {
                            trung = true;
                            break;
                        }
                    }
                    if (trung) continue;

                    viTri.push({ x, y });
                    const coLa = Math.random() * 1.2 + 7.5;
                    const rotate = (Math.random() * 50 - 25) + (x < 400 ? -30 : 30);
                    const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
                    g.setAttribute('transform', `translate(${x}, ${y}) rotate(${rotate})`);
                    g.setAttribute('class', 'phap-cu-leaf');
                    g.setAttribute('role', 'button');
                    g.setAttribute('tabindex', '0');
                    const leafIndex = dem;
                    const verseIndex = leafIndex;
                    const soCau = danhSachXam[verseIndex]?.number ?? verseIndex + 1;
                    g.setAttribute('aria-label', `Lá ${leafIndex + 1} — Câu ${soCau}`);
                    g.dataset.verseIndex = String(verseIndex);

                    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('d', 'M0,-5 C-5.5,-1 -8,5 -4.5,12 C-2.5,15 2.5,15 4.5,12 C8,5 5.5,-1 0,-5 Z');
                    path.setAttribute('class', LEAF_COLORS[leafIndex % LEAF_COLORS.length]);
                    path.setAttribute('style', `transform: scale(${coLa / 10});`);
                    path.setAttribute('pointer-events', 'all');
                    g.appendChild(path);

                    const moLocTuLa = (e) => {
                        e.stopPropagation();
                        moLoc(Number(e.currentTarget.dataset.verseIndex));
                    };
                    g.addEventListener('click', moLocTuLa);
                    g.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            moLoc(Number(g.dataset.verseIndex));
                        }
                    });

                    leavesEl.appendChild(g);
                    dem++;
                }

                document.getElementById('phap-cu-leaf-count').textContent = String(dem);
            }

            function playBowl() {
                if (!isSoundEnabled) return;
                try {
                    const Ctx = window.AudioContext || window.webkitAudioContext;
                    const ctx = new Ctx();
                    const fundamental = 165;
                    const harmonics = [1.0, 1.98, 2.44, 3.0];
                    const gains = [0.35, 0.16, 0.06, 0.02];
                    const mainGain = ctx.createGain();
                    mainGain.gain.setValueAtTime(0, ctx.currentTime);
                    mainGain.gain.linearRampToValueAtTime(0.22, ctx.currentTime + 0.08);
                    mainGain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 4.2);
                    harmonics.forEach((h, i) => {
                        const osc = ctx.createOscillator();
                        const g = ctx.createGain();
                        osc.frequency.setValueAtTime(fundamental * h, ctx.currentTime);
                        g.gain.setValueAtTime(gains[i], ctx.currentTime);
                        osc.connect(g);
                        g.connect(mainGain);
                        osc.start();
                        osc.stop(ctx.currentTime + 4.2);
                    });
                    mainGain.connect(ctx.destination);
                } catch (e) { /* ignore */ }
            }

            function moLoc(verseIndex) {
                const v = layDuLieu(verseIndex);
                if (!v) return;
                verseHienTai = v;
                document.getElementById('phap-cu-modal-id').textContent = `Kinh Pháp Cú — Câu ${v.number}`;
                document.getElementById('phap-cu-modal-chapter').textContent = tenPham(v);
                hienKinhKe(v.content || '');
                document.getElementById('phap-cu-modal-advice').textContent = v.advice || '';
                document.getElementById('phap-cu-copy-fallback')?.classList.add('hidden');

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                requestAnimationFrame(() => {
                    modalPanel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0');
                    modalPanel.classList.add('opacity-100');
                });
                playBowl();
            }

            function dongModal() {
                modalPanel.classList.remove('opacity-100');
                modalPanel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0');
                document.body.style.overflow = '';
                setTimeout(() => modal.classList.add('hidden'), 280);
            }

            function noiDungLuuLoiKinh() {
                if (!verseHienTai) return '';
                const id = `Kinh Pháp Cú - Câu ${verseHienTai.number}`;
                const title = tenPham(verseHienTai);
                const content = kinhKeDangHien;
                const advice = document.getElementById('phap-cu-modal-advice').textContent;
                return `${id} - ${title}\n\nLời Vàng Kinh Điển: ${content}\n\nỨng Dụng Hành Trì: ${advice}`;
            }

            function luuLoiKinh(e) {
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                if (!verseHienTai) {
                    alert('Chưa có lời kinh để lưu. Hãy chọn một lá trên cây trước.');
                    return;
                }
                const text = noiDungLuuLoiKinh();
                copyTextToClipboard(text)
                    .then(() => {
                        alert('Thành kính lưu lời vàng kinh Pháp Cú thành công!');
                    })
                    .catch(() => {
                        const fallback = document.getElementById('phap-cu-copy-fallback');
                        const area = document.getElementById('phap-cu-copy-fallback-text');
                        if (fallback && area) {
                            area.value = text;
                            fallback.classList.remove('hidden');
                            area.focus();
                            area.select();
                            showToast('Trình duyệt chặn sao chép — hãy bấm Ctrl+C (hoặc Cmd+C)');
                        } else {
                            window.prompt('Sao chép thủ công (Ctrl+C / Cmd+C):', text);
                        }
                    });
            }

            document.getElementById('phap-cu-random-btn').addEventListener('click', () => {
                const total = danhSachXam.length;
                if (total > 0) moLoc(Math.floor(Math.random() * total));
            });

            document.getElementById('phap-cu-sound-btn').addEventListener('click', () => {
                isSoundEnabled = !isSoundEnabled;
                const btn = document.getElementById('phap-cu-sound-btn');
                const label = document.getElementById('phap-cu-sound-label');
                btn.querySelector('i').className = isSoundEnabled
                    ? 'fa-solid fa-volume-high text-sm'
                    : 'fa-solid fa-volume-xmark text-sm';
                if (label) label.textContent = isSoundEnabled ? 'Âm thanh' : 'Đã tắt âm thanh';
                btn.classList.toggle('opacity-60', !isSoundEnabled);
            });

            document.getElementById('phap-cu-modal-close').addEventListener('click', dongModal);
            document.getElementById('phap-cu-modal-done').addEventListener('click', dongModal);
            document.getElementById('phap-cu-copy-btn').addEventListener('click', (e) => luuLoiKinh(e));
            modal.addEventListener('click', dongModal);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) dongModal();
            });

            fetch(DATA_URL)
                .then((r) => {
                    if (!r.ok) throw new Error('load failed');
                    return r.json();
                })
                .then((data) => {
                    danhSachXam = data.verses || [];
                    document.getElementById('phap-cu-total-display').textContent = String(
                        data.meta?.total || danhSachXam.length
                    );
                    khoiTaoLa();
                })
                .catch(() => {
                    document.getElementById('phap-cu-leaf-count').textContent = '0';
                    showToast('Không tải được dữ liệu — thử lại sau');
                });
        })();
    </script>
</x-layouts.tool>
