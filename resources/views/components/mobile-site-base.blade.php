{{-- Chuẩn mobile toàn site: chống tràn ngang, chữ/section responsive --}}
@once
    @push('head')
        <style>
            html { overflow-x: clip; }
            body.site-mobile-safe { overflow-x: clip; max-width: 100vw; }
            .site-section-title {
                font-family: 'Noto Serif Display', Georgia, serif;
                font-size: clamp(1.35rem, 4.5vw, 1.875rem);
                line-height: 1.25;
            }
        </style>
    @endpush
@endonce
