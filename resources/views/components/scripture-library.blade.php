@props(['categories'])

@php
    $categoryThemes = [
        'Hệ Thống Kinh' => [
            'accent' => '#8b5e34',
            'accentSoft' => 'bg-[#8b5e34]/10 text-[#8b5e34]',
            'iconGradient' => 'from-[#faf6f0] to-[#ebe0cf]',
            'icon' => 'fa-solid fa-book-open',
            'label' => 'bài',
        ],
        'Kinh Địa Tạng' => [
            'accent' => '#9b4d4d',
            'accentSoft' => 'bg-red-50 text-red-800',
            'iconGradient' => 'from-red-50 to-[#f5ebe8]',
            'icon' => 'fa-solid fa-gopuram',
            'label' => 'bài',
        ],
        'Mật Chú' => [
            'accent' => '#6b4c8a',
            'accentSoft' => 'bg-purple-50 text-purple-800',
            'iconGradient' => 'from-purple-50 to-[#f3edf8]',
            'icon' => 'fa-solid fa-scroll',
            'label' => 'chú',
        ],
        'Tụng Hằng Ngày' => [
            'accent' => '#3d6b8c',
            'accentSoft' => 'bg-sky-50 text-sky-900',
            'iconGradient' => 'from-sky-50 to-[#e8f2f8]',
            'icon' => 'fa-solid fa-sun',
            'label' => 'bài',
        ],
        'Văn Sám Hối' => [
            'accent' => '#3d6b52',
            'accentSoft' => 'bg-emerald-50 text-emerald-900',
            'iconGradient' => 'from-emerald-50 to-[#e8f5ef]',
            'icon' => 'fa-solid fa-hands-praying',
            'label' => 'bài',
        ],
        'Sách Phật Giáo' => [
            'accent' => '#a67c35',
            'accentSoft' => 'bg-amber-50 text-amber-900',
            'iconGradient' => 'from-amber-50 to-[#f8f0e4]',
            'icon' => 'fa-solid fa-book',
            'label' => 'bài',
        ],
    ];
    $fallbackThemes = [
        ['accent' => '#8b5e34', 'accentSoft' => 'bg-[#8b5e34]/10 text-[#8b5e34]', 'iconGradient' => 'from-[#faf6f0] to-[#ebe0cf]', 'icon' => 'fa-solid fa-book-open', 'label' => 'bài'],
        ['accent' => '#3d6b8c', 'accentSoft' => 'bg-sky-50 text-sky-900', 'iconGradient' => 'from-sky-50 to-[#e8f2f8]', 'icon' => 'fa-solid fa-book-bookmark', 'label' => 'bài'],
        ['accent' => '#3d6b52', 'accentSoft' => 'bg-emerald-50 text-emerald-900', 'iconGradient' => 'from-emerald-50 to-[#e8f5ef]', 'icon' => 'fa-solid fa-leaf', 'label' => 'bài'],
    ];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6 gap-4 sm:gap-5">
    @foreach($categories as $index => $category)
        @php
            $theme = $categoryThemes[$category->name] ?? $fallbackThemes[$index % count($fallbackThemes)];
            $count = (int) $category->scriptures_count;
            $countLabel = $count.' '.$theme['label'].($count !== 1 ? '' : '');
            $href = route('tools.show', ['slug' => 'doc-kinh', 'category' => $category->id]).'#danh-sach-kinh';
        @endphp

        <a
            href="{{ $href }}"
            class="scripture-library-card group relative flex flex-col rounded-[1.35rem] border border-[#e8e0d4]/90 bg-gradient-to-b from-white via-white to-[#faf6f0] p-5 sm:p-6 shadow-[0_4px_24px_-8px_rgba(74,44,17,0.08)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_-12px_rgba(74,44,17,0.18)] hover:border-[#c9a77c]/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/35 no-underline text-inherit min-h-[11.5rem]"
            style="--card-accent: {{ $theme['accent'] }}"
        >
            <span
                class="absolute inset-x-0 top-0 h-1 rounded-t-[1.35rem] opacity-80 transition-opacity group-hover:opacity-100"
                style="background: linear-gradient(90deg, transparent, var(--card-accent), transparent)"
                aria-hidden="true"
            ></span>

            <div class="flex items-start justify-between gap-3 mb-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-[#e8e0d4]/80 bg-gradient-to-br {{ $theme['iconGradient'] }} shadow-inner transition-transform duration-300 group-hover:scale-105">
                    <i class="{{ $theme['icon'] }} text-2xl" style="color: var(--card-accent)" aria-hidden="true"></i>
                </div>
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold tabular-nums {{ $theme['accentSoft'] }}">
                    @if($count > 0)
                        {{ $count }} {{ $theme['label'] }}
                    @else
                        <span class="text-[#9a8b7d] font-semibold">Sắp có</span>
                    @endif
                </span>
            </div>

            <h4 class="font-serif text-lg sm:text-xl font-bold text-[#1a1512] leading-snug mb-2 group-hover:text-[#4a2c11] transition-colors">
                {{ $category->name }}
            </h4>

            @if(filled($category->description))
                <p class="text-sm text-[#6b5346]/85 leading-relaxed line-clamp-2 flex-1 mb-4">
                    {{ $category->description }}
                </p>
            @else
                <p class="text-sm text-[#9a8b7d]/90 leading-relaxed flex-1 mb-4 italic">
                    Khám phá bộ sưu tập kinh điển
                </p>
            @endif

            <span class="mt-auto inline-flex items-center gap-2 text-sm font-semibold transition-colors" style="color: var(--card-accent)">
                <span>{{ $count > 0 ? 'Xem danh sách' : 'Mở thư mục' }}</span>
                <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-0.5" aria-hidden="true"></i>
            </span>
        </a>
    @endforeach
</div>
