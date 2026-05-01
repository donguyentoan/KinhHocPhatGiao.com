<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $scripture->title }} - Đọc kinh</title>
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
        @media (max-width: 720px) {
            .book-nav { justify-content: center; }
            .jump-wrap { width: 100%; justify-content: center; }
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
<body class="{{ $pdfUrl ? 'pdf-mode' : '' }}">
    <div class="container">
        <a class="back-link" href="{{ route('home') }}">← Về trang chủ</a>
        <div class="header">
            <h1>{{ $scripture->title }}</h1>
        </div>
        <div class="book-nav">
            <button id="prev_page_button" type="button">← Trang trước</button>
            <div class="jump-wrap">
                <label for="jump_to_page">Đi tới trang</label>
                <input id="jump_to_page" type="number" inputmode="numeric" min="1" step="1" value="1">
                <span class="total-pages" id="total_pages_label">/ {{ count($pages) }}</span>
                <button id="jump_to_page_button" type="button">Đi</button>
            </div>
            <button id="next_page_button" type="button">Trang sau →</button>
        </div>
        <div id="jump_message" class="jump-message"></div>
        <div class="book-wrap">
            <div id="reader_loading" class="reader-loading">
                <div class="reader-loading-card">
                    <span class="reader-loading-spinner" aria-hidden="true"></span>
                    <span id="reader_loading_text">Đang tải dữ liệu kinh...</span>
                </div>
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
    </div>

    <script>
        $(function () {
            const $book = $('#mybook');
            if (!$book.length || !$.fn.booklet) return;
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
            const $prevButton = $('#prev_page_button');
            const $nextButton = $('#next_page_button');
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

            function gotoPage(page, showClampNotice) {
                const normalized = normalizePage(page);
                if (normalized === null) {
                    $jumpMessage.text('Vui lòng nhập số trang hợp lệ.');
                    return;
                }
                setCurrentPage(normalized, showClampNotice);
                // Booklet uses zero-based internal index; convert from human page number.
                $book.booklet(normalized - 1);
                if (!isPageReady(normalized)) {
                    beginLoadingTask('goto-page', 'Đang tải trang ' + normalized + '...');
                    waitForPageReady(normalized).finally(function () {
                        endLoadingTask('goto-page');
                    });
                }
            }

            function initBooklet() {
                if (bookletInitialized) return;
                bookletInitialized = true;
                $book.show().booklet({
                    width: 900,
                    height: 607,
                    speed: 750,
                    direction: 'LTR',
                    next: $('#next_page_button'),
                    prev: $('#prev_page_button'),
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
                        return;
                    }
                    const normalized = normalizePage($jumpInput.val());
                    if (normalized === null) {
                        $jumpMessage.text('Vui lòng nhập số trang hợp lệ.');
                        setCurrentPage(currentPage, false);
                        return;
                    }
                    setCurrentPage(normalized, true);
                });

                $prevButton.click(function () {
                    setCurrentPage(currentPage - 1, false);
                });

                $nextButton.click(function () {
                    setCurrentPage(currentPage + 1, false);
                });
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

                if (fallbackHtml.length % 2 !== 0) {
                    fallbackHtml.push('<div class="book"><p></p></div>');
                }

                $book.find('.b-load').html(fallbackHtml.join(''));
                setTotalPages(Array.isArray(textPages) && textPages.length ? textPages.length : 1);
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

                function renderPdfBooklet() {
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
                initBooklet();
                endLoadingTask('initial-load');
            @endif
            bindJumpControls();
        });
    </script>
</body>
</html>