@props(['scriptures'])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-8">
    @foreach($scriptures as $scripture)
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-[#e5dec9]/50">
            <div class="relative aspect-video overflow-hidden bg-[#f5f0e8]">
                @php($thumb = $scripture->resolvedImageUrl())
                @if(filled($thumb))
                    <img src="{{ $thumb }}" alt="{{ $scripture->title }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" loading="lazy" decoding="async">
                @else
                    <div class="flex h-full w-full items-center justify-center text-[#8b5e34]/35">
                        <i class="fa-solid fa-book-open text-4xl" aria-hidden="true"></i>
                    </div>
                @endif
            </div>
            <div class="p-4 sm:p-6">
                <h5 class="font-bold text-base sm:text-lg leading-snug mb-3 line-clamp-2 min-h-[2.75rem] sm:min-h-[3.5rem]">{{ $scripture->title }}</h5>
                <div class="flex items-center justify-between text-[11px] text-[#8b5e34]/60 mb-6">
                    <span>{{ $scripture->duration_minutes }} phút</span>
                    <span>{{ number_format($scripture->chant_count) }} lượt tụng</span>
                </div>
                <a href="{{ route('scriptures.read', $scripture) }}" class="block text-center w-full py-3 bg-[#f9f3e6] rounded-2xl font-bold text-sm hover:bg-[#8b5e34] hover:text-white transition-all">
                    Bắt đầu tụng
                </a>
            </div>
        </div>
    @endforeach
</div>
