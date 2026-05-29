<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <x-site-favicon />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $scripture->title }} - Đọc kinh</title>
    <x-seo-meta
        :canonical="route('scriptures.read', $scripture)"
        :description="$scripture->summary ?: $scripture->title"
    />
    <x-pwa-meta />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="/booklet/jquery.booklet.1.1.0.css" type="text/css" rel="stylesheet" media="screen">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="/booklet/jquery.easing.1.3.js"></script>
    <script src="/booklet/jquery.booklet.1.1.0.min.js"></script>
    <style>
        body { margin: 0; background: #f2ead8; color: #4a2c11; font-family: Georgia, serif; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 16px; }
        .header { text-align: center; margin-bottom: 12px; }
        .header h1 { margin: 0; font-size: 46px; }
        .back-link { display: inline-block; margin-bottom: 12px; color: #8b5e34; text-decoration: none; font-weight: 700; font-size: 24px; }
        .book-nav { display: flex; align-items: center; justify-content: space-between; gap: 10px; max-width: 900px; margin: 0 auto 10px; flex-wrap: wrap; }
        .book-nav button { border: 0; background: #8b5e34; color: #fff; border-radius: 999px; padding: 8px 14px; cursor: pointer; font-weight: 700; }
        .nav-label--compact { display: none; }
        .jump-label__compact { display: none; }
        .jump-wrap { display: inline-flex; align-items: center; gap: 8px; color: #6d4621; font-weight: 700; }
        .jump-wrap input {
            width: 90px;
            border: 1px solid #b9956e;
            border-radius: 999px;
            padding: 6px 10px;
            font-weight: 700;
            color: #4a2c11;
            background: #fffaf2;
            text-align: center;
        }
        .jump-wrap .total-pages { min-width: 56px; text-align: left; }
        .jump-wrap button { padding: 6px 12px; }
        .jump-message { min-height: 18px; max-width: 900px; margin: 0 auto 10px; color: #8b5e34; text-align: center; font-size: 14px; }
        .book-nav--bottom {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            max-width: 900px;
            margin: 22px auto 8px;
            flex-wrap: nowrap;
        }
        /* Mobile ≤720px: một trang / lần — dùng media query để luôn khớp viewport kể cả khi JS cache sai */
        @media (max-width: 720px) {
            body.scripture-reader .container { margin: 12px auto; padding: 0 12px; }
            /* Hàng 1: hai nút Trước / Sau cạnh nhau; hàng 2: nhảy trang gọn */
            body.scripture-reader .book-nav {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto auto;
                gap: 10px 10px;
                max-width: 100%;
                margin-bottom: 12px;
                padding: 0 2px;
                padding-bottom: max(10px, env(safe-area-inset-bottom, 0px));
                align-items: stretch;
            }
            body.scripture-reader .book-nav-primary {
                grid-row: 1;
                min-height: 48px;
                padding: 12px 10px;
                font-size: 16px;
                font-weight: 700;
                border-radius: 14px;
                box-shadow: 0 3px 12px rgba(74, 44, 17, 0.18);
                letter-spacing: 0.02em;
                -webkit-tap-highlight-color: transparent;
                touch-action: manipulation;
            }
            body.scripture-reader .book-nav-primary:active {
                filter: brightness(0.95);
                box-shadow: 0 1px 6px rgba(74, 44, 17, 0.2);
            }
            body.scripture-reader #prev_page_button { grid-column: 1; }
            body.scripture-reader #next_page_button { grid-column: 2; }
            body.scripture-reader .nav-label--full { display: none; }
            body.scripture-reader .nav-label--compact { display: inline; }
            body.scripture-reader .jump-wrap {
                grid-column: 1 / -1;
                grid-row: 2;
                width: 100%;
                box-sizing: border-box;
                flex-wrap: nowrap;
                justify-content: center;
                gap: 8px;
                padding: 12px 14px;
                background: linear-gradient(180deg, #fffaf2 0%, #fff5e6 100%);
                border: 1px solid #d9b68e;
                border-radius: 14px;
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
            }
            body.scripture-reader .jump-label {
                flex-shrink: 0;
                font-size: 13px;
                color: #5c3d1e;
            }
            body.scripture-reader .jump-label__full { display: none; }
            body.scripture-reader .jump-label__compact { display: inline; }
            body.scripture-reader .jump-wrap input {
                width: 56px;
                min-width: 48px;
                padding: 8px 6px;
                font-size: 16px;
                border-radius: 10px;
            }
            body.scripture-reader .jump-wrap .total-pages {
                font-size: 14px;
                min-width: auto;
                color: #6d4621;
            }
            body.scripture-reader .jump-go-btn {
                padding: 8px 16px;
                border-radius: 10px;
                font-size: 14px;
                flex-shrink: 0;
            }
            body.scripture-reader .book-nav--bottom {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
                gap: 10px;
                max-width: 100%;
                margin-top: 14px;
                margin-bottom: max(12px, env(safe-area-inset-bottom, 0px));
                padding: 0 2px;
            }
            body.scripture-reader .book-nav--bottom .book-nav-primary {
                grid-row: 1;
                min-height: 48px;
                padding: 12px 10px;
                font-size: 16px;
                font-weight: 700;
                border-radius: 14px;
                box-shadow: 0 3px 12px rgba(74, 44, 17, 0.18);
                letter-spacing: 0.02em;
                -webkit-tap-highlight-color: transparent;
                touch-action: manipulation;
            }
            body.scripture-reader .book-nav--bottom .book-nav-primary:active {
                filter: brightness(0.95);
                box-shadow: 0 1px 6px rgba(74, 44, 17, 0.2);
            }
            body.scripture-reader #prev_page_button_bottom { grid-column: 1; }
            body.scripture-reader #next_page_button_bottom { grid-column: 2; }
            body.scripture-reader .header h1 { font-size: 1.35rem; line-height: 1.35; padding: 0 4px; }
            body.scripture-reader .back-link { font-size: 16px; margin-bottom: 8px; }
            body.scripture-reader .book-wrap {
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
            }
            body.scripture-reader #mybook {
                width: 100% !important;
                max-width: 100%;
                height: auto !important;
                margin: 0 auto;
            }
            body.scripture-reader.pdf-mode #mybook { display: none !important; }
            body.scripture-reader #mobile_single_reader { display: block !important; }
            body.scripture-reader:not(.pdf-mode) #mybook .book {
                display: none;
                width: 100%;
                max-width: 100%;
                height: auto;
                min-height: 40vh;
                padding: 18px 16px;
                box-sizing: border-box;
                border-radius: 10px;
                background: #fffaf2;
                box-shadow: 0 8px 28px rgba(74, 44, 17, 0.1);
            }
            body.scripture-reader:not(.pdf-mode) #mybook .book.mobile-slide-active {
                display: block;
            }
            body.scripture-reader:not(.pdf-mode) #mybook .book p {
                font-size: 17px;
                line-height: 1.5;
            }
        }
        #mobile_single_reader { display: none; width: 100%; position: relative; }
        .mobile-single-stack {
            width: 100%;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(74, 44, 17, 0.12);
            background: #fff;
            touch-action: pan-y pinch-zoom;
        }
        .mobile-single-slide {
            display: none;
            box-sizing: border-box;
        }
        .mobile-single-slide.is-active { display: block; }
        .mobile-single-slide img.pdf-page {
            width: 100%;
            height: auto;
            vertical-align: middle;
            object-fit: contain;
            display: block;
            background: #fff;
        }
        .book-wrap { width: 905px; margin: 0 auto; position: relative; }
        #mybook { width: 900px; height: 607px; margin: 0 auto; display: none; }
        .reader-loading {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 20;
            background: rgba(255, 250, 242, 0.92);
            border-radius: 12px;
        }
        .reader-loading.is-active {
            display: flex;
        }
        .reader-loading-card {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 999px;
            border: 1px solid #d9b68e;
            background: #fff8ee;
            color: #6d4621;
            font-weight: 700;
            box-shadow: 0 6px 18px rgba(109, 70, 33, 0.18);
        }
        .reader-loading-spinner {
            width: 20px;
            height: 20px;
            border: 3px solid #e7cfb4;
            border-top-color: #8b5e34;
            border-radius: 50%;
            animation: readerSpin 0.8s linear infinite;
        }
        @keyframes readerSpin {
            to { transform: rotate(360deg); }
        }
        #mybook .book { padding: 10px 16px 6px; height: 100%; box-sizing: border-box; }
        .pdf-mode #mybook .book { padding: 0; }
        #mybook .b-next,
        #mybook .b-prev { text-indent: -9999px; overflow: hidden; }
        #mybook .book p {
            margin: 0;
            font-size: 18px;
            line-height: 1.42;
            text-align: left;
            box-sizing: border-box;
        }
        .book-placeholder { text-align: center; color: #8b5e34; font-weight: 700; margin: 24px auto; }
        .pdf-page {
            width: 100%;
            height: 100%;
            object-fit: fill; /* Đã cập nhật thành fill để tràn viền */
            background: #fff;
            display: block;
        }
        .pdf-page.is-loading {
            background: linear-gradient(90deg, #f5eee4 0%, #ffffff 50%, #f5eee4 100%);
        }
    </style>
</head>
<body class="scripture-reader {{ $pdfUrl ? 'pdf-mode' : '' }}">
    <x-site-header class="shrink-0" active-slug="doc-kinh" />
    <x-site-mobile-nav-drawer active-slug="doc-kinh" />
    <div class="container">
        <a class="back-link" href="{{ route('tools.show', 'doc-kinh') }}">← Quay lại Đọc kinh</a>
        <div class="header">
            <h1>{{ $scripture->title }}</h1>
        </div>
        <div class="book-nav">
            <button id="prev_page_button" type="button" class="book-nav-primary">
                <span class="nav-label nav-label--full">← Trang trước</span>
                <span class="nav-label nav-label--compact">‹ Trước</span>
            </button>
            <div class="jump-wrap">
                <label for="jump_to_page" class="jump-label"><span class="jump-label__full">Đi tới trang</span><span class="jump-label__compact">Trang</span></label>
                <input id="jump_to_page" type="number" inputmode="numeric" min="1" step="1" value="1" aria-label="Số trang">
                <span class="total-pages" id="total_pages_label">/ {{ count($pages) }}</span>
                <button id="jump_to_page_button" type="button" class="jump-go-btn">Đi</button>
            </div>
            <button id="next_page_button" type="button" class="book-nav-primary">
                <span class="nav-label nav-label--full">Trang sau →</span>
                <span class="nav-label nav-label--compact">Sau ›</span>
            </button>
        </div>
        <div id="jump_message" class="jump-message"></div>
        <div class="book-wrap">
            <div id="reader_loading" class="reader-loading">
                <div class="reader-loading-card">
                    <span class="reader-loading-spinner" aria-hidden="true"></span>
                    <span id="reader_loading_text">Đang tải dữ liệu kinh...</span>
                </div>
            </div>
            <div id="mobile_single_reader" class="mobile-single-reader" hidden aria-live="polite">
                <div id="mobile_single_stack" class="mobile-single-stack"></div>
            </div>
            <div id="mybook">
                <div class="b-load">
                    @if($pdfUrl)
                        <div class="book">
                            <p class="book-placeholder">Đang tải PDF...</p>
                        </div>
                    @else
                        @foreach($pages as $page)
                            <div class="book"><p>{!! nl2br(e($page)) !!}</p></div>
                        @endforeach
                        @if(count($pages) % 2 !== 0)
                            <div class="book"><p></p></div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="book-nav book-nav--bottom" aria-label="Điều hướng cuối trang">
            <button id="prev_page_button_bottom" type="button" class="book-nav-primary">
                <span class="nav-label nav-label--full">← Trang trước</span>
                <span class="nav-label nav-label--compact">‹ Trước</span>
            </button>
            <button id="next_page_button_bottom" type="button" class="book-nav-primary">
                <span class="nav-label nav-label--full">Trang sau →</span>
                <span class="nav-label nav-label--compact">Sau ›</span>
            </button>
        </div>
    </div>

    <script>
        $(function () {
            const MOBILE_SINGLE_QUERY = '(max-width: 720px)';
            function isMobileReaderLayout() {
                return window.matchMedia(MOBILE_SINGLE_QUERY).matches;
            }
            /* Khớp lần tải đầu — khi đổi qua lại ≤720px ↔ lớn hơn phải reload để PDF/text khởi tạo đúng nhánh */
            const initialMobileLayout = isMobileReaderLayout();
            const $mobileReader = $('#mobile_single_reader');
            const $mobileStack = $('#mobile_single_stack');

            if (initialMobileLayout) {
                $mobileReader.removeAttr('hidden');
            }

            const $book = $('#mybook');
            if (!$book.length) return;
            if (!initialMobileLayout && !$.fn.booklet) return;

            let resizeReloadTimer = null;
            let viewportDebounceTimer = null;
            function readerLayoutCrossedInitial() {
                return isMobileReaderLayout() !== initialMobileLayout;
            }
            function scheduleReloadIfReaderLayoutCrossed() {
                if (!readerLayoutCrossedInitial()) return;
                clearTimeout(resizeReloadTimer);
                resizeReloadTimer = window.setTimeout(function () {
                    window.location.reload();
                }, 320);
            }
            const mqLayout = window.matchMedia(MOBILE_SINGLE_QUERY);
            function onMediaQueryChange() {
                scheduleReloadIfReaderLayoutCrossed();
            }
            if (mqLayout.addEventListener) {
                mqLayout.addEventListener('change', onMediaQueryChange);
            } else if (mqLayout.addListener) {
                mqLayout.addListener(onMediaQueryChange);
            }
            function onWindowViewportChanged() {
                clearTimeout(viewportDebounceTimer);
                viewportDebounceTimer = window.setTimeout(scheduleReloadIfReaderLayoutCrossed, 280);
            }
            /* jQuery 1.4 (read page) không có .on() — dùng .bind() */
            $(window).bind('resize orientationchange', onWindowViewportChanged);
            if (window.visualViewport) {
                window.visualViewport.addEventListener('resize', onWindowViewportChanged);
            }

            let bookletInitialized = false;
            let totalPages = 1;
            let currentPage = 1;
            let prioritizeVisiblePages = function () {};
            let isPageReady = function () { return true; };
            let waitForPageReady = function () { return Promise.resolve(); };
            const $jumpInput = $('#jump_to_page');
            const $jumpButton = $('#jump_to_page_button');
            const $totalPagesLabel = $('#total_pages_label');
            const $jumpMessage = $('#jump_message');
            const $prevButton = $('#prev_page_button, #prev_page_button_bottom');
            const $nextButton = $('#next_page_button, #next_page_button_bottom');
            const $readerLoading = $('#reader_loading');
            const $readerLoadingText = $('#reader_loading_text');
            const loadingTasks = new Set();

            function setReaderLoading(active, message) {
                if (message) {
                    $readerLoadingText.text(message);
                }
                if (active) {
                    $readerLoading.addClass('is-active');
                } else {
                    $readerLoading.removeClass('is-active');
                }
            }

            function beginLoadingTask(taskKey, message) {
                loadingTasks.add(taskKey);
                setReaderLoading(true, message);
            }

            function endLoadingTask(taskKey) {
                loadingTasks.delete(taskKey);
                if (!loadingTasks.size) {
                    setReaderLoading(false);
                }
            }

            function normalizePage(value) {
                const parsed = parseInt(value, 10);
                if (Number.isNaN(parsed)) return null;
                if (parsed < 1) return 1;
                if (parsed > totalPages) return totalPages;
                return parsed;
            }

            function setTotalPages(total) {
                const safeTotal = Math.max(1, parseInt(total, 10) || 1);
                totalPages = safeTotal;
                $jumpInput.attr('max', safeTotal);
                $totalPagesLabel.text('/ ' + safeTotal);
                if (currentPage > safeTotal) {
                    currentPage = safeTotal;
                }
                $jumpInput.val(currentPage);
            }

            function setCurrentPage(page, showClampNotice) {
                const normalized = normalizePage(page);
                if (normalized === null) return false;
                currentPage = normalized;
                $jumpInput.val(currentPage);
                if (showClampNotice && parseInt(page, 10) !== normalized) {
                    $jumpMessage.text('Đã giới hạn trong khoảng 1 đến ' + totalPages + '.');
                } else {
                    $jumpMessage.text('');
                }
                prioritizeVisiblePages(currentPage);
                return true;
            }

            function syncMobileSlide(pageNum) {
                if (!isMobileReaderLayout()) return;
                const normalized = normalizePage(pageNum);
                if (normalized === null) return;
                if ($mobileStack.children().length) {
                    $mobileStack.find('.mobile-single-slide').removeClass('is-active');
                    $mobileStack.find('.mobile-single-slide[data-page="' + normalized + '"]').addClass('is-active');
                } else {
                    $book.find('.b-load .book').removeClass('mobile-slide-active');
                    $book.find('.b-load .book').eq(normalized - 1).addClass('mobile-slide-active');
                }
            }

            function gotoPage(page, showClampNotice) {
                const normalized = normalizePage(page);
                if (normalized === null) {
                    $jumpMessage.text('Vui lòng nhập số trang hợp lệ.');
                    return;
                }
                setCurrentPage(normalized, showClampNotice);
                if (isMobileReaderLayout()) {
                    syncMobileSlide(normalized);
                } else if (bookletInitialized && $.fn.booklet) {
                    // Booklet uses zero-based internal index; convert from human page number.
                    $book.booklet(normalized - 1);
                }
                if (!isPageReady(normalized)) {
                    beginLoadingTask('goto-page', 'Đang tải trang ' + normalized + '...');
                    waitForPageReady(normalized).finally(function () {
                        endLoadingTask('goto-page');
                    });
                }
            }

            function initBooklet() {
                if (bookletInitialized || initialMobileLayout) return;
                bookletInitialized = true;
                /* Không truyền next/prev vào booklet — các nút do gotoPage() điều khiển để đồng bộ số trang và tránh double-flip */
                $book.show().booklet({
                    width: 900,
                    height: 607,
                    speed: 750,
                    direction: 'LTR',
                    easing: 'easeInOutQuad',
                    overlays: true,
                    tabs: false,
                    pageNumbers: true,
                    pagePadding: 0 /* Đã thêm pagePadding: 0 để xóa viền xám mặc định */
                });
                setCurrentPage(1, false);
            }

            function bindJumpControls() {
                $jumpButton.click(function () {
                    gotoPage($jumpInput.val(), true);
                });

                $jumpInput.keydown(function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        gotoPage($jumpInput.val(), true);
                    }
                });

                $jumpInput.blur(function () {
                    if ($jumpInput.val() === '') {
                        setCurrentPage(currentPage, false);
                        if (isMobileReaderLayout()) {
                            syncMobileSlide(currentPage);
                        }
                        return;
                    }
                    const normalized = normalizePage($jumpInput.val());
                    if (normalized === null) {
                        $jumpMessage.text('Vui lòng nhập số trang hợp lệ.');
                        setCurrentPage(currentPage, false);
                        return;
                    }
                    gotoPage($jumpInput.val(), true);
                });

                $prevButton.click(function () {
                    gotoPage(currentPage - 1, false);
                });

                $nextButton.click(function () {
                    gotoPage(currentPage + 1, false);
                });
            }

            function initMobileTextReader() {
                bookletInitialized = true;
                $book.show();
                syncMobileSlide(1);
            }

            function bindMobileSwipe() {
                if (!initialMobileLayout) return;
                const el = document.querySelector('.book-wrap');
                if (!el) return;
                let startX = 0;
                let startY = 0;
                el.addEventListener('touchstart', function (e) {
                    if (!e.touches.length) return;
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                }, { passive: true });
                el.addEventListener('touchend', function (e) {
                    if (!e.changedTouches.length) return;
                    const dx = e.changedTouches[0].clientX - startX;
                    const dy = e.changedTouches[0].clientY - startY;
                    if (Math.abs(dx) < 56 || Math.abs(dx) < Math.abs(dy)) return;
                    if (dx < 0) {
                        gotoPage(currentPage + 1, false);
                    } else {
                        gotoPage(currentPage - 1, false);
                    }
                }, { passive: true });
            }

            function renderTextFallback() {
                beginLoadingTask('initial-load', 'Đang tải dữ liệu kinh...');
                const textPages = @json($pages);
                const fallbackHtml = [];

                if (Array.isArray(textPages) && textPages.length) {
                    textPages.forEach(function (page) {
                        const safe = String(page)
                            .replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(/\n/g, '<br>');
                        fallbackHtml.push('<div class="book"><p>' + safe + '</p></div>');
                    });
                } else {
                    fallbackHtml.push('<div class="book"><p class="book-placeholder">Không có nội dung để hiển thị.</p></div>');
                }

                if (!initialMobileLayout && fallbackHtml.length % 2 !== 0) {
                    fallbackHtml.push('<div class="book"><p></p></div>');
                }

                $book.find('.b-load').html(fallbackHtml.join(''));
                setTotalPages(Array.isArray(textPages) && textPages.length ? textPages.length : 1);
                if (initialMobileLayout) {
                    initMobileTextReader();
                    endLoadingTask('initial-load');
                    return;
                }
                initBooklet();
                endLoadingTask('initial-load');
            }

            @if($pdfUrl)
                const $load = $book.find('.b-load');
                const pdfUrl = @json($pdfUrl);
                
                // Đã cập nhật kích thước đúng bằng 1 trang của quyển sách (Rộng 450, Cao 607)
                const targetWidth = 450; 
                const targetHeight = 607;
                const zoomFactor = 1.0;
                
                const pdfLibSources = [
                    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js',
                    'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js',
                    'https://unpkg.com/pdfjs-dist@2.16.105/build/pdf.min.js'
                ];
                const pdfWorkerSources = [
                    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js',
                    'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.worker.min.js',
                    'https://unpkg.com/pdfjs-dist@2.16.105/build/pdf.worker.min.js'
                ];

                function loadScript(url) {
                    return new Promise(function (resolve, reject) {
                        const script = document.createElement('script');
                        script.src = url;
                        script.async = true;
                        script.onload = function () { resolve(url); };
                        script.onerror = function () { reject(new Error('Failed: ' + url)); };
                        document.head.appendChild(script);
                    });
                }

                function loadFirstAvailable(urls, index) {
                    const i = index || 0;
                    if (i >= urls.length) {
                        return Promise.reject(new Error('All script sources failed'));
                    }
                    return loadScript(urls[i]).catch(function () {
                        return loadFirstAvailable(urls, i + 1);
                    });
                }

                function renderPdfMobileSingle() {
                    if (typeof pdfjsLib === 'undefined') {
                        return Promise.reject(new Error('pdfjsLib not found'));
                    }
                    beginLoadingTask('initial-load', 'Đang tải PDF...');

                    const libSrc = (document.querySelector('script[src*="pdf.min.js"]') || {}).src || '';
                    const workerSrc = libSrc.includes('jsdelivr')
                        ? pdfWorkerSources[1]
                        : (libSrc.includes('unpkg') ? pdfWorkerSources[2] : pdfWorkerSources[0]);
                    pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;

                    function mobilePdfMaxSize() {
                        const maxW = Math.max(240, Math.floor(window.innerWidth - 24));
                        const maxH = Math.floor(window.innerHeight * 0.72);
                        return { maxW: maxW, maxH: maxH };
                    }

                    return pdfjsLib.getDocument(pdfUrl).promise.then(async function (pdfDoc) {
                        const originalPageCount = pdfDoc.numPages;
                        const eagerPageCount = Math.min(8, originalPageCount);
                        const tinyPlaceholder = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
                        const pagesHtml = [];
                        const renderedPages = {};
                        const pageWaiters = {};
                        const queuedPages = {};
                        const pendingPages = [];
                        let pumpScheduled = false;
                        let renderInProgress = false;

                        for (let i = 1; i <= originalPageCount; i++) {
                            pagesHtml.push(
                                '<div class="mobile-single-slide' + (i === 1 ? ' is-active' : '') + '" data-page="' + i + '">' +
                                '<img class="pdf-page is-loading" data-page="' + i + '" src="' + tinyPlaceholder + '" alt="Trang ' + i + '">' +
                                '</div>'
                            );
                        }

                        $mobileStack.html(pagesHtml.join(''));
                        setTotalPages(originalPageCount);

                        async function renderPageToImage(pageNumber) {
                            if (renderedPages[pageNumber]) return;

                            const page = await pdfDoc.getPage(pageNumber);
                            const viewport = page.getViewport({ scale: 1 });
                            const limits = mobilePdfMaxSize();
                            const fitScale = Math.min(
                                limits.maxW / viewport.width,
                                limits.maxH / viewport.height
                            );
                            const scaledViewport = page.getViewport({ scale: fitScale });

                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            const cw = Math.max(1, Math.floor(scaledViewport.width));
                            const ch = Math.max(1, Math.floor(scaledViewport.height));
                            canvas.width = cw;
                            canvas.height = ch;
                            ctx.fillStyle = '#ffffff';
                            ctx.fillRect(0, 0, cw, ch);

                            const offsetX = Math.floor((cw - scaledViewport.width) / 2);
                            const offsetY = Math.floor((ch - scaledViewport.height) / 2);

                            await page.render({
                                canvasContext: ctx,
                                viewport: scaledViewport,
                                transform: [1, 0, 0, 1, offsetX, offsetY]
                            }).promise;

                            const pageImage = canvas.toDataURL('image/jpeg', 0.92);
                            const $img = $mobileStack.find('img[data-page="' + pageNumber + '"]');
                            if ($img.length) {
                                $img.attr('src', pageImage).removeClass('is-loading');
                            }
                            renderedPages[pageNumber] = true;
                            const waiters = pageWaiters[pageNumber] || [];
                            waiters.forEach(function (resolve) { resolve(); });
                            pageWaiters[pageNumber] = [];
                        }

                        function settlePageWaitersAsDone(pageNumber) {
                            const waiters = pageWaiters[pageNumber] || [];
                            waiters.forEach(function (resolve) { resolve(); });
                            pageWaiters[pageNumber] = [];
                        }

                        function enqueuePage(pageNumber, highPriority) {
                            if (pageNumber < 1 || pageNumber > originalPageCount) return;
                            if (renderedPages[pageNumber] || queuedPages[pageNumber]) return;
                            queuedPages[pageNumber] = true;
                            if (highPriority) {
                                pendingPages.unshift(pageNumber);
                            } else {
                                pendingPages.push(pageNumber);
                            }
                        }

                        async function pumpRenderQueue() {
                            if (renderInProgress) return;
                            const nextPage = pendingPages.shift();
                            if (!nextPage) return;
                            delete queuedPages[nextPage];
                            renderInProgress = true;
                            try {
                                await renderPageToImage(nextPage);
                            } catch (error) {
                                settlePageWaitersAsDone(nextPage);
                            } finally {
                                renderInProgress = false;
                                schedulePump();
                            }
                        }

                        function schedulePump() {
                            if (pumpScheduled) return;
                            if (!pendingPages.length) return;
                            pumpScheduled = true;
                            const kick = function () {
                                pumpScheduled = false;
                                pumpRenderQueue();
                            };
                            if (typeof window.requestIdleCallback === 'function') {
                                window.requestIdleCallback(function () {
                                    kick();
                                }, { timeout: 1200 });
                            } else {
                                window.setTimeout(kick, 0);
                            }
                        }

                        function boostAroundPage(centerPage) {
                            const safeCenter = normalizePage(centerPage);
                            if (safeCenter === null) return;
                            const windowRadius = 4;
                            const nearby = [];
                            for (let offset = 0; offset <= windowRadius; offset++) {
                                const right = safeCenter + offset;
                                const left = safeCenter - offset;
                                if (offset === 0) {
                                    nearby.push(safeCenter);
                                } else {
                                    nearby.push(right, left);
                                }
                            }
                            for (let i = 0; i < nearby.length; i++) {
                                enqueuePage(nearby[i], true);
                            }
                            schedulePump();
                        }

                        isPageReady = function (pageNumber) {
                            return !!renderedPages[pageNumber];
                        };

                        waitForPageReady = function (pageNumber) {
                            if (renderedPages[pageNumber]) {
                                return Promise.resolve();
                            }
                            return new Promise(function (resolve) {
                                if (!pageWaiters[pageNumber]) {
                                    pageWaiters[pageNumber] = [];
                                }
                                pageWaiters[pageNumber].push(resolve);
                                enqueuePage(pageNumber, true);
                                schedulePump();
                            });
                        };

                        bookletInitialized = true;

                        for (let i = 1; i <= eagerPageCount; i++) {
                            await renderPageToImage(i);
                        }

                        syncMobileSlide(1);
                        endLoadingTask('initial-load');
                        prioritizeVisiblePages = boostAroundPage;
                        prioritizeVisiblePages(1);

                        for (let i = eagerPageCount + 1; i <= originalPageCount; i++) {
                            enqueuePage(i, false);
                        }
                        schedulePump();
                    });
                }

                function renderPdfBooklet() {
                    if (initialMobileLayout) {
                        return renderPdfMobileSingle();
                    }
                    if (typeof pdfjsLib === 'undefined') {
                        return Promise.reject(new Error('pdfjsLib not found'));
                    }
                    beginLoadingTask('initial-load', 'Đang tải PDF...');

                    // Use the same CDN family for worker when possible.
                    const libSrc = (document.querySelector('script[src*="pdf.min.js"]') || {}).src || '';
                    const workerSrc = libSrc.includes('jsdelivr')
                        ? pdfWorkerSources[1]
                        : (libSrc.includes('unpkg') ? pdfWorkerSources[2] : pdfWorkerSources[0]);
                    pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;

                    return pdfjsLib.getDocument(pdfUrl).promise.then(async function (pdfDoc) {
                        const originalPageCount = pdfDoc.numPages;
                        const eagerPageCount = Math.min(10, originalPageCount);
                        const tinyPlaceholder = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
                        const pagesHtml = [];
                        const renderedPages = {};
                        const pageWaiters = {};
                        const queuedPages = {};
                        const pendingPages = [];
                        let pumpScheduled = false;
                        let renderInProgress = false;

                        for (let i = 1; i <= originalPageCount; i++) {
                            pagesHtml.push(
                                '<div class="book"><img class="pdf-page is-loading" data-page="' + i + '" src="' + tinyPlaceholder + '" alt="Trang ' + i + '"></div>'
                            );
                        }

                        if (pagesHtml.length % 2 !== 0) {
                            pagesHtml.push('<div class="book"><p></p></div>');
                        }

                        $load.html(pagesHtml.join(''));
                        setTotalPages(originalPageCount);

                        async function renderPageToImage(pageNumber) {
                            if (renderedPages[pageNumber]) return;

                            const page = await pdfDoc.getPage(pageNumber);
                            const viewport = page.getViewport({ scale: 1 });
                            const fitScale = Math.min(targetWidth / viewport.width, targetHeight / viewport.height);
                            const renderScale = fitScale * zoomFactor;
                            const scaledViewport = page.getViewport({ scale: renderScale });

                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            canvas.width = targetWidth;
                            canvas.height = targetHeight;
                            ctx.fillStyle = '#ffffff';
                            ctx.fillRect(0, 0, targetWidth, targetHeight);

                            const offsetX = Math.floor((targetWidth - scaledViewport.width) / 2);
                            const offsetY = Math.floor((targetHeight - scaledViewport.height) / 2);

                            await page.render({
                                canvasContext: ctx,
                                viewport: scaledViewport,
                                transform: [1, 0, 0, 1, offsetX, offsetY]
                            }).promise;

                            const pageImage = canvas.toDataURL('image/jpeg', 0.92);
                            const $img = $load.find('img[data-page="' + pageNumber + '"]');
                            if ($img.length) {
                                $img.attr('src', pageImage).removeClass('is-loading');
                            }
                            renderedPages[pageNumber] = true;
                            const waiters = pageWaiters[pageNumber] || [];
                            waiters.forEach(function (resolve) { resolve(); });
                            pageWaiters[pageNumber] = [];
                        }
                        function settlePageWaitersAsDone(pageNumber) {
                            const waiters = pageWaiters[pageNumber] || [];
                            waiters.forEach(function (resolve) { resolve(); });
                            pageWaiters[pageNumber] = [];
                        }


                        function enqueuePage(pageNumber, highPriority) {
                            if (pageNumber < 1 || pageNumber > originalPageCount) return;
                            if (renderedPages[pageNumber] || queuedPages[pageNumber]) return;
                            queuedPages[pageNumber] = true;
                            if (highPriority) {
                                pendingPages.unshift(pageNumber);
                            } else {
                                pendingPages.push(pageNumber);
                            }
                        }

                        async function pumpRenderQueue() {
                            if (renderInProgress) return;
                            const nextPage = pendingPages.shift();
                            if (!nextPage) return;
                            delete queuedPages[nextPage];
                            renderInProgress = true;
                            try {
                                await renderPageToImage(nextPage);
                            } catch (error) {
                                // Keep placeholder if a page fails to render.
                                settlePageWaitersAsDone(nextPage);
                            } finally {
                                renderInProgress = false;
                                schedulePump();
                            }
                        }

                        function schedulePump() {
                            if (pumpScheduled) return;
                            if (!pendingPages.length) return;
                            pumpScheduled = true;
                            const kick = function () {
                                pumpScheduled = false;
                                pumpRenderQueue();
                            };
                            if (typeof window.requestIdleCallback === 'function') {
                                window.requestIdleCallback(function () {
                                    kick();
                                }, { timeout: 1200 });
                            } else {
                                window.setTimeout(kick, 0);
                            }
                        }

                        function boostAroundPage(centerPage) {
                            const safeCenter = normalizePage(centerPage);
                            if (safeCenter === null) return;
                            const windowRadius = 4;
                            const nearby = [];
                            for (let offset = 0; offset <= windowRadius; offset++) {
                                const right = safeCenter + offset;
                                const left = safeCenter - offset;
                                if (offset === 0) {
                                    nearby.push(safeCenter);
                                } else {
                                    nearby.push(right, left);
                                }
                            }
                            for (let i = 0; i < nearby.length; i++) {
                                enqueuePage(nearby[i], true);
                            }
                            schedulePump();
                        }

                        isPageReady = function (pageNumber) {
                            return !!renderedPages[pageNumber];
                        };

                        waitForPageReady = function (pageNumber) {
                            if (renderedPages[pageNumber]) {
                                return Promise.resolve();
                            }
                            return new Promise(function (resolve) {
                                if (!pageWaiters[pageNumber]) {
                                    pageWaiters[pageNumber] = [];
                                }
                                pageWaiters[pageNumber].push(resolve);
                                enqueuePage(pageNumber, true);
                                schedulePump();
                            });
                        };

                        for (let i = 1; i <= eagerPageCount; i++) {
                            await renderPageToImage(i);
                        }

                        initBooklet();
                        endLoadingTask('initial-load');
                        prioritizeVisiblePages = boostAroundPage;
                        prioritizeVisiblePages(1);

                        for (let i = eagerPageCount + 1; i <= originalPageCount; i++) {
                            enqueuePage(i, false);
                        }
                        schedulePump();
                    });
                }

                // Priority: keep original PDF page format; fallback to text only if all PDF sources fail.
                loadFirstAvailable(pdfLibSources)
                    .then(renderPdfBooklet)
                    .catch(function () {
                        setTotalPages(@json(count($pages)));
                        renderTextFallback();
                    });
            @else
                beginLoadingTask('initial-load', 'Đang tải dữ liệu kinh...');
                setTotalPages(@json(count($pages)));
                if (initialMobileLayout) {
                    initMobileTextReader();
                } else {
                    initBooklet();
                }
                endLoadingTask('initial-load');
            @endif
            bindJumpControls();
            bindMobileSwipe();
        });
    </script>
</body>
</html>