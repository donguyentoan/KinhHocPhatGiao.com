@props(['utilities'])

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
    @foreach($utilities as $utility)
        <div class="group bg-white/60 border border-gray-300 rounded-2xl p-5 flex flex-col items-center text-center transition-all duration-300 hover:bg-white hover:shadow-xl hover:-translate-y-1">
            <div class="w-16 h-16 mb-3 flex items-center justify-center rounded-full bg-orange-50 group-hover:bg-orange-100 transition-colors">
                <img class="w-12 h-12 object-contain group-hover:scale-110 transition-transform duration-300" src="{{ $utility->icon_url }}" alt="{{ $utility->name }}">
            </div>
            <span class="font-semibold text-sm group-hover:text-[#8b5e34] transition-colors">{{ $utility->name }}</span>
        </div>
    @endforeach
</div>
