@props(['posts'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    @foreach($posts as $post)
        <div class="flex gap-4 group cursor-pointer">
            <div class="w-32 h-32 flex-shrink-0 overflow-hidden rounded-2xl border border-[#e5dec9]">
                <img src="{{ $post->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $post->title }}">
            </div>
            <div class="flex flex-col justify-center">
                <h4 class="font-bold leading-snug group-hover:text-[#8b5e34] transition-colors line-clamp-2">{{ $post->title }}</h4>
                <p class="text-xs text-[#8b5e34]/60 mt-2 line-clamp-2">{{ $post->excerpt }}</p>
            </div>
        </div>
    @endforeach
</div>
