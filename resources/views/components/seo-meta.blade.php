@props([
    'canonical' => null,
    'description' => null,
])

@php
    $canonicalUrl = $canonical ?? request()->url();
    $descriptionText = filled($description)
        ? \Illuminate\Support\Str::limit(strip_tags((string) $description), 160, '…')
        : config('seo.default_description');
@endphp

@if (! config('seo.indexing_enabled'))
    <meta name="robots" content="noindex, nofollow">
@endif

<link rel="canonical" href="{{ $canonicalUrl }}">

@if (filled($descriptionText))
    <meta name="description" content="{{ $descriptionText }}">
@endif
