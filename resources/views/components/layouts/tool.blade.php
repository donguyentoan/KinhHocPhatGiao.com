@props(['title' => 'Tiện ích', 'showPageHeading' => true])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Kinh Học Phật Giáo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Noto+Serif+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <x-pwa-meta />
    @stack('head')
</head>
<body class="bg-[#f9f3e6] text-[#4a2c11] min-h-screen antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <x-site-header />

    <main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
        <div class="mb-6 lg:mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#8b5e34] hover:text-[#6f4a2b] hover:underline">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
                Quay lại trang chủ
            </a>
        </div>
        @if($showPageHeading)
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-[#1a1512] mb-8 lg:mb-10">{{ $title }}</h1>
        @endif
        {{ $slot }}
    </main>

    <x-site-footer />
    <x-pwa-install-banner />
</body>
</html>
