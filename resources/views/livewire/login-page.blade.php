<div>
    <h1 class="font-['Noto_Serif_Display'] text-2xl font-semibold text-center text-[#4a2c11] mb-2">Đăng nhập</h1>
  
    <form wire:submit="login" class="space-y-5">
        <div>
            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-[#8b5e34]/80 mb-2">Số điện thoại</label>
            <input id="phone" type="tel" wire:model="phone" autocomplete="username" maxlength="10"
                class="w-full rounded-2xl border border-[#8b5e34]/20 bg-white/90 px-4 py-3 text-[#4a2c11] placeholder:text-[#8b5e34]/40 focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/20"
                placeholder="0344123456">
            @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#8b5e34]/80 mb-2">Mật khẩu</label>
            <input id="password" type="password" wire:model="password" autocomplete="current-password"
                class="w-full rounded-2xl border border-[#8b5e34]/20 bg-white/90 px-4 py-3 text-[#4a2c11] focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/20">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <label class="flex items-center gap-2 text-sm text-[#4a2c11] cursor-pointer">
            <input type="checkbox" wire:model="remember" class="rounded border-[#8b5e34]/30 text-[#8b5e34] focus:ring-[#8b5e34]">
            Ghi nhớ đăng nhập
        </label>
        <button type="submit"
            class="w-full rounded-full bg-[#4a2c11] py-3.5 font-bold text-white shadow-md transition hover:bg-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/40">
            Đăng nhập
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-[#6b4f2c]">
        Chưa có tài khoản?
        <a href="{{ route('register') }}" class="font-bold text-[#8b5e34] hover:underline">Đăng ký</a>
    </p>
</div>
