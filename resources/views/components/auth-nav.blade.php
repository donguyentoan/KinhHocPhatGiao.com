<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center justify-end gap-2 sm:gap-3']) }}>
    <x-donate-link />
    @auth
        @if(auth()->user()->is_admin)
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-[#8b5e34] hover:underline">Dashboard</a>
        @endif
        <span class="text-sm text-[#4a2c11]/80 max-w-[10rem] sm:max-w-none truncate" title="{{ auth()->user()->phone }}">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm font-semibold text-[#4a2c11] hover:text-[#8b5e34] underline-offset-2 hover:underline">Đăng xuất</button>
        </form>
    @else
        {{-- <a href="{{ route('login') }}" class="text-sm font-semibold text-[#8b5e34] hover:underline">Đăng nhập</a>
        <a href="{{ route('register') }}" class="rounded-full border border-[#8b5e34]/40 px-4 py-1.5 text-sm font-bold text-[#4a2c11] hover:bg-[#efe7d5] transition">Đăng ký</a> --}}
    @endauth
</div>
