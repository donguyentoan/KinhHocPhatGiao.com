@push('head')
    <x-seo-meta
        :canonical="route('recipes.index')"
        description="Khám phá món chay thanh đạm, hướng dẫn nấu chi tiết và gợi ý ăn chay healthy — nuôi dưỡng thân tâm an lạc qua ẩm thực."
    />
@endpush

<div class="min-h-screen bg-[#fdfaf5]">
    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-3xl mx-4 sm:mx-0 mb-12 border border-[#e8e0d4]">
        <div class="absolute inset-0 bg-gradient-to-br from-[#e8f5e9] via-[#fdfaf5] to-[#f5ebe0]"></div>
        <div class="absolute inset-0 opacity-40" style="background-image: radial-gradient(circle at 20% 80%, rgba(139,94,52,0.12) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(76,120,76,0.15) 0%, transparent 45%);"></div>
        <div class="relative px-6 sm:px-12 py-14 sm:py-20 max-w-4xl">
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#5a7a5a] mb-3">Ẩm thực chánh niệm</p>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-[#1a1512] leading-tight">
                Món chay thanh đạm<br class="hidden sm:block">
                <span class="text-[#8b5e34]">ngon &amp; bình an</span>
            </h1>
            <p class="mt-5 text-base sm:text-lg text-[#4a2c11]/85 leading-relaxed max-w-2xl">
                Khám phá công thức nấu chay nhẹ nhàng, học cách ăn uống lành mạnh và tìm cảm giác thanh tịnh qua từng bữa ăn — không cần phức tạp, chỉ cần tâm an.
            </p>
            <div class="mt-8 flex flex-wrap gap-4 text-sm">
                <span class="inline-flex items-center gap-2 bg-white/70 border border-[#e8e0d4] px-4 py-2 rounded-full text-[#4a2c11]">
                    <i class="fa-solid fa-seedling text-[#5a7a5a]" aria-hidden="true"></i> Nguyên liệu tươi
                </span>
                <span class="inline-flex items-center gap-2 bg-white/70 border border-[#e8e0d4] px-4 py-2 rounded-full text-[#4a2c11]">
                    <i class="fa-solid fa-heart text-[#8b5e34]" aria-hidden="true"></i> Healthy &amp; nhẹ bụng
                </span>
                <span class="inline-flex items-center gap-2 bg-white/70 border border-[#e8e0d4] px-4 py-2 rounded-full text-[#4a2c11]">
                    <i class="fa-solid fa-spa text-[#5a7a5a]" aria-hidden="true"></i> Nấu trong 30 phút
                </span>
            </div>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 pb-16">
        <nav class="mb-8" aria-label="Điều hướng">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#8b5e34] hover:text-[#6f4a2b] hover:underline">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
                Về trang chủ
            </a>
        </nav>

        @if($featured->isNotEmpty())
            <section class="mb-14" aria-labelledby="featured-recipes-heading">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-2 h-8 bg-[#5a7a5a] rounded-full"></div>
                    <h2 id="featured-recipes-heading" class="font-serif text-2xl font-bold text-[#4a2c11]">Gợi ý cho bạn hôm nay</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featured as $recipe)
                        <x-recipe-card :recipe="$recipe" wire:key="feat-recipe-{{ $recipe->id }}" />
                    @endforeach
                </div>
            </section>
        @endif

        <section aria-labelledby="all-recipes-heading">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-2 h-8 bg-[#8b5e34] rounded-full"></div>
                <h2 id="all-recipes-heading" class="font-serif text-2xl font-bold text-[#4a2c11]">Tất cả món chay</h2>
            </div>

            @if($recipes->isEmpty())
                <div class="text-center py-16 rounded-3xl border border-dashed border-[#e8e0d4] bg-white/50">
                    <i class="fa-solid fa-leaf text-4xl text-[#c9a77c] mb-4" aria-hidden="true"></i>
                    <p class="text-[#4a2c11]/70">Đang cập nhật công thức mới. Vui lòng quay lại sau.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recipes as $recipe)
                        <x-recipe-card :recipe="$recipe" wire:key="recipe-{{ $recipe->id }}" />
                    @endforeach
                </div>
            @endif
        </section>

        {{-- Healthy eating tips block --}}
        <section class="mt-16 rounded-3xl border border-[#d4e8d4] bg-gradient-to-br from-[#f4faf4] to-white p-8 sm:p-10" aria-labelledby="healthy-tips-heading">
            <h2 id="healthy-tips-heading" class="font-serif text-xl sm:text-2xl font-bold text-[#3d5c3d] mb-4">Ăn chay healthy — gợi ý nhẹ nhàng</h2>
            <ul class="space-y-3 text-[#4a2c11]/90 text-sm sm:text-base leading-relaxed">
                <li class="flex gap-3"><span class="text-[#5a7a5a] font-bold shrink-0">•</span> Ưu tiên rau củ theo mùa, đậu hũ và ngũ cốc — đủ chất, dễ tiêu.</li>
                <li class="flex gap-3"><span class="text-[#5a7a5a] font-bold shrink-0">•</span> Nấu vừa đủ, ăn chậm, nhai kỹ — nuôi tâm chánh niệm ngay tại bàn ăn.</li>
                <li class="flex gap-3"><span class="text-[#5a7a5a] font-bold shrink-0">•</span> Hạn chế chiên nhiều dầu; chưng, hấp, ninh giúp cơ thể nhẹ nhàng hơn.</li>
                <li class="flex gap-3"><span class="text-[#5a7a5a] font-bold shrink-0">•</span> Một ngày chay tuần hoặc ngày rằm — bắt đầu từ từ, không ép buộc bản thân.</li>
            </ul>
        </section>
    </div>
</div>
