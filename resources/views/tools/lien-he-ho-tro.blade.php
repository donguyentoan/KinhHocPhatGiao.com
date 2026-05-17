<x-layouts.tool title="Liên hệ hỗ trợ">
    <div class="space-y-8 lg:space-y-10">
        <div class="lg:grid lg:grid-cols-2 lg:gap-10 xl:gap-12">
        <div class="rounded-2xl border border-[#e8e0d4] bg-white p-5 sm:p-6 lg:p-8 shadow-sm">
            <h2 class="text-base font-bold text-[#1a1512] mb-3 flex items-center gap-2">
                <span aria-hidden="true">🌼</span> Giới thiệu
            </h2>
            <p class="text-sm text-[#5c4d42] leading-relaxed">
                <strong>Kinh Học Phật Giáo</strong> là không gian đọc kinh, thiền định và các tiện ích tu tập trên web —
                giúp bạn giữ nhịp an lạc giữa đời thường, hiểu thêm giáo lý và đồng hành cùng thực hành chánh niệm.
            </p>
        </div>

        <div class="rounded-2xl border border-[#e8e0d4] bg-[#faf6f0] p-5 sm:p-6 lg:p-8 shadow-sm mt-6 lg:mt-0">
            <h2 class="text-base font-bold text-[#1a1512] mb-4">Tính năng nổi bật</h2>
            <ul class="space-y-4 text-sm text-[#4a2c11]">
                
                <li class="flex gap-3">
                    <span class="text-lg flex-shrink-0" aria-hidden="true">📖</span>
                    <div>
                        <strong class="text-[#1a1512]">Thư viện kinh điển</strong>
                        <span class="text-[#6b5346]"> — đọc kinh, mật chú trực tuyến, tiện tra cứu và tu tập hằng ngày.</span>
                    </div>
                </li>
                <li class="flex gap-3">
                    <span class="text-lg flex-shrink-0" aria-hidden="true">🧘</span>
                    <div>
                        <strong class="text-[#1a1512]">Tiện ích tu tập</strong>
                        <span class="text-[#6b5346]"> — máy niệm Phật, chuông mõ, lần chuỗi, nhạc thiền, bấm giờ ngồi thiền có lưu phiên.</span>
                    </div>
                </li>
                <li class="flex gap-3">
                    <span class="text-lg flex-shrink-0" aria-hidden="true">💜</span>
                    <div>
                        <strong class="text-[#1a1512]">Liên hệ &amp; đóng góp</strong>
                        <span class="text-[#6b5346]"> — góp ý nội dung, báo lỗi, hoặc ủng hộ duy trì website qua email bên dưới.</span>
                    </div>
                </li>
            </ul>
        </div>
        </div>

        <div class="rounded-2xl border border-[#e8e0d4] bg-white p-5 sm:p-6 lg:p-8 shadow-sm max-w-2xl">
            <p class="text-sm font-semibold text-[#4a2c11] mb-2">Email</p>
            <a href="mailto:{{ config('site.contact_email') }}" class="text-[#8b5e34] font-bold hover:underline break-all">{{ config('site.contact_email') }}</a>
            <a href="mailto:{{ config('site.contact_email') }}?subject=Hỗ%20trợ%20Kinh%20Học%20Phật%20Giáo" class="mt-4 inline-flex w-full items-center justify-center rounded-full bg-[#8b5e34] py-3.5 text-sm font-bold text-white hover:bg-[#6f4a2b] transition-colors">Mở ứng dụng thư</a>
        </div>
    </div>
</x-layouts.tool>
