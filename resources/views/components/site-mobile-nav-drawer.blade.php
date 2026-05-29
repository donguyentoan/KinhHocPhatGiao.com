@props([
    'activeSlug' => null,
])

@php
    $slug = $activeSlug ?? request()->route('slug');
    if (request()->routeIs('scriptures.*')) {
        $slug = 'doc-kinh';
    }
    $navClass = fn (?string $match) => $slug === $match
        ? 'bg-[#8b5e34]/12 text-[#8b5e34] font-semibold'
        : 'text-[#4a2c11] hover:bg-[#faf6f0]';
    $tools = [
        ['slug' => 'may-niem-phat', 'label' => 'Máy niệm Phật', 'icon' => 'fa-volume-high'],
        ['slug' => 'doc-kinh', 'label' => 'Đọc kinh', 'icon' => 'fa-book-open'],
        ['slug' => 'hai-loc-phap-cu', 'label' => 'Pháp Cú', 'icon' => 'fa-tree'],
        ['slug' => 'truc-nghiem-phat-giao', 'label' => 'Trắc nghiệm', 'icon' => 'fa-circle-question'],
        ['slug' => 'ngoi-thien', 'label' => 'Ngồi thiền', 'icon' => 'fa-spa'],
        ['slug' => 'nhac-thien', 'label' => 'Nhạc thiền', 'icon' => 'fa-music'],
        ['slug' => 'lien-he-ho-tro', 'label' => 'Liên hệ hỗ trợ', 'icon' => 'fa-headset'],
    ];
@endphp

<div
    id="site-mobile-nav-backdrop"
    class="fixed inset-0 z-[200] bg-black/50 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"
    aria-hidden="true"
></div>

<nav
    id="site-mobile-nav-panel"
    class="fixed top-0 right-0 z-[210] flex h-full w-[min(20rem,92vw)] max-w-full flex-col border-l border-[#e5dec9] bg-[#fffcf7] shadow-2xl translate-x-full transition-transform duration-300 ease-out lg:hidden"
    aria-label="Menu di động"
    aria-hidden="true"
    inert
>
    <div class="flex items-center justify-between gap-3 border-b border-[#efe8dc] px-4 py-3.5 shrink-0">
        <span class="font-serif text-lg font-bold text-[#4a2c11]">Menu</span>
        <button
            type="button"
            id="site-mobile-nav-close"
            class="flex h-10 w-10 items-center justify-center rounded-xl text-[#6b5346] hover:bg-[#f5f0e8] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40"
            aria-label="Đóng menu"
        >
            <i class="fa-solid fa-xmark text-xl" aria-hidden="true"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto overscroll-contain px-3 py-4 space-y-6">
        <div>
            <p class="px-2 mb-2 text-[10px] font-bold uppercase tracking-wider text-[#9a8b7d]">Trang chủ</p>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('home') ? 'bg-[#8b5e34]/12 text-[#8b5e34] font-semibold' : 'text-[#4a2c11] hover:bg-[#faf6f0]' }}">
                        <i class="fa-solid fa-house w-5 text-center text-[#8b5e34]" aria-hidden="true"></i>
                        Trang chủ
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}#thu-vien-kinh-dien" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-[#4a2c11] hover:bg-[#faf6f0]">
                        <i class="fa-solid fa-book-bookmark w-5 text-center text-[#8b5e34]" aria-hidden="true"></i>
                        Thư viện kinh điển
                    </a>
                </li>
                <li>
                    <a href="{{ route('recipes.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm {{ request()->routeIs('recipes.*') ? 'bg-[#8b5e34]/12 text-[#8b5e34] font-semibold' : 'text-[#4a2c11] hover:bg-[#faf6f0]' }}">
                        <i class="fa-solid fa-leaf w-5 text-center text-[#5a7a5a]" aria-hidden="true"></i>
                        Món chay
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <p class="px-2 mb-2 text-[10px] font-bold uppercase tracking-wider text-[#9a8b7d]">Tiện ích</p>
            <ul class="space-y-0.5">
                @foreach ($tools as $tool)
                    <li>
                        <a
                            href="{{ route('tools.show', $tool['slug']) }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm {{ $navClass($tool['slug']) }}"
                            @if($slug === $tool['slug']) aria-current="page" @endif
                        >
                            <i class="fa-solid {{ $tool['icon'] }} w-5 text-center opacity-80" aria-hidden="true"></i>
                            {{ $tool['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="px-2 pt-2 border-t border-[#efe8dc]">
            <x-donate-link variant="button" class="w-full justify-center" />
        </div>
    </div>
</nav>

<script>
    (function () {
        function initSiteMobileNav() {
            var openBtn = document.getElementById('site-mobile-nav-open');
            var closeBtn = document.getElementById('site-mobile-nav-close');
            var panel = document.getElementById('site-mobile-nav-panel');
            var backdrop = document.getElementById('site-mobile-nav-backdrop');
            if (!openBtn || !panel || !backdrop || openBtn.dataset.bound === '1') return;
            openBtn.dataset.bound = '1';

            function setOpen(open) {
                openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
                panel.setAttribute('aria-hidden', open ? 'false' : 'true');
                if (open) {
                    panel.removeAttribute('inert');
                    panel.classList.remove('translate-x-full');
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    document.body.classList.add('overflow-hidden');
                } else {
                    panel.setAttribute('inert', '');
                    panel.classList.add('translate-x-full');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            openBtn.addEventListener('click', function () { setOpen(true); });
            if (closeBtn) closeBtn.addEventListener('click', function () { setOpen(false); });
            backdrop.addEventListener('click', function () { setOpen(false); });
            panel.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', function () { setOpen(false); });
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setOpen(false);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSiteMobileNav);
        } else {
            initSiteMobileNav();
        }
        document.addEventListener('livewire:navigated', initSiteMobileNav);
    })();
</script>
