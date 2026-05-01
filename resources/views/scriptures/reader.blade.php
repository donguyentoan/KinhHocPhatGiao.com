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
            const $jumpInput = $('#jump_to_page');
            const $jumpButton = $('#jump_to_page_button');
            const $totalPagesLabel = $('#total_pages_label');
            const $jumpMessage = $('#jump_message');
            const $prevButton = $('#prev_page_button');
            const $nextButton = $('#next_page_button');

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

                    // Use the same CDN family for worker when possible.
                    const libSrc = (document.querySelector('script[src*="pdf.min.js"]') || {}).src || '';
                    const workerSrc = libSrc.includes('jsdelivr')
                        ? pdfWorkerSources[1]
                        : (libSrc.includes('unpkg') ? pdfWorkerSources[2] : pdfWorkerSources[0]);
                    pdfjsLib.GlobalWorkerOptions.workerSrc = workerSrc;

                    return pdfjsLib.getDocument(pdfUrl).promise.then(async function (pdfDoc) {
                        const pagesHtml = [];

                        for (let i = 1; i <= pdfDoc.numPages; i++) {
                            const page = await pdfDoc.getPage(i);
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
                            pagesHtml.push('<div class="book"><img class="pdf-page" src="' + pageImage + '" alt="Trang ' + i + '"></div>');
                        }

                        const originalPageCount = pagesHtml.length;
                        if (pagesHtml.length % 2 !== 0) {
                            pagesHtml.push('<div class="book"><p></p></div>');
                        }

                        $load.html(pagesHtml.join(''));
                        setTotalPages(originalPageCount);
                        initBooklet();
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
                setTotalPages(@json(count($pages)));
                initBooklet();
            @endif
            bindJumpControls();
        });
    </script>
</body>
</html>