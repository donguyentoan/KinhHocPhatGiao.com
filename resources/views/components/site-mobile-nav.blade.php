@props([
    'activeSlug' => null,
])

{{-- Nút ☰ — chỉ hiện dưới lg (1024px) --}}
<div class="lg:hidden shrink-0 order-last">
    <button
        type="button"
        id="site-mobile-nav-open"
        class="flex h-11 w-11 items-center justify-center rounded-xl border-2 border-[#c9a77c]/50 bg-white text-[#4a2c11] shadow-md hover:bg-[#faf6f0] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40"
        aria-controls="site-mobile-nav-panel"
        aria-expanded="false"
        aria-label="Mở menu điều hướng"
    >
        <i class="fa-solid fa-bars text-lg" aria-hidden="true"></i>
    </button>
</div>
