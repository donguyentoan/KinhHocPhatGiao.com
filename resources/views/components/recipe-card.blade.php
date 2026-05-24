@props(['recipe'])

@php
    $img = $recipe->resolvedImageUrl();
@endphp

<a href="{{ route('recipes.show', $recipe) }}" {{ $attributes->merge(['class' => 'group flex flex-col rounded-3xl border border-[#e8e0d4] bg-white/80 overflow-hidden shadow-sm hover:shadow-lg hover:border-[#c9a77c]/50 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40']) }}>
    <div class="aspect-[4/3] bg-gradient-to-br from-[#f0ebe3] to-[#e8f0e8] overflow-hidden relative">
        @if(filled($img))
            <img src="{{ $img }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
        @else
            <div class="w-full h-full flex items-center justify-center text-[#8b5e34]/30">
                <i class="fa-solid fa-leaf text-5xl" aria-hidden="true"></i>
            </div>
        @endif
        @if($recipe->is_featured)
            <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-wider bg-[#8b5e34] text-white px-2.5 py-1 rounded-full">Nổi bật</span>
        @endif
    </div>
    <div class="p-5 flex flex-col flex-1">
        <h3 class="font-bold text-[#1a1512] leading-snug line-clamp-2 group-hover:text-[#8b5e34] transition-colors">{{ $recipe->title }}</h3>
        <p class="text-xs text-[#8b5e34]/70 mt-2 line-clamp-2 flex-1">{{ $recipe->teaser() }}</p>
        <div class="flex flex-wrap gap-2 mt-4 text-[10px] font-semibold text-[#8b5e34]/80">
            @if($recipe->prep_minutes)
                <span class="inline-flex items-center gap-1 bg-[#faf6f0] px-2 py-1 rounded-full"><i class="fa-regular fa-clock" aria-hidden="true"></i> {{ $recipe->prep_minutes }} phút</span>
            @endif
            @if($recipe->servings)
                <span class="inline-flex items-center gap-1 bg-[#faf6f0] px-2 py-1 rounded-full"><i class="fa-solid fa-bowl-food" aria-hidden="true"></i> {{ $recipe->servings }} phần</span>
            @endif
            <span class="inline-flex items-center gap-1 bg-[#faf6f0] px-2 py-1 rounded-full">{{ $recipe->difficultyLabel() }}</span>
        </div>
        <span class="mt-4 text-xs font-bold text-[#8b5e34]">Xem công thức →</span>
    </div>
</a>
