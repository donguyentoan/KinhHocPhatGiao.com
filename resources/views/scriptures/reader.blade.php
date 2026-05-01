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
        .book-nav { display: flex; justify-content: space-between; max-width: 900px; margin: 0 auto 10px; }
        .book-nav button { border: 0; background: #8b5e34; color: #fff; border-radius: 999px; padding: 8px 14px; cursor: pointer; font-weight: 700; }
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
            <button id="next_page_button" type="button">Trang sau →</button>
        </div>
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

                        if (pagesHtml.length % 2 !== 0) {
                            pagesHtml.push('<div class="book"><p></p></div>');
                        }

                        $load.html(pagesHtml.join(''));
                        initBooklet();
                    });
                }

                // Priority: keep original PDF page format; fallback to text only if all PDF sources fail.
                loadFirstAvailable(pdfLibSources)
                    .then(renderPdfBooklet)
                    .catch(function () {
                        renderTextFallback();
                    });
            @else
                initBooklet();
            @endif
        });
    </script>
</body>
</html>