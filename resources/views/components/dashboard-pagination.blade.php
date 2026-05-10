@props([
    'paginator',
    'pageName' => 'page',
])

@if($paginator->hasPages())
    @php
        $p = $paginator;
        $curr = $p->currentPage();
        $last = $p->lastPage();
        $win = 1;
        $start = max(1, $curr - $win);
        $end = min($last, $curr + $win);
        $btnBase = 'min-h-[2.25rem] inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-lg border transition-colors';
        $btnIdle = 'border-[#8b5e34]/25 bg-white/70 text-[#4a2c11] hover:bg-[#8b5e34]/10';
        $btnActive = 'border-[#8b5e34] bg-[#8b5e34] text-white shadow-sm';
        $btnGhost = 'border-[#8b5e34]/15 bg-white/40 text-[#a08b7a] cursor-not-allowed';
    @endphp
    <nav class="mt-6 pt-4 border-t border-[#8b5e34]/10" aria-label="Phân trang">
        <div class="flex flex-wrap items-center justify-center gap-2">
            @if($p->onFirstPage())
                <span class="{{ $btnBase }} {{ $btnGhost }}" aria-disabled="true">Trước</span>
            @else
                <button type="button" wire:click="previousPage('{{ $pageName }}')" class="{{ $btnBase }} {{ $btnIdle }}">Trước</button>
            @endif

            @if($start > 1)
                <button type="button" wire:click="gotoPage(1, '{{ $pageName }}')" class="{{ $btnBase }} {{ $btnIdle }}">1</button>
                @if($start > 2)
                    <span class="px-1 text-xs text-[#8b5e34]/70" aria-hidden="true">…</span>
                @endif
            @endif

            @for($page = $start; $page <= $end; $page++)
                @if($page === $curr)
                    <span class="{{ $btnBase }} {{ $btnActive }}" aria-current="page">{{ $page }}</span>
                @else
                    <button type="button" wire:click="gotoPage({{ $page }}, '{{ $pageName }}')" class="{{ $btnBase }} {{ $btnIdle }}">{{ $page }}</button>
                @endif
            @endfor

            @if($end < $last)
                @if($end < $last - 1)
                    <span class="px-1 text-xs text-[#8b5e34]/70" aria-hidden="true">…</span>
                @endif
                <button type="button" wire:click="gotoPage({{ $last }}, '{{ $pageName }}')" class="{{ $btnBase }} {{ $btnIdle }}">{{ $last }}</button>
            @endif

            @if($p->hasMorePages())
                <button type="button" wire:click="nextPage('{{ $pageName }}')" class="{{ $btnBase }} {{ $btnIdle }}">Sau</button>
            @else
                <span class="{{ $btnBase }} {{ $btnGhost }}" aria-disabled="true">Sau</span>
            @endif
        </div>
        <p class="text-center text-[10px] text-[#8b5e34]/80 mt-2 tabular-nums">
            Hiển thị {{ $p->firstItem() }}–{{ $p->lastItem() }} trong {{ $p->total() }} mục
        </p>
    </nav>
@endif
