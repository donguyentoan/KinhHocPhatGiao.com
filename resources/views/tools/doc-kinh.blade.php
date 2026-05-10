@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.tool title="Đọc kinh" :show-page-heading="false">
    <h1 class="sr-only">Đọc kinh</h1>

    <div class="-mx-4 sm:-mx-6 lg:-mx-8 -mt-8 lg:-mt-10 mb-8">
        <section class="relative min-h-[200px] md:min-h-[260px] flex flex-col items-center justify-center overflow-hidden rounded-b-[1.75rem] md:rounded-b-[2rem]">
            <div class="absolute inset-0 bg-cover bg-center scale-105" style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80');" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/35 to-amber-900/30" aria-hidden="true"></div>

            <div class="relative z-10 flex w-full max-w-7xl flex-col items-center justify-center px-4 py-10 md:py-12">
                <div class="inline-flex items-center rounded-full bg-black/35 p-1.5 shadow-lg backdrop-blur-md ring-1 ring-white/20">
                    <span class="rounded-full bg-white px-5 py-2.5 text-sm font-bold text-[#1a1512] shadow-sm md:px-7 md:text-base">
                        Tụng kinh
                    </span>
                    <a href="{{ route('tools.show', 'ngoi-thien') }}" class="rounded-full px-5 py-2.5 text-sm font-semibold text-white/95 hover:bg-white/10 md:px-7 md:text-base">
                        Ngồi thiền
                    </a>
                </div>
                <a href="#danh-sach-kinh" class="absolute right-4 top-4 flex h-11 w-11 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-sm hover:bg-white/30 md:right-8 md:top-6" title="Xuống danh sách" aria-label="Xuống danh sách kinh">
                    <i class="fa-solid fa-book-open text-lg" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </div>

    <div id="danh-sach-kinh" class="scroll-mt-28 space-y-4">
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#a08b7a]" aria-hidden="true"></i>
            <input
                type="search"
                id="doc-kinh-search"
                class="w-full rounded-2xl border border-[#e5dec9] bg-[#f0ebe3] py-3.5 pl-11 pr-4 text-sm text-[#1a1512] placeholder:text-[#8a7d72] shadow-inner focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/25"
                placeholder="Tìm kiếm bài kinh"
                autocomplete="off"
                aria-label="Tìm kiếm bài kinh"
            >
        </div>

        <div class="overflow-hidden rounded-2xl border border-[#e5dec9] bg-white shadow-sm">
            @forelse ($scriptures as $scripture)
                @php
                    $catName = $scripture->category?->name ?? 'Kinh điển';
                    $badge = mb_strtoupper($catName, 'UTF-8');
                    if (Str::contains(Str::lower($catName), 'chú')) {
                        $badge = 'CHÚ';
                    } elseif (Str::contains(Str::lower($catName), 'địa tạng')) {
                        $badge = 'KINH ĐỊA TẠNG';
                    } elseif (Str::contains(Str::lower($catName), 'kinh')) {
                        $badge = 'KINH';
                    }
                    $thumb = filled($scripture->image_url) ? $scripture->image_url : 'https://images.unsplash.com/photo-1602615571099-86a1d2807bcd?w=200&h=200&fit=crop&q=80';
                    $searchBlob = Str::lower($scripture->title . ' ' . $catName);
                    $readUrl = route('scriptures.read', $scripture);
                    $hasPdf = filled($scripture->content_file_path) && Str::endsWith(Str::lower((string) $scripture->content_file_path), '.pdf');
                @endphp
                <article
                    class="doc-kinh-row flex items-stretch gap-3 border-b border-[#efe8dc] px-3 py-3 last:border-b-0 sm:gap-4 sm:px-4 sm:py-4"
                    data-search="{{ e($searchBlob) }}"
                >
                    <a href="{{ $readUrl }}" class="shrink-0 self-center">
                        <img src="{{ $thumb }}" alt="" class="h-16 w-16 rounded-xl object-cover shadow-sm ring-1 ring-black/5 sm:h-[4.5rem] sm:w-[4.5rem]">
                    </a>
                    <div class="min-w-0 flex-1 self-center">
                        <a href="{{ $readUrl }}" class="block text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/40 rounded-lg">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#9a8b7d] sm:text-[11px]">{{ $badge }}</p>
                            <h2 class="mt-0.5 text-sm font-bold leading-snug text-[#1a1512] sm:text-base">{{ $scripture->title }}</h2>
                        </a>
                    </div>
                    <div class="flex shrink-0 items-center gap-0.5 self-center">
                        <details class="group relative">
                            <summary class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-full text-[#6b5346] hover:bg-[#f5f0e8] [&::-webkit-details-marker]:hidden">
                                <span class="sr-only">Tùy chọn cho {{ $scripture->title }}</span>
                                <i class="fa-solid fa-ellipsis-vertical" aria-hidden="true"></i>
                            </summary>
                            <div class="absolute right-0 top-full z-20 mt-1 min-w-[10rem] rounded-xl border border-[#e5dec9] bg-white py-1 shadow-lg">
                                <a href="{{ $readUrl }}" class="block px-4 py-2 text-sm text-[#4a2c11] hover:bg-[#faf6f0]">Đọc / tụng kinh</a>
                                @if($hasPdf)
                                    <a href="{{ route('scriptures.pdf', $scripture) }}" target="_blank" rel="noopener noreferrer" class="block px-4 py-2 text-sm text-[#4a2c11] hover:bg-[#faf6f0]">Mở PDF</a>
                                @endif
                            </div>
                        </details>
                    </div>
                </article>
            @empty
                <p class="px-4 py-10 text-center text-sm text-[#6b5346]">Chưa có bài kinh trong hệ thống. Vui lòng thêm từ Dashboard.</p>
            @endforelse
        </div>
    </div>

    <script>
        (function () {
            var input = document.getElementById('doc-kinh-search');
            if (!input) return;
            input.addEventListener('input', function () {
                var q = (input.value || '').trim().toLowerCase();
                document.querySelectorAll('.doc-kinh-row').forEach(function (row) {
                    var hay = (row.getAttribute('data-search') || '').toLowerCase();
                    row.classList.toggle('hidden', q.length > 0 && hay.indexOf(q) === -1);
                });
            });
        })();
    </script>
</x-layouts.tool>
