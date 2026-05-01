<header class="z-50 bg-[#f9f3e6] border-b border-[#e5dec9] px-6 py-3 shadow-sm">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img class="w-24 h-13" src="http://kinhhocphatgiao.local/image/logothb.png" alt="Logo">
        </a>
        <nav class="hidden lg:flex flex-wrap items-center gap-6 text-sm font-medium">
            <a href="{{ route('tools.show', 'may-niem-phat') }}" class="hover:text-[#8b5e34] transition-colors">Máy niệm Phật</a>
            <a href="/#thu-vien-kinh-dien" class="hover:text-[#8b5e34] transition-colors">Đọc Kinh</a>
            <a href="{{ route('tools.show', 'ngoi-thien') }}" class="hover:text-[#8b5e34] transition-colors">Ngồi Thiền</a>
            <a href="{{ route('tools.show', 'chuong-mo') }}" class="hover:text-[#8b5e34] transition-colors">Chuông Mõ</a>
            <a href="{{ route('tools.show', 'lan-chuoi-hat') }}" class="hover:text-[#8b5e34] transition-colors">Lần chuỗi hạt</a>
            <a href="{{ route('tools.show', 'nhac-thien') }}" class="hover:text-[#8b5e34] transition-colors">Nhạc Thiền</a>
            <a href="{{ route('tools.show', 'su-kien-trong-nam') }}" class="hover:text-[#8b5e34] transition-colors">Sự kiện</a>
            <a href="{{ route('tools.show', 'lien-he-ho-tro') }}" class="hover:text-[#8b5e34] transition-colors">Liên hệ</a>
            <a href="{{ route('dashboard') }}" class="hover:text-[#8b5e34] transition-colors">Dashboard</a>
        </nav>
        <p class="px-5 py-2 font-bold text-sm rounded-lg">Xin chao, Thien Hoang Bao!</p>
    </div>
</header>
