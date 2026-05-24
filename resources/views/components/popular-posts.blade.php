@props(['posts'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    @foreach($posts as $post)
        @php
            $img = $post->resolvedImageUrl();
        @endphp
        <a href="{{ route('posts.show', $post) }}" class="flex gap-4 group rounded-2xl border border-transparent p-2 -m-2 hover:border-[#e8e0d4] hover:bg-white/60 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/50">
            <div class="w-32 h-32 flex-shrink-0 overflow-hidden rounded-2xl border border-[#e5dec9] bg-[#faf6f0]">
                @if(filled($img))
                    <img src="{{ $img }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="" loading="lazy" decoding="async">
                @else
                    <div class="w-full h-full flex items-center justify-center text-[#c9a77c]" aria-hidden="true">
                        <i class="fa-regular fa-image text-3xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex flex-col justify-center min-w-0">
                <h4 class="font-bold leading-snug group-hover:text-[#8b5e34] transition-colors line-clamp-2 text-[#1a1512]">{{ $post->title }}</h4>
                <p class="text-xs text-[#8b5e34]/60 mt-2 line-clamp-2">{{ $post->teaser() }}</p>
                <span class="mt-2 text-xs font-semibold text-[#8b5e34]">Đọc bài →</span>
            </div>
        </a>
    @endforeach
</div>
