<div>
    @if($showIntroModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-3 bg-black/50 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="intro-modal-title">
            <div class="w-full max-w-4xl max-h-[92vh] overflow-y-auto rounded-[2rem] shadow-2xl border border-white/50 bg-[radial-gradient(circle,_#fff9e6_0%,_#f7e8ad_100%)] font-['Noto_Serif_Display']">
                <div class="flex flex-col md:flex-row bg-white/40 backdrop-blur-md rounded-[2rem] overflow-hidden">
                    <div class="md:w-2/3 p-4 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-amber-200/50">
                        <div class="relative mb-4 md:mb-6">
                            <img class="h-40 md:h-56 mx-auto rounded-full drop-shadow-[0_0_20px_rgba(255,215,0,0.3)]" src="https://www.daophatngaynay.com/buddha-moi.gif" alt="Đức Phật">
                        </div>
                        <div class="text-center space-y-3">
                            <h2 id="intro-modal-title" class="font-['Dancing_Script'] text-4xl md:text-5xl text-amber-700 leading-tight">Phụng sự nhân sinh</h2>
                            <div class="h-[1px] w-32 mx-auto bg-gradient-to-r from-transparent via-amber-700 to-transparent my-3"></div>
                            <p class="text-lg md:text-xl text-gray-700 italic">Tốt đời - đẹp đạo</p>
                            <p class="font-['Dancing_Script'] text-2xl md:text-3xl text-amber-900">Hộ quốc <span class="text-amber-500 mx-2">•</span> An dân</p>
                        </div>
                        <div class="mt-6 opacity-60">
                            <img class="mx-auto w-12" src="https://www.daophatngaynay.com/logo_tron.gif" alt="">
                        </div>
                    </div>
                    <div class="md:w-1/3 p-6 md:p-10 bg-white/20 flex flex-col justify-center">
                        <div class="space-y-6">
                            <div class="text-center md:text-left">
                                <h3 class="text-amber-800 font-bold tracking-[0.2em] text-sm uppercase mb-2">Pháp danh Phật tử</h3>
                                <p class="text-sm text-amber-900/60 italic">Vui lòng nhập pháp danh của bạn</p>
                            </div>
                            <div class="space-y-3">
                                <input
                                    type="text"
                                    wire:model.defer="introDharmaName"
                                    placeholder="Ví dụ: Chúc An..."
                                    class="w-full px-4 py-2 rounded-xl bg-white/70 border border-amber-200 text-amber-900 placeholder-amber-900/30 text-base focus:outline-none"
                                >
                                @error('introDharmaName')
                                    <p class="text-sm text-red-700">{{ $message }}</p>
                                @enderror
                                <div class="flex flex-col gap-2">
                                    <button type="button" wire:click="saveIntro" class="w-full py-2.5 bg-amber-700 hover:bg-amber-800 text-white rounded-xl font-bold transition-all">Lưu thông tin</button>
                                    <button type="button" wire:click="skipIntro" class="w-full py-2.5 bg-transparent border border-amber-700/30 text-amber-800 hover:bg-amber-700/5 rounded-xl font-medium">Để sau</button>
                                </div>
                            </div>
                            <p class="text-center text-[11px] text-amber-800/40 uppercase tracking-[0.25em]">Tâm an vạn sự an</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('auth_notice'))
        <div class="bg-amber-100 border-b border-amber-200 text-amber-950 text-sm text-center py-2 px-4 font-medium">
            {{ session('auth_notice') }}
        </div>
    @endif

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

        <x-daily-wish-moment :wishes="$dailyWishes" />

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

        <section id="bai-viet-noi-bat" class="py-8 scroll-mt-24">
            <div class="flex items-center gap-4 mb-10"><div class="w-2 h-8 bg-[#8b5e34] rounded-full"></div><h3 class="font-serif text-3xl font-bold text-[#4a2c11]">Bài viết đọc nhiều trong tuần</h3></div>
            <x-popular-posts :posts="$popularPosts" />
        </section>


        <section class="text-gray-600 body-font bg-[#fdfaf5] overflow-hidden rounded-xl shadow-2xl">
  <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
    
    <!-- Cột bên trái: Mockup Điện Thoại -->
    <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0 flex justify-center">
      <div class="relative mx-auto border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[600px] w-[300px] shadow-2xl scale-90 md:scale-100">
        <!-- Các nút vật lý điện thoại -->
        <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
        <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
        <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[178px] rounded-l-lg"></div>
        <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
        
        <div class="rounded-[2rem] overflow-hidden w-full h-full bg-white">
          <div 
            class="w-full h-full bg-cover animate-scroll-mobile" 
            style="background-image: url('/screen.png'); background-position: top center;">
          </div>
        </div>
      </div>
    </div>

    <!-- Cột bên phải: Nội dung -->
    <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
      <h1 class="title-font sm:text-5xl text-4xl mb-6 font-bold text-[#8d6e3e] leading-tight">
        Thiên Hoàng Bảo
      </h1>
      <span class="text-2xl font-light text-gray-700 italic">Trải nghiệm tâm linh trên từng điểm chạm</span>
      <p class="mb-8 leading-relaxed text-lg text-gray-700 max-w-lg">
        Ứng dụng Thiên Hoàng Bảo mang cả không gian thư viện kinh điển, bài tụng phổ biến và những bài viết an lạc vào ngay lòng bàn tay bạn.
      </p>
      
      <!-- Input & Button: Fix Mobile Layout -->
      <!-- <div class="flex flex-col w-full items-center md:items-start mb-10">
        <label for="hero-field" class="leading-7 text-sm text-gray-600 font-medium mb-1">Nhận link tải App qua Email</label>
        <div class="flex flex-wrap md:flex-nowrap justify-center md:justify-start w-full gap-3">
          <input type="text" id="hero-field" name="hero-field" placeholder="Email của bạn..." class="w-full max-w-[250px] bg-white rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#c5a059] focus:border-[#c5a059] text-base outline-none text-gray-700 py-2 px-4 transition-colors shadow-sm">
          <button class="inline-flex text-white bg-[#8d6e3e] border-0 py-2 px-8 focus:outline-none hover:bg-[#c5a059] rounded-lg text-lg transition-all shadow-md font-medium">Gửi link</button>
        </div>
      </div> -->
      
      <!-- App Stores: Fix Mobile Layout -->
      <div class="flex  justify-center md:justify-start gap-2">
        <button class="bg-black text-white inline-flex py-3 px-5 rounded-xl items-center hover:bg-gray-800 transition-all w-[170px]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 512 512">
            <path d="M99.617 8.057a50.191 50.191 0 00-38.815-6.713l230.932 230.933 74.846-74.846L99.617 8.057zM32.139 20.116c-6.441 8.563-10.148 19.077-10.148 30.199v411.358c0 11.123 3.708 21.636 10.148 30.199l235.877-235.877L32.139 20.116zM464.261 212.087l-67.266-37.637-81.544 81.544 81.548 81.548 67.273-37.64c16.117-9.03 25.738-25.442 25.738-43.908s-9.621-34.877-25.749-43.907zM291.733 279.711L60.815 510.629c3.786.891 7.639 1.371 11.492 1.371a50.275 50.275 0 0027.31-8.07l266.965-149.372-74.849-74.847z"></path>
          </svg>
          <span class="ml-3 flex flex-col items-start leading-none">
            <span class="text-[10px] text-gray-400 mb-1 uppercase">Get it on</span>
            <span class="title-font font-medium">Google Play</span>
          </span>
        </button>
        <button class="bg-black text-white inline-flex py-3 px-5 rounded-xl items-center hover:bg-gray-800 transition-all w-[170px]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 305 305">
            <path d="M40.74 112.12c-25.79 44.74-9.4 112.65 19.12 153.82C74.09 286.52 88.5 305 108.24 305c.37 0 .74 0 1.13-.02 9.27-.37 15.97-3.23 22.45-5.99 7.27-3.1 14.8-6.3 26.6-6.3 11.22 0 18.39 3.1 25.31 6.1 6.83 2.95 13.87 6 24.26 5.81 22.23-.41 35.88-20.35 47.92-37.94a168.18 168.18 0 0021-43l.09-.28a2.5 2.5 0 00-1.33-3.06l-.18-.08c-3.92-1.6-38.26-16.84-38.62-58.36-.34-33.74 25.76-51.6 31-54.84l.24-.15a2.5 2.5 0 00.7-3.51c-18-26.37-45.62-30.34-56.73-30.82a50.04 50.04 0 00-4.95-.24c-13.06 0-25.56 4.93-35.61 8.9-6.94 2.73-12.93 5.09-17.06 5.09-4.64 0-10.67-2.4-17.65-5.16-9.33-3.7-19.9-7.9-31.1-7.9l-.79.01c-26.03.38-50.62 15.27-64.18 38.86z"></path>
            <path d="M212.1 0c-15.76.64-34.67 10.35-45.97 23.58-9.6 11.13-19 29.68-16.52 48.38a2.5 2.5 0 002.29 2.17c1.06.08 2.15.12 3.23.12 15.41 0 32.04-8.52 43.4-22.25 11.94-14.5 17.99-33.1 16.16-49.77A2.52 2.52 0 00212.1 0z"></path>
          </svg>
          <span class="ml-3 flex flex-col items-start leading-none">
            <span class="text-[10px] text-gray-400 mb-1 uppercase">Download on the</span>
            <span class="title-font font-medium">App Store</span>
          </span>
        </button>
      </div>
    </div>
  </div>

  <style>
    @keyframes scroll-mobile {
      0% { background-position: top center; }
      50% { background-position: bottom center; }
      100% { background-position: top center; }
    }
    .animate-scroll-mobile {
      animation: scroll-mobile 90s linear infinite;
    }
  </style>
</section>
        
    </div>

    <x-site-footer />

    <script src="{{ asset('js/calendar-converter.js') }}"></script>
    <script>
        const dictionary = {'甲':'Giáp','乙':'Ất','丙':'Bính','丁':'Đinh','戊':'Mậu','己':'Kỷ','庚':'Canh','辛':'Tân','壬':'Nhâm','癸':'Quý','子':'Tý','丑':'Sửu','寅':'Dần','卯':'Mão','辰':'Thìn','巳':'Tỵ','午':'Ngọ','未':'Mùi','申':'Thân','酉':'Dậu','戌':'Tuất','亥':'Hợi'};
        function translate(text){return text.split('').map(char=>dictionary[char]||char).join(' ');}
        function runCalendar(){
            if (typeof calendar === 'undefined') return;
            const now = new Date();
            const r = calendar.solar2lunar(now.getFullYear(), now.getMonth() + 1, now.getDate());
            if (!r || r.lDay === undefined) return;
            document.getElementById('txt-thu').innerText = ['Chủ Nhật','Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy'][now.getDay()];
            document.getElementById('txt-ngayduong').innerText = String(now.getDate()).padStart(2, '0');
            document.getElementById('txt-thangnamduong').innerText = 'Tháng ' + String(now.getMonth() + 1).padStart(2, '0') + ' · ' + now.getFullYear();
            document.getElementById('txt-ngayam').innerText = r.lDay;
            document.getElementById('txt-thangam').innerText = r.lMonth;
            document.getElementById('txt-namam').innerText = r.lYear;
            document.getElementById('txt-canchingay').innerText = translate(r.gzDay);
            document.getElementById('txt-canchithang').innerText = translate(r.gzMonth);
            document.getElementById('txt-canchinam').innerText = translate(r.gzYear);
        }
        runCalendar();
    </script>
</div>
