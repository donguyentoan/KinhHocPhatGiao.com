@props(['categories'])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
    @foreach($categories as $index => $category)
        @php
            $themes = [
                ['iconWrap' => 'bg-orange-100 text-[#8b5e34] group-hover:bg-[#8b5e34] group-hover:text-white', 'icon' => 'fa-solid fa-book-open', 'cta' => 'Xem '.$category->scriptures_count.' bài', 'ctaColor' => 'text-[#8b5e34]'],
                ['iconWrap' => 'bg-red-100 text-red-700 group-hover:bg-red-700 group-hover:text-white', 'icon' => 'fa-solid fa-gopuram', 'cta' => 'Đang đọc', 'ctaColor' => 'text-red-700'],
                ['iconWrap' => 'bg-purple-100 text-purple-700 group-hover:bg-purple-700 group-hover:text-white', 'icon' => 'fa-solid fa-hand-holding-magic', 'cta' => 'Xem '.$category->scriptures_count.' chú', 'ctaColor' => 'text-purple-700'],
                ['iconWrap' => 'bg-blue-100 text-blue-700 group-hover:bg-blue-700 group-hover:text-white', 'icon' => 'fa-solid fa-sun', 'cta' => 'Bắt đầu ngay', 'ctaColor' => 'text-blue-700'],
                ['iconWrap' => 'bg-emerald-100 text-emerald-700 group-hover:bg-emerald-700 group-hover:text-white', 'icon' => 'fa-solid fa-hands-praying', 'cta' => 'Xem '.$category->scriptures_count.' bài', 'ctaColor' => 'text-emerald-700'],
            ];
            $theme = $themes[$index % count($themes)];
        @endphp

        <div class="bg-white group relative bg-[#f9f3e6] border border-[#e5dec9] rounded-3xl p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 transition-colors {{ $theme['iconWrap'] }}">
                <i class="{{ $theme['icon'] }} text-2xl"></i>
            </div>
            <h4 class="font-serif text-xl font-bold text-[#4a2c11] mb-2">{{ $category->name }}</h4>
            <p class="text-sm text-[#8b5e34]/70 leading-relaxed mb-4 line-clamp-2">{{ $category->description }}</p>
            <span class="text-xs font-bold uppercase tracking-widest {{ $theme['ctaColor'] }} flex items-center gap-2">
                {{ $theme['cta'] }} <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </span>
        </div>
    @endforeach
</div>
