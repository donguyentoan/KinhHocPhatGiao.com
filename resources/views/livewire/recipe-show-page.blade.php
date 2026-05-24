@push('head')
    <x-seo-meta
        :canonical="route('recipes.show', $recipe)"
        :description="$recipe->teaser()"
    />
@endpush

<div class="min-h-screen bg-[#fdfaf5]">
    <article class="max-w-3xl mx-auto px-4 sm:px-6 py-10 lg:py-14">
        <nav class="mb-8" aria-label="Điều hướng">
            <a href="{{ route('recipes.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#8b5e34] hover:text-[#6f4a2b] hover:underline">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
                Tất cả món chay
            </a>
        </nav>

        <header class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#5a7a5a] mb-2">Công thức chay thanh đạm</p>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#1a1512] leading-tight tracking-tight">
                {{ $recipe->title }}
            </h1>
            <div class="flex flex-wrap gap-3 mt-5 text-sm text-[#8b5e34]">
                @if($recipe->prep_minutes)
                    <span class="inline-flex items-center gap-1.5 bg-white border border-[#e8e0d4] px-3 py-1.5 rounded-full">
                        <i class="fa-regular fa-clock" aria-hidden="true"></i> {{ $recipe->prep_minutes }} phút
                    </span>
                @endif
                @if($recipe->servings)
                    <span class="inline-flex items-center gap-1.5 bg-white border border-[#e8e0d4] px-3 py-1.5 rounded-full">
                        <i class="fa-solid fa-bowl-food" aria-hidden="true"></i> {{ $recipe->servings }} phần ăn
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5 bg-white border border-[#e8e0d4] px-3 py-1.5 rounded-full">
                    Độ khó: {{ $recipe->difficultyLabel() }}
                </span>
            </div>
        </header>

        @if(filled($heroImage))
            <figure class="mb-10 rounded-2xl overflow-hidden border border-[#e8e0d4] shadow-sm bg-[#faf6f0]">
                <img src="{{ $heroImage }}" alt="" class="w-full max-h-[420px] object-cover" loading="eager" decoding="async">
            </figure>
        @endif

        @if(filled($recipe->excerpt))
            <p class="text-lg text-[#4a2c11]/90 leading-relaxed mb-10 italic border-l-4 border-[#5a7a5a]/40 pl-5">
                {{ $recipe->excerpt }}
            </p>
        @endif

        @if(filled($recipe->ingredients))
            <section class="mb-10 rounded-2xl bg-white border border-[#e8e0d4] p-6 sm:p-8 shadow-sm" aria-labelledby="ingredients-heading">
                <h2 id="ingredients-heading" class="font-serif text-xl font-bold text-[#4a2c11] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-basket-shopping text-[#5a7a5a]" aria-hidden="true"></i>
                    Nguyên liệu
                </h2>
                <div class="whitespace-pre-wrap text-[#4a2c11] leading-relaxed text-base">{{ $recipe->ingredients }}</div>
            </section>
        @endif

        @if(filled($recipe->content))
            <section class="mb-10" aria-labelledby="steps-heading">
                <h2 id="steps-heading" class="font-serif text-xl font-bold text-[#4a2c11] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-fire-burner text-[#8b5e34]" aria-hidden="true"></i>
                    Cách làm
                </h2>
                <div class="prose prose-stone prose-lg max-w-none text-[#4a2c11]">
                    <div class="whitespace-pre-wrap leading-relaxed text-base sm:text-[17px]">{{ $recipe->content }}</div>
                </div>
            </section>
        @endif

        @if(filled($recipe->health_tips))
            <section class="rounded-2xl border border-[#d4e8d4] bg-gradient-to-br from-[#f4faf4] to-white p-6 sm:p-8" aria-labelledby="health-tips-heading">
                <h2 id="health-tips-heading" class="font-serif text-lg font-bold text-[#3d5c3d] mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-heart-pulse" aria-hidden="true"></i>
                    Gợi ý ăn chay healthy
                </h2>
                <div class="whitespace-pre-wrap text-[#4a2c11]/90 leading-relaxed text-sm sm:text-base">{{ $recipe->health_tips }}</div>
            </section>
        @endif
    </article>

    @if($related->isNotEmpty())
        <section class="max-w-6xl mx-auto px-4 sm:px-6 pb-16 border-t border-[#e8e0d4] pt-12" aria-labelledby="related-heading">
            <h2 id="related-heading" class="font-serif text-2xl font-bold text-[#4a2c11] mb-8">Món khác bạn có thể thích</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($related as $item)
                    <x-recipe-card :recipe="$item" wire:key="related-{{ $item->id }}" />
                @endforeach
            </div>
        </section>
    @endif
</div>
