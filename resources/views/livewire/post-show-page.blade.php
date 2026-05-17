@push('head')
    <x-seo-meta
        :canonical="route('posts.show', $post)"
        :description="$post->excerpt ?: $post->title"
    />
@endpush

<div class="min-h-screen">
    <article class="max-w-3xl mx-auto px-4 sm:px-6 py-10 lg:py-14">
        <nav class="mb-8" aria-label="Điều hướng">
            <a href="{{ route('home') }}#bai-viet-noi-bat" class="inline-flex items-center gap-2 text-sm font-semibold text-[#8b5e34] hover:text-[#6f4a2b] hover:underline">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
                Về trang chủ
            </a>
        </nav>

        <header class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#8b5e34]/80 mb-2">Bài chia sẻ</p>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#1a1512] leading-tight tracking-tight">
                {{ $post->title }}
            </h1>
            @if($post->published_at)
                <p class="mt-4 text-sm text-[#8b5e34]">
                    <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->locale('vi')->translatedFormat('l, d/m/Y') }}</time>
                </p>
            @endif
        </header>

        @if(filled($heroImage))
            <figure class="mb-10 rounded-2xl overflow-hidden border border-[#e8e0d4] shadow-sm bg-[#faf6f0]">
                <img src="{{ $heroImage }}" alt="" class="w-full max-h-[420px] object-cover" loading="eager" decoding="async">
            </figure>
        @endif

        <div class="prose prose-stone prose-lg max-w-none text-[#4a2c11]">
            <div class="whitespace-pre-wrap leading-relaxed text-base sm:text-[17px]">
                {{ $post->excerpt }}
            </div>
        </div>
    </article>
</div>
