@props(['name'])

@php
    $classes = trim('inline-block ' . ($attributes->get('class') ?? 'w-4 h-4'));
@endphp

@switch($name)
    @case('layout-dashboard')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
        @break
    @case('scroll')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 3h8a4 4 0 0 1 4 4v11a3 3 0 0 1-3 3H8a4 4 0 0 1-4-4V6a3 3 0 0 1 3-3h1z"/><path d="M8 7h8"/><path d="M8 11h8"/><path d="M8 15h5"/></svg>
        @break
    @case('layers')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 2 9 5-9 5-9-5 9-5z"/><path d="m3 12 9 5 9-5"/><path d="m3 17 9 5 9-5"/></svg>
        @break
    @case('pen-tool')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19l7-7 3 3-7 7h-3v-3z"/><path d="M18 13l-7-7"/><path d="M4 20l4-4"/><path d="M14 4l6 6"/></svg>
        @break
    @case('component')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="8" height="8"/><rect x="13" y="3" width="8" height="8"/><rect x="3" y="13" width="8" height="8"/><rect x="13" y="13" width="8" height="8"/></svg>
        @break
    @case('user')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.5-4 5-6 8-6s6.5 2 8 6"/></svg>
        @break
    @case('trending-up')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/></svg>
        @break
    @case('users')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        @break
    @case('clock')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        @break
    @case('hourglass')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2h12"/><path d="M6 22h12"/><path d="M8 2v5a4 4 0 0 0 1.17 2.83L12 12l2.83-2.17A4 4 0 0 0 16 7V2"/><path d="M16 22v-5a4 4 0 0 0-1.17-2.83L12 12l-2.83 2.17A4 4 0 0 0 8 17v5"/></svg>
        @break
    @case('eye')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
        @break
    @case('search')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>
        @break
    @case('plus')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        @break
    @case('edit-2')
    @case('edit-3')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5z"/></svg>
        @break
    @case('trash-2')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
        @break
    @case('flower-2')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="2.5"/><path d="M12 3c2.5 0 3.5 2 3.5 4S14.5 11 12 11 8.5 9 8.5 7 9.5 3 12 3z"/><path d="M21 12c0 2.5-2 3.5-4 3.5S13 14.5 13 12s2-3.5 4-3.5S21 9.5 21 12z"/><path d="M12 21c-2.5 0-3.5-2-3.5-4s1-4 3.5-4 3.5 2 3.5 4-1 4-3.5 4z"/><path d="M3 12c0-2.5 2-3.5 4-3.5S11 9.5 11 12s-2 3.5-4 3.5S3 14.5 3 12z"/></svg>
        @break
    @case('globe')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        @break
    @case('history')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
        @break
    @case('x')
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        @break
    @default
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $classes }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>
@endswitch
