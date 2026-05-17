<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/site.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Kinh Học Phật Giáo — Trang chủ' }}</title>
    <x-seo-meta :canonical="route('home')" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Noto+Serif+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <x-pwa-meta />
    @stack('head')
    @livewireStyles
</head>
<body class="bg-[#f9f3e6] text-[#4a2c11]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <x-site-header />
    {{ $slot }}
    @livewireScripts
</body>
</html>
