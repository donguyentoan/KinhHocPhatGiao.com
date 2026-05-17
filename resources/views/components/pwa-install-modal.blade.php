{{-- Popup hướng dẫn «Thêm vào màn hình chính» — mở bằng nút [data-pwa-install-open] --}}
<div
    id="pwa-install-modal"
    class="fixed inset-0 z-[110] hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="pwa-install-modal-title"
    aria-hidden="true"
>
    <div class="w-full max-w-md rounded-2xl border border-[#d9b68e] bg-gradient-to-b from-[#fffaf2] to-[#fff5e6] shadow-2xl text-[#4a2c11] overflow-hidden">
        <div class="flex items-start justify-between gap-3 px-5 pt-5 pb-3 border-b border-[#d9b68e]/40">
            <div>
                <h2 id="pwa-install-modal-title" class="text-lg font-bold text-[#4a2c11]">Tải ứng dụng</h2>
                <p class="text-sm text-[#6d4621] mt-1">Thêm vào Màn hình chính để mở như app</p>
            </div>
            <button
                type="button"
                id="pwa-install-modal-close"
                class="flex-shrink-0 w-9 h-9 rounded-full border border-[#c9a882] text-[#6d4621] hover:bg-white/80 transition-colors"
                aria-label="Đóng"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="px-5 py-4 space-y-4 max-h-[min(70vh,28rem)] overflow-y-auto">
            <div id="pwa-install-modal-native-wrap" class="hidden">
                <button
                    type="button"
                    id="pwa-install-modal-native-btn"
                    class="w-full py-3 rounded-xl bg-[#8b5e34] text-white font-bold hover:bg-[#6f4a2b] transition-colors"
                >
                    <i class="fa-solid fa-download mr-2" aria-hidden="true"></i>Cài đặt ngay
                </button>
                <p class="text-xs text-[#8a7d72] text-center mt-2">Hoặc làm theo hướng dẫn bên dưới</p>
            </div>

            <div id="pwa-install-panel-ios" class="hidden">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8b5e34] mb-2">iPhone / iPad (Safari)</p>
                <ol class="list-decimal list-inside space-y-2 text-sm text-[#4a2c11] leading-relaxed">
                    <li>Mở trang này bằng <strong>Safari</strong></li>
                    <li>Nhấn nút <strong>Chia sẻ</strong> <i class="fa-solid fa-arrow-up-from-bracket text-[#8b5e34]" aria-hidden="true"></i> (dưới thanh địa chỉ)</li>
                    <li>Chọn <strong>Thêm vào Màn hình chính</strong></li>
                    <li>Nhấn <strong>Thêm</strong> ở góc trên bên phải</li>
                </ol>
            </div>

            <div id="pwa-install-panel-android" class="hidden">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8b5e34] mb-2">Android (Chrome)</p>
                <ol class="list-decimal list-inside space-y-2 text-sm text-[#4a2c11] leading-relaxed">
                    <li>Mở trang bằng <strong>Chrome</strong></li>
                    <li>Nhấn menu <strong><i class="fa-solid fa-ellipsis-vertical" aria-hidden="true"></i></strong> (góc trên phải)</li>
                    <li>Chọn <strong>Cài đặt ứng dụng</strong> hoặc <strong>Thêm vào màn hình chính</strong></li>
                    <li>Xác nhận <strong>Cài đặt</strong> / <strong>Thêm</strong></li>
                </ol>
            </div>

            <div id="pwa-install-panel-desktop" class="hidden">
                <p class="text-xs font-bold uppercase tracking-wider text-[#8b5e34] mb-2">Máy tính (Chrome / Edge)</p>
                <ol class="list-decimal list-inside space-y-2 text-sm text-[#4a2c11] leading-relaxed">
                    <li>Nhìn thanh địa chỉ, nhấn biểu tượng <strong>cài đặt</strong> <i class="fa-solid fa-display text-[#8b5e34]" aria-hidden="true"></i> (nếu có)</li>
                    <li>Chọn <strong>Cài đặt</strong> hoặc <strong>Thêm vào màn hình chính</strong></li>
                    <li>Trên điện thoại: dùng hướng dẫn iPhone hoặc Android ở trên</li>
                </ol>
            </div>
        </div>

        <div class="px-5 pb-5">
            <button
                type="button"
                id="pwa-install-modal-ok"
                class="w-full py-2.5 rounded-xl border border-[#c9a882] text-[#6d4621] font-semibold hover:bg-white/60 transition-colors"
            >
                Đã hiểu
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('pwa-install-modal');
    var panelIos = document.getElementById('pwa-install-panel-ios');
    var panelAndroid = document.getElementById('pwa-install-panel-android');
    var panelDesktop = document.getElementById('pwa-install-panel-desktop');
    var nativeWrap = document.getElementById('pwa-install-modal-native-wrap');
    var nativeBtn = document.getElementById('pwa-install-modal-native-btn');
    var btnClose = document.getElementById('pwa-install-modal-close');
    var btnOk = document.getElementById('pwa-install-modal-ok');
    if (!modal) return;

    var deferredPrompt = null;
    var lastFocus = null;

    function isIos() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent) ||
            (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    }
    function isAndroid() {
        return /Android/i.test(navigator.userAgent);
    }
    function isStandalone() {
        return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
    }

    function setPanel(el, show) {
        if (!el) return;
        el.classList.toggle('hidden', !show);
    }

    function updatePanels() {
        var ios = isIos();
        var android = isAndroid();
        setPanel(panelIos, ios);
        setPanel(panelAndroid, android && !ios);
        setPanel(panelDesktop, !ios && !android);
        if (nativeWrap) {
            nativeWrap.classList.toggle('hidden', !deferredPrompt || ios);
        }
    }

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredPrompt = e;
        updatePanels();
    });

    function openModal() {
        if (isStandalone()) return;
        lastFocus = document.activeElement;
        updatePanels();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        if (btnClose) btnClose.focus();
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
    }

    window.openPwaInstallModal = openModal;
    window.closePwaInstallModal = closeModal;

    document.querySelectorAll('[data-pwa-install-open]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
        if (isStandalone()) el.classList.add('hidden');
    });

    if (nativeBtn) {
        nativeBtn.addEventListener('click', function () {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            deferredPrompt.userChoice.finally(function () {
                deferredPrompt = null;
                updatePanels();
                closeModal();
            });
        });
    }

    [btnClose, btnOk].forEach(function (btn) {
        if (btn) btn.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });
})();
</script>
