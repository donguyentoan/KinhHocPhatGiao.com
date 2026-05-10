@props([
    'profileName' => null,
    'activeSlug' => null,
])

@php
    $slug = $activeSlug ?? request()->route('slug');
    $greetingName = $profileName ?? app(\App\Support\PracticeTracker::class)->currentProfile()->dharma_name;
    $navClass = fn (?string $match) => $slug === $match
        ? 'text-[#8b5e34] font-semibold'
        : 'text-[#4a2c11] font-medium hover:text-[#8b5e34] transition-colors';
@endphp

<header {{ $attributes->merge(['class' => 'z-50 bg-[#f9f3e6] border-b border-[#e5dec9] px-4 sm:px-6 py-1 shadow-sm']) }}>
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-3 lg:gap-6">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3" aria-label="Về trang chủ">
            <img src="/logoWeb.png" alt="" class="h-[72px] w-auto max-h-[77px] object-contain sm:h-[77px]">
        </a>

        <nav class="hidden min-w-0 flex-1 justify-center lg:flex lg:flex-wrap lg:items-center lg:gap-x-5 xl:gap-x-6" aria-label="Tiện ích">
            <a href="{{ route('tools.show', 'may-niem-phat') }}" class="whitespace-nowrap text-sm {{ $navClass('may-niem-phat') }}" @if($slug === 'may-niem-phat') aria-current="page" @endif>Máy niệm Phật</a>
            <a href="{{ route('tools.show', 'doc-kinh') }}" class="whitespace-nowrap text-sm {{ $navClass('doc-kinh') }}" @if($slug === 'doc-kinh') aria-current="page" @endif>Đọc Kinh</a>
            <a href="{{ route('tools.show', 'ngoi-thien') }}" class="whitespace-nowrap text-sm {{ $navClass('ngoi-thien') }}" @if($slug === 'ngoi-thien') aria-current="page" @endif>Ngồi Thiền</a>
            <a href="{{ route('tools.show', 'chuong-mo') }}" class="whitespace-nowrap text-sm {{ $navClass('chuong-mo') }}" @if($slug === 'chuong-mo') aria-current="page" @endif>Chuông Mõ</a>
            <a href="{{ route('tools.show', 'nhac-thien') }}" class="whitespace-nowrap text-sm {{ $navClass('nhac-thien') }}" @if($slug === 'nhac-thien') aria-current="page" @endif>Nhạc Thiền</a>
            {{-- <a href="{{ route('tools.show', 'su-kien-trong-nam') }}" class="whitespace-nowrap text-sm {{ $navClass('su-kien-trong-nam') }}" @if($slug === 'su-kien-trong-nam') aria-current="page" @endif>Sự kiện</a> --}}
            <a href="{{ route('tools.show', 'lien-he-ho-tro') }}" class="whitespace-nowrap text-sm {{ $navClass('lien-he-ho-tro') }}" @if($slug === 'lien-he-ho-tro') aria-current="page" @endif>Liên hệ</a>
        </nav>

        <div class="flex shrink-0 items-center justify-end gap-2 sm:gap-3 lg:gap-4">
            <x-auth-nav class="!justify-end !gap-2 sm:!gap-3" />
            <a href="{{ route('account') }}" class="max-w-[10rem] truncate sm:max-w-none rounded-lg px-3 py-2 text-center text-sm font-bold text-[#4a2c11] hover:bg-[#efe7d5] transition-all lg:px-5" title="Tài khoản tu học">
                Xin chào, {{ $greetingName }}!
            </a>
        </div>
    </div>
</header>
