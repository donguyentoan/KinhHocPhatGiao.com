<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tài khoản — Kinh Học Phật Giáo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Noto+Serif+Display:wght@600&display=swap" rel="stylesheet">
    <x-pwa-meta />
    @livewireStyles
</head>
<body class="min-h-screen bg-[#f9f3e6] text-[#4a2c11]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        <a href="{{ route('home') }}" class="mb-8 text-sm font-semibold text-[#8b5e34] hover:underline">← Về trang chủ</a>
        <div class="w-full max-w-md rounded-[2rem] bg-white/80 backdrop-blur border border-[#8b5e34]/15 shadow-lg p-8 md:p-10">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
</body>
</html>
