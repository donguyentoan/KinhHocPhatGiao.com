<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <x-site-favicon />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kinh Hoc Phat Giao - Dashboard</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.4); }
        .sidebar-link.active { background-color: #8b5e34; color: white; box-shadow: 0 4px 12px rgba(139, 94, 52, 0.2); }
    </style>
    <x-pwa-meta />
    @livewireStyles
</head>
<body class="site-mobile-safe flex flex-col h-screen overflow-hidden text-[#4a2c11] bg-[#f8f5f2]" style="font-family: 'Quicksand', sans-serif; background-color: #f8f5f2; background-image: url('https://www.transparenttextures.com/patterns/p6.png');">
    
    <div class="flex-1 min-h-0 overflow-hidden">
        {{ $slot }}
    </div>
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var openBtn = document.getElementById('dash-menu-open');
            var sidebar = document.getElementById('dash-sidebar');
            var backdrop = document.getElementById('dash-sidebar-backdrop');
            if (!sidebar || !backdrop) return;

            function isDashMobile() {
                return window.matchMedia('(max-width: 1023px)').matches;
            }

            function setDashOpen(open) {
                if (!isDashMobile()) return;
                if (openBtn) openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (open) {
                    sidebar.removeAttribute('inert');
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    document.body.classList.add('overflow-hidden');
                } else {
                    sidebar.setAttribute('inert', '');
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            if (isDashMobile()) {
                sidebar.setAttribute('inert', '');
            }

            openBtn && openBtn.addEventListener('click', function () { setDashOpen(true); });
            backdrop.addEventListener('click', function () { setDashOpen(false); });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setDashOpen(false);
            });
            sidebar.querySelectorAll('button[wire\\:click]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    if (window.matchMedia('(max-width: 1023px)').matches) setDashOpen(false);
                });
            });
            document.addEventListener('livewire:navigated', function () {
                if (window.matchMedia('(max-width: 1023px)').matches) setDashOpen(false);
            });
        });
    </script>
</body>
</html>
