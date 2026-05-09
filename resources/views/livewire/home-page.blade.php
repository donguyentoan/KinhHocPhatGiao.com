<div>
    <header style="max-height: 77px" class="z-50 bg-[#f9f3e6] border-b border-[#e5dec9] px-6 py-3 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img style="height: 77px" src="/logoWeb.png" alt="">
            </a>
            <nav class="hidden lg:flex flex-wrap items-center gap-6">
                <a href="{{ route('tools.show', 'may-niem-phat') }}" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Máy niệm Phật</a>
                <a href="/#thu-vien-kinh-dien" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Đọc Kinh</a>
                <a href="{{ route('tools.show', 'ngoi-thien') }}" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Ngồi Thiền</a>
                <a href="{{ route('tools.show', 'chuong-mo') }}" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Chuông Mõ</a>
                <a href="{{ route('tools.show', 'lan-chuoi-hat') }}" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Lần chuỗi hạt</a>
                <a href="{{ route('tools.show', 'nhac-thien') }}" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Nhạc Thiền</a>
                <a href="{{ route('tools.show', 'su-kien-trong-nam') }}" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Sự kiện</a>
                <a href="{{ route('tools.show', 'lien-he-ho-tro') }}" class="text-[#4a2c11] font-medium text-sm hover:text-[#8b5e34] transition-colors">Liên hệ</a>
            </nav>
            <div class="flex items-center gap-4">
                <p class="flex items-center gap-2 px-5 py-2 text-[#4a2c11] font-bold text-sm rounded-lg hover:bg-[#efe7d5] transition-all">
                    Xin chào, Thiện Hoằng Bảo!
                </p>
            </div>
        </div>
    </header>

    <div class="py-4 container mx-auto font-sans p-3">
        <section class="w-full h-full flex md:flex-row flex-col bg-[#25282c] rounded-[20px] overflow-hidden">
            <div class="relative md:w-7/12 w-full flex flex-col p-10 overflow-hidden group">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                    style="background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20241013/pngtree-a-serene-and-peaceful-background-of-nature-with-lush-greenery-a-image_16380757.jpg');"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-black/80 via-black/40 to-transparent"></div>
                <div class="relative z-10"><p id="txt-thu" class="text-white/80 font-medium text-xl italic">---</p></div>
                <div class="relative z-10 mt-auto">
                    <h1 id="txt-ngayduong" class="text-white text-[120px] font-extrabold leading-none tracking-tighter drop-shadow-2xl">--</h1>
                    <p id="txt-thangnamduong" class="text-white/90 text-2xl font-light tracking-[0.3em] uppercase mt-2">-- ----</p>
                </div>
            </div>
            <div class="md:w-5/12 w-full bg-gradient-to-br from-[#e67e22] to-[#d35400] p-10 flex flex-col shadow-inner">
                <div class="grid grid-cols-3 gap-4 text-center border-b border-white/10 pb-8 text-white">
                    <div><span class="text-[10px] uppercase tracking-widest opacity-60 mb-1">Ngày</span><span id="txt-ngayam" class="block text-4xl font-extrabold">--</span><span id="txt-canchingay" class="text-[10px] mt-2 font-semibold bg-black/10 rounded-md py-1 px-1">---</span></div>
                    <div><span class="text-[10px] uppercase tracking-widest opacity-60 mb-1">Tháng</span><span id="txt-thangam" class="block text-4xl font-extrabold">--</span><span id="txt-canchithang" class="text-[10px] mt-2 font-semibold bg-black/10 rounded-md py-1 px-1">---</span></div>
                    <div><span class="text-[10px] uppercase tracking-widest opacity-60 mb-1">Năm</span><span id="txt-namam" class="block text-4xl font-extrabold">----</span><span id="txt-canchinam" class="text-[10px] mt-2 font-semibold bg-black/10 rounded-md py-1 px-1">---</span></div>
                </div>
                <div class="flex-grow flex items-center justify-center py-6">
                    <p class="text-center italic text-orange-50 leading-relaxed font-light text-sm opacity-90 px-4">
                        Ý dẫn đầu các pháp, Ý làm chủ, ý tạo; Nếu với ý ô nhiễm, nói lên hay hành động, khổ não bước theo sau.
                    </p>
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="flex items-center gap-4 mb-10"><div class="w-2 h-8 bg-[#8b5e34] rounded-full shadow-sm"></div><h3 class="font-serif text-3xl font-bold text-[#4a2c11] tracking-tight">Tiện ích</h3></div>
            <x-utility-grid :utilities="$utilities" />
        </section>

        <section id="thu-vien-kinh-dien" class="py-8 scroll-mt-24">
            <div class="flex items-center gap-4 mb-10"><div class="w-2 h-8 bg-[#8b5e34] rounded-full"></div><h3 class="font-serif text-3xl font-bold text-[#4a2c11]">Thư Viện Kinh Điển</h3></div>
            <x-scripture-library :categories="$categories" />
        </section>

        <section class="py-8">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3"><div class="w-2 h-8 bg-[#8b5e34] rounded-full"></div><h3 class="font-serif text-3xl font-bold text-[#4a2c11]">Bài tụng phổ biến</h3></div>
            </div>
            <x-popular-scriptures :scriptures="$popularScriptures" />
            @if($hasMoreScriptures)
                <div class="mt-8 flex justify-center">
                    <button
                        type="button"
                        wire:click="loadMoreScriptures"
                        class="px-6 py-3 rounded-2xl bg-[#8b5e34] text-white font-semibold hover:bg-[#6f4a2b] transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        wire:target="loadMoreScriptures"
                    >
                        <span wire:loading.remove wire:target="loadMoreScriptures">Xem thêm</span>
                        <span wire:loading wire:target="loadMoreScriptures">Đang tải...</span>
                    </button>
                </div>
            @endif
        </section>

        <section class="py-8">
            <div class="flex items-center gap-4 mb-10"><div class="w-2 h-8 bg-[#8b5e34] rounded-full"></div><h3 class="font-serif text-3xl font-bold text-[#4a2c11]">Bài viết đọc nhiều trong tuần</h3></div>
            <x-popular-posts :posts="$popularPosts" />
        </section>

        <section class="py-8">
        <img  src="/banner.png" alt="">
        </section>
        
    </div>

    <x-site-footer />

    <script>
        const dictionary = {'甲':'Giáp','乙':'Ất','丙':'Bính','丁':'Đinh','戊':'Mậu','己':'Kỷ','庚':'Canh','辛':'Tân','壬':'Nhâm','癸':'Quý','子':'Tý','丑':'Sửu','寅':'Dần','卯':'Mão','辰':'Thìn','巳':'Tỵ','午':'Ngọ','未':'Mùi','申':'Thân','酉':'Dậu','戌':'Tuất','亥':'Hợi'};
        function translate(text){return text.split('').map(char=>dictionary[char]||char).join(' ');}
        function runCalendar(){
            if(typeof Solar==='undefined') return;
            const now=new Date(); const solar=Solar.fromDate(now); const lunar=solar.getLunar();
            document.getElementById('txt-thu').innerText=["Chủ Nhật","Thứ Hai","Thứ Ba","Thứ Tư","Thứ Năm","Thứ Sáu","Thứ Bảy"][now.getDay()];
            document.getElementById('txt-ngayduong').innerText=now.getDate().toString().padStart(2,'0');
            document.getElementById('txt-thangnamduong').innerText=`Tháng ${(now.getMonth()+1).toString().padStart(2,'0')} · ${now.getFullYear()}`;
            document.getElementById('txt-ngayam').innerText=lunar.getDay();
            document.getElementById('txt-thangam').innerText=lunar.getMonth();
            document.getElementById('txt-namam').innerText=lunar.getYear();
            document.getElementById('txt-canchingay').innerText=translate(lunar.getDayInGanZhi());
            document.getElementById('txt-canchithang').innerText=translate(lunar.getMonthInGanZhi());
            document.getElementById('txt-canchinam').innerText=translate(lunar.getYearInGanZhi());
        }
        window.onload=runCalendar;
    </script>
</div>
