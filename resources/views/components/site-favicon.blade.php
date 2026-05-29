{{-- Favicon: crop huy hieu tron tu logoWeb.png (bo chu THIEN HOANG BAO ben phai) --}}
@php($faviconVer = '10')
<link rel="icon" href="{{ asset('favicon-32x32.png') }}?v={{ $faviconVer }}" type="image/png" sizes="32x32">
<link rel="icon" href="{{ asset('favicon-16x16.png') }}?v={{ $faviconVer }}" type="image/png" sizes="16x16">
<link rel="icon" href="{{ asset('favicon.svg') }}?v={{ $faviconVer }}" type="image/svg+xml">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ $faviconVer }}">
