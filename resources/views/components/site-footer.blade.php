@php
    $linkClass = 'text-sm text-[#5c4d42] hover:text-[#8b5e34] transition-colors';
    $colTitleClass = 'flex items-center gap-3 mb-4';
@endphp

<footer class="relative mt-auto font-sans">
    <div
        class="relative overflow-hidden border-t border-[#e5dec9] bg-gradient-to-b from-[#fdfaf5] via-[#f9f3e6] to-[#f0e8dc] shadow-[0_-10px_40px_-12px_rgba(45,30,18,0.1)]"
    >
        <div class="relative max-w-7xl mx-auto px-3 sm:px-5 pt-8 sm:pt-10 pb-6">
            {{-- Thẻ nổi nhẹ trên nền kem --}}
            <div
                
            >
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-8 xl:gap-10">
                    {{-- Thương hiệu --}}
                    <div class="lg:col-span-4">
                        <div class="flex items-start gap-3">
                            <span
                                class="mt-1 w-1.5 min-h-[3rem] shrink-0 rounded-full bg-gradient-to-b from-[#e8b86a] to-[#b07d4f] shadow-[0_2px_14px_rgba(212,163,115,0.35)]"
                                aria-hidden="true"
                            ></span>
                            <div class="min-w-0">
                                <a href="{{ route('home') }}" class="inline-block mb-3 transition-opacity hover:opacity-90" aria-label="Về trang chủ">
                                    <img src="/logoWeb.png" class="h-[4.5rem] w-auto object-contain sm:h-20" alt="">
                                </a>
                                <p class="text-sm leading-relaxed text-[#5c4d42] max-w-sm">
                                    Nơi chia sẻ kinh điển, thiền định và giá trị sống an lạc theo giáo lý nhà Phật.
                                </p>
                                <div class="mt-6 flex flex-wrap items-center gap-3">
                                    <x-donate-link variant="button" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Điều hướng + Nội dung: 2 cột trên md --}}
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:col-span-5">
                        <div>
                            <div class="{{ $colTitleClass }}">
                                <span class="h-8 w-1 rounded-full bg-[#8b5e34] shadow-sm shrink-0" aria-hidden="true"></span>
                                <h3 class="text-lg font-bold text-[#2c2118] tracking-tight" style="font-family: 'Noto Serif Display', Georgia, 'Times New Roman', serif;">Điều hướng</h3>
                            </div>
                            <ul class="space-y-2 pl-4 border-l border-[#d4a373]/35">
                                <li><a href="{{ route('tools.show', 'may-niem-phat') }}" class="{{ $linkClass }}">Máy niệm Phật</a></li>
                                <li><a href="{{ route('tools.show', 'doc-kinh') }}" class="{{ $linkClass }}">Đọc Kinh</a></li>
                                <li><a href="{{ route('tools.show', 'hai-loc-phap-cu') }}" class="{{ $linkClass }}">Cây Bồ Đề Pháp Cú</a></li>
                                <li><a href="{{ route('tools.show', 'ngoi-thien') }}" class="{{ $linkClass }}">Ngồi Thiền</a></li>
                                <li><a href="{{ route('tools.show', 'chuong-mo') }}" class="{{ $linkClass }}">Chuông Mõ</a></li>
                                <li><a href="{{ route('tools.show', 'lan-chuoi-hat') }}" class="{{ $linkClass }}">Lần chuỗi hạt</a></li>
                                <li><a href="{{ route('tools.show', 'nhac-thien') }}" class="{{ $linkClass }}">Nhạc Thiền</a></li>
                                <li><a href="{{ route('tools.show', 'su-kien-trong-nam') }}" class="{{ $linkClass }}">Sự kiện trong năm</a></li>
                                <li><a href="{{ route('tools.show', 'lien-he-ho-tro') }}" class="{{ $linkClass }}">Liên hệ hỗ trợ</a></li>
                            </ul>
                        </div>
                        <div>
                            <div class="{{ $colTitleClass }}">
                                <span class="h-8 w-1 rounded-full bg-[#8b5e34] shadow-sm shrink-0" aria-hidden="true"></span>
                                <h3 class="text-lg font-bold text-[#2c2118] tracking-tight" style="font-family: 'Noto Serif Display', Georgia, 'Times New Roman', serif;">Nội dung</h3>
                            </div>
                            <ul class="space-y-2 pl-4 border-l border-[#d4a373]/35">
                                <li><a href="{{ route('tools.show', 'doc-kinh') }}" class="{{ $linkClass }}">Kinh Phật</a></li>
                                <li><a href="{{ route('tools.show', 'doc-kinh') }}" class="{{ $linkClass }}">Mật Chú</a></li>
                                <li><a href="{{ route('home') }}" class="{{ $linkClass }}">Bài viết</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Liên hệ --}}
                    <div class="lg:col-span-3">
                        <div class="{{ $colTitleClass }}">
                            <span class="h-8 w-1 rounded-full bg-[#8b5e34] shadow-sm shrink-0" aria-hidden="true"></span>
                            <h3 class="text-lg font-bold text-[#2c2118] tracking-tight" style="font-family: 'Noto Serif Display', Georgia, 'Times New Roman', serif;">Liên hệ</h3>
                        </div>
                        <a
                            href="mailto:{{ config('site.contact_email') }}"
                            class="flex items-start gap-3 rounded-2xl border border-[#d4a373]/40 bg-gradient-to-br from-[#fff9f0] to-[#f5ebe0] p-4 text-[#2c2118] shadow-sm transition-shadow hover:shadow-md"
                        >
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 border-[#d4a373]/55 bg-[#faf6f0] text-[#b07d4f] shadow-[0_6px_18px_rgba(176,125,79,0.18)]" aria-hidden="true">
                                <i class="fa-solid fa-envelope text-sm"></i>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-bold uppercase tracking-wider text-[#8b5e34]/90 mb-0.5">Email</span>
                                <span class="text-sm font-medium break-all text-[#2c2118]">{{ config('site.contact_email') }}</span>
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Gạch lotus / vàng nhẹ giữa thẻ và chân --}}
                <div class="mt-8 flex items-center justify-center gap-3 opacity-80" aria-hidden="true">
                    <span class="h-px flex-1 max-w-[6rem] bg-gradient-to-r from-transparent to-[#d4a373]/5"></span>
                    <span class="text-[#d4a373]/70 text-xs">✦</span>
                    <span class="h-px flex-1 max-w-[6rem] bg-gradient-to-l from-transparent to-[#d4a373]/5"></span>
                </div>
            </div>
        </div>

        <div class="border-t border-[#e5dec9]/90 bg-[#ebe3d4]/80 px-4 py-3.5 text-center backdrop-blur-[2px]">
            <p class="text-xs sm:text-sm text-[#5c4d42]">
                © {{ date('Y') }} Kinh Học Phật Giáo — Chúc quý vị thân tâm an lạc.
            </p>
        </div>
    </div>
</footer>
