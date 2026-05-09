<div>
    <h1 class="font-['Noto_Serif_Display'] text-2xl font-semibold text-center text-[#4a2c11] mb-2">Đăng ký</h1>
    <p class="text-sm text-center text-[#6b4f2c] mb-8">Dùng số điện thoại 10 số làm tên đăng nhập</p>

    <form wire:submit="register" class="space-y-5">
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#8b5e34]/80 mb-2">Tên hiển thị <span class="font-normal normal-case text-[#8b5e34]/50">(tùy chọn)</span></label>
            <input id="name" type="text" wire:model="name" maxlength="100"
                class="w-full rounded-2xl border border-[#8b5e34]/20 bg-white/90 px-4 py-3 text-[#4a2c11] placeholder:text-[#8b5e34]/40 focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/20"
                placeholder="Ví dụ: Minh An">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="reg-phone" class="block text-xs font-bold uppercase tracking-wider text-[#8b5e34]/80 mb-2">Số điện thoại</label>
            <input id="reg-phone" type="tel" wire:model="phone" autocomplete="username" maxlength="10"
                class="w-full rounded-2xl border border-[#8b5e34]/20 bg-white/90 px-4 py-3 text-[#4a2c11] placeholder:text-[#8b5e34]/40 focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/20"
                placeholder="0344123456">
            @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="reg-password" class="block text-xs font-bold uppercase tracking-wider text-[#8b5e34]/80 mb-2">Mật khẩu</label>
            <input id="reg-password" type="password" wire:model="password" autocomplete="new-password"
                class="w-full rounded-2xl border border-[#8b5e34]/20 bg-white/90 px-4 py-3 text-[#4a2c11] focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/20">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[#8b5e34]/80 mb-2">Nhập lại mật khẩu</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation" autocomplete="new-password"
                class="w-full rounded-2xl border border-[#8b5e34]/20 bg-white/90 px-4 py-3 text-[#4a2c11] focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/20">
        </div>
        <button type="submit"
            class="w-full rounded-full bg-[#4a2c11] py-3.5 font-bold text-white shadow-md transition hover:bg-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/40">
            Tạo tài khoản
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-[#6b4f2c]">
        Đã có tài khoản?
        <a href="{{ route('login') }}" class="font-bold text-[#8b5e34] hover:underline">Đăng nhập</a>
    </p>
</div>
