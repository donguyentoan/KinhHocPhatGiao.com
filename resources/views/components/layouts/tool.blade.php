@props(['title' => 'Tiện ích'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Kinh Học Phật Giáo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Noto+Serif+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <x-pwa-meta />
    @stack('head')
</head>
<body class="bg-[#f9f3e6] text-[#4a2c11] min-h-screen" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <header class="z-50 bg-[#f9f3e6] border-b border-[#e5dec9] px-6 py-3 shadow-sm">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-[#8b5e34] hover:underline">← Trang chủ</a>
                <span class="hidden sm:inline text-[#e5dec9]">|</span>
                <h1 class="font-serif text-lg font-bold text-[#4a2c11]">{{ $title }}</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
                <a href="{{ route('tools.show', 'may-niem-phat') }}" class="hover:text-[#8b5e34]">Máy niệm Phật</a>
                <a href="/#thu-vien-kinh-dien" class="hover:text-[#8b5e34]">Đọc kinh</a>
                <a href="{{ route('tools.show', 'ngoi-thien') }}" class="hover:text-[#8b5e34]">Ngồi thiền</a>
                <a href="{{ route('tools.show', 'chuong-mo') }}" class="hover:text-[#8b5e34]">Chuông mõ</a>
                <a href="{{ route('tools.show', 'lan-chuoi-hat') }}" class="hover:text-[#8b5e34]">Lần chuỗi hạt</a>
                <a href="{{ route('tools.show', 'nhac-thien') }}" class="hover:text-[#8b5e34]">Nhạc thiền</a>
                <a href="{{ route('tools.show', 'su-kien-trong-nam') }}" class="hover:text-[#8b5e34]">Sự kiện</a>
                <a href="{{ route('tools.show', 'lien-he-ho-tro') }}" class="hover:text-[#8b5e34]">Liên hệ</a>
            </nav>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 py-10">
        {{ $slot }}
    </main>

    <x-site-footer />
    <x-pwa-install-banner />
</body>
</html>
