{{-- Gợi ý thêm vào màn hình chính: Chrome dùng beforeinstallprompt; Safari iOS cần hướng dẫn thủ công --}}
<div id="pwa-install-banner" class="pwa-install-banner" hidden role="dialog" aria-labelledby="pwa-install-title" aria-live="polite">
    <div class="pwa-install-banner__inner">
        <div class="pwa-install-banner__text">
            <strong id="pwa-install-title">Thêm vào màn hình chính</strong>
            <p id="pwa-install-desc" class="pwa-install-banner__desc">Mở nhanh như ứng dụng, không cần gõ địa chỉ mỗi lần.</p>
        </div>
        <div class="pwa-install-banner__actions">
            <button type="button" id="pwa-install-btn" class="pwa-install-banner__btn pwa-install-banner__btn--primary">Cài đặt</button>
            <button type="button" id="pwa-install-dismiss" class="pwa-install-banner__btn pwa-install-banner__btn--ghost">Để sau</button>
        </div>
    </div>
</div>
<style>
    .pwa-install-banner {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 99999;
        padding: 12px 12px calc(12px + env(safe-area-inset-bottom, 0px));
        box-sizing: border-box;
        pointer-events: none;
    }
    .pwa-install-banner__inner {
        pointer-events: auto;
        max-width: 32rem;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 16px;
        background: linear-gradient(180deg, #fffaf2 0%, #fff5e6 100%);
        border: 1px solid #d9b68e;
        box-shadow: 0 -4px 24px rgba(74, 44, 17, 0.18);
        color: #4a2c11;
        font-family: system-ui, -apple-system, 'Segoe UI', sans-serif;
        font-size: 14px;
        line-height: 1.4;
    }
    .pwa-install-banner__text { flex: 1 1 200px; min-width: 0; }
    .pwa-install-banner__desc { margin: 6px 0 0; font-weight: 500; color: #6d4621; font-size: 13px; }
    .pwa-install-banner__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }
    .pwa-install-banner__btn {
        border: 0;
        border-radius: 999px;
        padding: 10px 18px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }
    .pwa-install-banner__btn--primary {
        background: #8b5e34;
        color: #fff;
    }
    .pwa-install-banner__btn--ghost {
        background: transparent;
        color: #6d4621;
        border: 1px solid #c9a882;
    }
</style>
<script>
(function () {
    var STORAGE_KEY = 'pwa_install_banner_dismissed_v1';
    if (window.matchMedia('(display-mode: standalone)').matches) return;
    if (window.navigator.standalone === true) return;
    try {
        if (localStorage.getItem(STORAGE_KEY) === '1') return;
    } catch (e) {}

    var banner = document.getElementById('pwa-install-banner');
    var btnInstall = document.getElementById('pwa-install-btn');
    var btnDismiss = document.getElementById('pwa-install-dismiss');
    var titleEl = document.getElementById('pwa-install-title');
    var descEl = document.getElementById('pwa-install-desc');
    if (!banner || !btnInstall || !btnDismiss) return;

    var deferredPrompt = null;

    function showBanner() {
        banner.hidden = false;
    }
    function hideBanner() {
        banner.hidden = true;
    }

    function isIos() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent) ||
            (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    }

    if (isIos()) {
        titleEl.textContent = 'Thêm vào Màn hình chính';
        descEl.textContent = 'Nhấn nút Chia sẻ \u2192 chọn «Thêm vào Màn hình chính».';
        btnInstall.textContent = 'Đã hiểu';
        btnInstall.onclick = function () {
            try { localStorage.setItem(STORAGE_KEY, '1'); } catch (e) {}
            hideBanner();
        };
        showBanner();
    }

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredPrompt = e;
        if (!isIos()) {
            titleEl.textContent = 'Thêm vào màn hình chính';
            descEl.textContent = 'Cài như ứng dụng để mở nhanh hơn.';
            btnInstall.textContent = 'Cài đặt';
            btnInstall.onclick = function () {
                if (!deferredPrompt) return;
                deferredPrompt.prompt();
                deferredPrompt.userChoice.finally(function () {
                    deferredPrompt = null;
                    try { localStorage.setItem(STORAGE_KEY, '1'); } catch (e2) {}
                    hideBanner();
                });
            };
            showBanner();
        }
    });

    btnDismiss.onclick = function () {
        try { localStorage.setItem(STORAGE_KEY, '1'); } catch (e) {}
        hideBanner();
    };
})();
</script>
