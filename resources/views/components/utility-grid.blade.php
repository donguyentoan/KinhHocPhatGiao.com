@props(['utilities'])

<div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-5">
    @foreach($utilities as $utility)
        @php
            $href = $utility->link_url;
            $icons = [
                'Máy niệm phật' => ['class' => 'fa-solid fa-volume-high', 'text' => 'text-amber-700', 'bg' => 'from-amber-50 to-orange-100'],
                'Đọc kinh' => ['class' => 'fa-solid fa-book-open', 'text' => 'text-[#8b5e34]', 'bg' => 'from-[#fff8ec] to-[#f2e2c8]'],
                'Ngồi thiền' => ['class' => 'fa-solid fa-spa', 'text' => 'text-emerald-700', 'bg' => 'from-emerald-50 to-green-100'],
                'Chuông mõ' => ['class' => 'fa-solid fa-bell', 'text' => 'text-yellow-700', 'bg' => 'from-yellow-50 to-amber-100'],
                'Lần chuỗi hạt' => ['class' => 'fa-solid fa-hands-praying', 'text' => 'text-purple-700', 'bg' => 'from-purple-50 to-violet-100'],
                'Nhạc thiền' => ['class' => 'fa-solid fa-music', 'text' => 'text-sky-700', 'bg' => 'from-sky-50 to-blue-100'],
                'Sự kiện trong năm' => ['class' => 'fa-solid fa-calendar-days', 'text' => 'text-rose-700', 'bg' => 'from-rose-50 to-pink-100'],
                'Liên hệ hỗ trợ' => ['class' => 'fa-solid fa-headset', 'text' => 'text-indigo-700', 'bg' => 'from-indigo-50 to-slate-100'],
                'Cây Bồ Đề Pháp Cú' => ['class' => 'fa-solid fa-tree', 'text' => 'text-green-700', 'bg' => 'from-lime-50 to-green-100'],
                'Trắc nghiệm Phật giáo' => ['class' => 'fa-solid fa-circle-question', 'text' => 'text-cyan-700', 'bg' => 'from-cyan-50 to-teal-100'],
                'Món chay thanh đạm' => ['class' => 'fa-solid fa-bowl-food', 'text' => 'text-[#5a7a5a]', 'bg' => 'from-[#f4faf4] to-[#e4f2e4]'],
            ];
            $icon = $icons[$utility->name] ?? null;
        @endphp
        @if(filled($href))
            <a href="{{ $href }}" class="flex items-center gap-4 rounded-2xl border border-[#e8e0d4] bg-white/90 px-4 py-4 sm:px-5 sm:py-4 shadow-sm hover:shadow-md hover:border-[#c9a77c]/45 transition-all group focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40">
        @else
            <div class="flex items-center gap-4 rounded-2xl border border-[#e8e0d4] bg-white/60 px-4 py-4 sm:px-5 sm:py-4 opacity-80 group">
        @endif
            <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-xl border border-[#e8e0d4] flex items-center justify-center overflow-hidden shadow-inner bg-gradient-to-br {{ $icon['bg'] ?? 'from-[#faf6f0] to-[#f2eadf]' }}">
                @if($icon)
                    <i class="{{ $icon['class'] }} {{ $icon['text'] }} text-2xl sm:text-3xl group-hover:scale-110 transition-transform duration-300" aria-hidden="true"></i>
                @elseif(filled($utility->icon_url))
                    <img class="w-11 h-11 sm:w-12 sm:h-12 object-contain group-hover:scale-105 transition-transform duration-300" src="{{ $utility->icon_url }}" alt="{{ $utility->name }}">
                @else
                    <i class="fa-solid fa-leaf text-[#8b5e34] text-2xl sm:text-3xl group-hover:scale-110 transition-transform duration-300" aria-hidden="true"></i>
                @endif
            </div>
            <div class="flex-1 min-w-0 text-left">
                <span class="font-bold text-[#1a1512] text-sm sm:text-base leading-snug group-hover:text-[#8b5e34] transition-colors">{{ $utility->name }}</span>
            </div>
            @if(filled($href))
                <i class="fa-solid fa-chevron-right text-[#c4b8a8] text-sm group-hover:text-[#8b5e34] flex-shrink-0" aria-hidden="true"></i>
            @endif
        @if(filled($href))
            </a>
        @else
            </div>
        @endif
    @endforeach
</div>
