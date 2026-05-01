@props(['scriptures'])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
    @foreach($scriptures as $scripture)
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-[#e5dec9]/50">
            <div class="relative aspect-video overflow-hidden">
                <img src="{{ $scripture->image_url }}" alt="{{ $scripture->title }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
            </div>
            <div class="p-6">
                <h5 class="font-bold text-lg leading-snug mb-3 line-clamp-2 h-14">{{ $scripture->title }}</h5>
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
