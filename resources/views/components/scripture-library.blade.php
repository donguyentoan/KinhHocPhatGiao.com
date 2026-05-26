@props(['categories'])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
    @foreach($categories as $index => $category)
        @php
            $categoryThemes = [
                'Hệ Thống Kinh' => ['iconWrap' => 'bg-orange-100 text-[#8b5e34] group-hover:bg-[#8b5e34] group-hover:text-white', 'icon' => 'fa-solid fa-book-open', 'label' => 'bài', 'ctaColor' => 'text-[#8b5e34]'],
                'Kinh Địa Tạng' => ['iconWrap' => 'bg-red-100 text-red-700 group-hover:bg-red-700 group-hover:text-white', 'icon' => 'fa-solid fa-gopuram', 'label' => 'bài', 'ctaColor' => 'text-red-700'],
                'Mật Chú' => ['iconWrap' => 'bg-purple-100 text-purple-700 group-hover:bg-purple-700 group-hover:text-white', 'icon' => 'fa-solid fa-scroll', 'label' => 'chú', 'ctaColor' => 'text-purple-700'],
                'Tụng Hằng Ngày' => ['iconWrap' => 'bg-blue-100 text-blue-700 group-hover:bg-blue-700 group-hover:text-white', 'icon' => 'fa-solid fa-sun', 'label' => 'bài', 'ctaColor' => 'text-blue-700'],
                'Văn Sám Hối' => ['iconWrap' => 'bg-emerald-100 text-emerald-700 group-hover:bg-emerald-700 group-hover:text-white', 'icon' => 'fa-solid fa-hands-praying', 'label' => 'bài', 'ctaColor' => 'text-emerald-700'],
                'Sách Phật Giáo' => ['iconWrap' => 'bg-amber-100 text-amber-700 group-hover:bg-amber-700 group-hover:text-white', 'icon' => 'fa-solid fa-book', 'label' => 'bài', 'ctaColor' => 'text-amber-700'],
            ];
            $fallbackThemes = [
                ['iconWrap' => 'bg-orange-100 text-[#8b5e34] group-hover:bg-[#8b5e34] group-hover:text-white', 'icon' => 'fa-solid fa-book-open', 'label' => 'bài', 'ctaColor' => 'text-[#8b5e34]'],
                ['iconWrap' => 'bg-sky-100 text-sky-700 group-hover:bg-sky-700 group-hover:text-white', 'icon' => 'fa-solid fa-book-bookmark', 'label' => 'bài', 'ctaColor' => 'text-sky-700'],
                ['iconWrap' => 'bg-lime-100 text-lime-700 group-hover:bg-lime-700 group-hover:text-white', 'icon' => 'fa-solid fa-leaf', 'label' => 'bài', 'ctaColor' => 'text-lime-700'],
            ];
            $theme = $categoryThemes[$category->name] ?? $fallbackThemes[$index % count($fallbackThemes)];
            $cta = 'Xem '.$category->scriptures_count.' '.$theme['label'];
        @endphp

        <a
            href="{{ route('tools.show', ['slug' => 'doc-kinh', 'category' => $category->id]) }}#danh-sach-kinh"
            class="bg-white group relative bg-[#f9f3e6] border border-[#e5dec9] rounded-3xl p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer block no-underline text-inherit"
        >
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-colors {{ $theme['iconWrap'] }}">
                <i class="{{ $theme['icon'] }} text-2xl"></i>
            </div>
            <h4 class="font-serif text-xl font-bold text-[#4a2c11] mb-2">{{ $category->name }}</h4>
            <p class="text-sm text-[#8b5e34]/70 leading-relaxed mb-4 line-clamp-2">{{ $category->description }}</p>
            <span class="text-xs font-bold uppercase tracking-widest {{ $theme['ctaColor'] }} flex items-center gap-2">
                {{ $cta }} <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </span>
        </a>
    @endforeach
</div>
