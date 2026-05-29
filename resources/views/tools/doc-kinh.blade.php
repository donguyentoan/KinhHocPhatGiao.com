@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.tool title="Đọc kinh" :show-page-heading="false">
    <h1 class="sr-only">Đọc kinh</h1>

    <div class="mb-8 sm:mb-10">
        <section
            class="relative overflow-hidden rounded-[1.5rem] md:rounded-[1.75rem] border border-[#e5dec9] bg-[#faf6f0] shadow-[0_20px_50px_-12px_rgba(74,44,17,0.12),0_0_0_1px_rgba(255,255,255,0.7)_inset] ring-1 ring-[#d4a373]/15"
        >
            <div class="relative min-h-[210px] md:min-h-[270px]">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80');" aria-hidden="true"></div>
                {{-- Lớp phủ ấm, tránh vệt đen; đọc được chữ kem ở giữa --}}
                <div
                    class="absolute inset-0 bg-gradient-to-b from-[#f9f3e6]/55 via-[#4a2c11]/20 to-[#3d2914]/65"
                    aria-hidden="true"
                ></div>
                <div
                    class="absolute inset-0 bg-gradient-to-t from-[#faf6f0]/25 via-transparent to-[#fff9f0]/15"
                    aria-hidden="true"
                ></div>

                <div class="relative z-10 flex min-h-[210px] flex-col items-center justify-center px-4 py-10 md:min-h-[270px] md:py-12">
                    <p class="mb-4 text-center text-xs font-semibold uppercase tracking-[0.25em] text-[#faf6f0]/90 drop-shadow-sm md:text-[13px]">
                        Thư viện kinh điển
                    </p>
                    <div
                        class="inline-flex max-w-full flex-wrap items-center justify-center gap-0.5 rounded-full border border-[#e5dec9]/90 bg-[#fffcf7]/95 p-1 shadow-[0_12px_40px_-8px_rgba(45,30,18,0.25)] backdrop-blur-md"
                        role="tablist"
                        aria-label="Chế độ tu tập"
                    >
                        <span
                            class="rounded-full bg-[#8b5e34] px-4 py-2 text-sm font-bold text-white shadow-md shadow-[#4a2c11]/20 sm:px-5 sm:py-2.5 md:px-8 md:py-3 md:text-base"
                            aria-current="page"
                        >
                            Tụng kinh
                        </span>
                        <a
                            href="{{ route('tools.show', 'ngoi-thien') }}"
                            class="rounded-full px-4 py-2 text-sm font-semibold text-[#4a2c11] transition-colors hover:bg-[#f5ebe0] sm:px-5 sm:py-2.5 md:px-8 md:py-3 md:text-base"
                        >
                            Ngồi thiền
                        </a>
                    </div>
                    <a
                        href="#danh-sach-kinh"
                        class="absolute right-3 top-3 flex h-11 w-11 items-center justify-center rounded-full border-2 border-[#faf6f0]/80 bg-[#fffcf7]/95 text-[#8b5e34] shadow-md backdrop-blur-sm transition-all hover:border-[#8b5e34]/40 hover:bg-white hover:text-[#6f4a2b] hover:shadow-lg md:right-5 md:top-5 md:h-12 md:w-12"
                        title="Xuống danh sách"
                        aria-label="Xuống danh sách kinh"
                    >
                        <i class="fa-solid fa-book-open text-base md:text-lg" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <div id="danh-sach-kinh" class="scroll-mt-28 space-y-4">
        <form method="get" action="{{ route('tools.show', 'doc-kinh') }}#danh-sach-kinh" class="relative">
            @if(isset($activeCategory) && $activeCategory)
                <input type="hidden" name="category" value="{{ $activeCategory->id }}">
            @endif
            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#a08b7a]" aria-hidden="true"></i>
            <input
                type="search"
                name="q"
                id="doc-kinh-search"
                value="{{ $searchQuery ?? '' }}"
                class="w-full rounded-2xl border border-[#e5dec9] bg-[#f0ebe3] py-3.5 pl-11 pr-4 text-sm text-[#1a1512] placeholder:text-[#8a7d72] shadow-inner focus:border-[#8b5e34] focus:outline-none focus:ring-2 focus:ring-[#8b5e34]/25"
                placeholder="Tìm kiếm bài kinh (theo tên hoặc thể loại)"
                autocomplete="off"
                aria-label="Tìm kiếm bài kinh"
                maxlength="200"
            >
        </form>

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
                    $thumb = $scripture->resolvedImageUrl() ?: 'https://images.unsplash.com/photo-1602615571099-86a1d2807bcd?w=200&h=200&fit=crop&q=80';
                    $readUrl = route('scriptures.read', $scripture);
                    $hasPdf = filled($scripture->content_file_path) && Str::endsWith(Str::lower((string) $scripture->content_file_path), '.pdf');
                @endphp
                <article
                    class="flex items-stretch gap-3 border-b border-[#efe8dc] px-3 py-3 last:border-b-0 sm:gap-4 sm:px-4 sm:py-4"
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
                <p class="px-4 py-10 text-center text-sm text-[#6b5346]">Chưa có bài kinh trong hệ thống.</p>
            @endforelse
        </div>

        <x-tool-pagination :paginator="$scriptures" />
    </div>
</x-layouts.tool>
