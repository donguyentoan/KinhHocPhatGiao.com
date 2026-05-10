@props(['utilities'])

<div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-5">
    @foreach($utilities as $utility)
        @php
            $href = $utility->link_url;
        @endphp
        @if(filled($href))
            <a href="{{ $href }}" class="flex items-center gap-4 rounded-2xl border border-[#e8e0d4] bg-white/90 px-4 py-4 sm:px-5 sm:py-4 shadow-sm hover:shadow-md hover:border-[#c9a77c]/45 transition-all group focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40">
        @else
            <div class="flex items-center gap-4 rounded-2xl border border-[#e8e0d4] bg-white/60 px-4 py-4 sm:px-5 sm:py-4 opacity-80 group">
        @endif
            <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-[#faf6f0] border border-[#e8e0d4] flex items-center justify-center overflow-hidden shadow-inner">
                <img class="w-11 h-11 sm:w-12 sm:h-12 object-contain group-hover:scale-105 transition-transform duration-300" src="{{ $utility->icon_url }}" alt="{{ $utility->name }}">
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
