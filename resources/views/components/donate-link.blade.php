@props([
    'variant' => 'button',
])

@php
    $raw = config('site.momo_donate_url');
    $url = filled($raw) ? $raw : route('tools.show', 'lien-he-ho-tro');
    $isExternal = filled($raw) && str_starts_with($raw, 'http');
    $title = 'Ủng hộ qua Momo — góp phần duy trì website và các việc lành';
@endphp

@if ($variant === 'button')
    <a
        href="{{ $url }}"
        title="{{ $title }}"
        @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif
        {{ $attributes->merge([
            'class' => 'inline-flex items-center gap-1.5 rounded-full bg-[#8b5e34] px-3.5 py-1.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6f4a2b] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/50',
        ]) }}
    >
        <i class="fa-solid fa-hand-holding-heart text-sm opacity-95 sm:text-xs" aria-hidden="true"></i>
        <span class="hidden sm:inline">Ủng hộ</span>
        <span class="sr-only sm:hidden">Ủng hộ</span>
    </a>
@else
    <a
        href="{{ $url }}"
        title="{{ $title }}"
        @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif
        {{ $attributes->merge(['class' => 'hover:text-[#8b5e34] hover:underline']) }}
    >
        Ủng hộ qua Momo
    </a>
@endif
