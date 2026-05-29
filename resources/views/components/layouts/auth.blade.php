<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <x-site-favicon />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tài khoản — Kinh Học Phật Giáo</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Noto+Serif+Display:wght@600&display=swap" rel="stylesheet">
    <x-pwa-meta />
    <x-mobile-site-base />
    @stack('head')
    @livewireStyles
</head>
<body class="site-mobile-safe min-h-screen flex flex-col bg-[#f9f3e6] text-[#4a2c11]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <x-site-header class="shrink-0" />
    <x-site-mobile-nav-drawer />
    <div class="flex flex-1 flex-col items-center justify-center p-6">
        <div class="w-full max-w-md rounded-[2rem] bg-white/80 backdrop-blur border border-[#8b5e34]/15 shadow-lg p-8 md:p-10">
            {{ $slot }}
        </div>
    </div>
    @stack('body-end')
    @livewireScripts
</body>
</html>
