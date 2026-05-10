<x-layouts.tool title="Sự kiện trong năm">
    <p class="text-[#6b5346] text-base max-w-3xl leading-relaxed mb-8">
        Lịch tham khảo các ngày lễ Phật giáo thường gặp (dương lịch gần đúng; ngày âm có thể lệch theo năm). Nên đối chiếu lịch chùa địa phương.
    </p>

    <div class="grid sm:grid-cols-2 gap-4 lg:gap-6">
        @foreach ([
            ['Rằm tháng Giêng', 'Ngày Nguyên Tiêu'],
            ['Rằm tháng Hai', 'Ngày sinh Đức Phật Đản (một số hệ phái)'],
            ['Rằm tháng Bảy', 'Vu Lan — báo hiếu cha mẹ'],
            ['Rằm tháng Mười', 'Lễ cúng ngày vía / tưởng niệm (tùy địa phương)'],
            ['Rằm tháng Mười Hai', 'Lễ cầu an cuối năm — chuẩn bị Tết Nguyên Đán'],
        ] as $row)
            <div class="flex gap-4 rounded-2xl border border-[#e8e0d4] bg-white p-4 sm:p-5 shadow-sm hover:border-[#dcc8b0] transition-colors">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-[#f3ebe0] border border-[#e0d5c8] text-[#8b5e34]">📿</div>
                <div class="min-w-0 flex-1">
                    <p class="font-bold text-[#1a1512] text-sm sm:text-base">{{ $row[0] }}</p>
                    <p class="text-sm text-[#6b5346] mt-1.5 leading-relaxed">{{ $row[1] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <p class="text-xs text-[#8a7d72] mt-8 max-w-3xl">Có thể mở rộng thành lịch đầy đủ theo năm và lưu trong cơ sở dữ liệu.</p>
</x-layouts.tool>
