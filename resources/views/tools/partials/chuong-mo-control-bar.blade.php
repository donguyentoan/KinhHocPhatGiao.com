@php
    $cmIntervals = $cmIntervals ?? [0, 1, 2, 3, 5, 10];
@endphp
<div class="rounded-xl bg-[#fff8f2] border border-[#f0e0d0] px-4 py-4">
    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-end sm:justify-between gap-4">
        <label class="flex flex-col gap-1.5 min-w-0">
            <span class="text-xs font-semibold uppercase tracking-wide text-[#6b5d52]">Thời gian lặp</span>
            <select class="cm-interval w-full sm:w-44 rounded-lg bg-white border border-[#e8d5c4] px-3 py-2.5 text-sm font-semibold text-[#1a1512] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#c9a77c]/40">
                @foreach ($cmIntervals as $s)
                    <option value="{{ $s }}">{{ $s }} giây</option>
                @endforeach
            </select>
        </label>
        <label class="flex items-center gap-3 cursor-pointer select-none sm:pb-0.5">
            <span class="text-sm font-medium text-[#4a2c11]">Lặp lại tự động</span>
            <span class="relative inline-flex h-8 w-14 shrink-0 items-center">
                <input type="checkbox" class="cm-repeat peer sr-only absolute inset-0 z-10 cursor-pointer opacity-0">
                <span class="pointer-events-none absolute inset-0 rounded-full bg-[#ddd5cc] transition-colors peer-checked:bg-[#c9a77c]"></span>
                <span class="pointer-events-none absolute left-1 top-1 h-6 w-6 rounded-full bg-white shadow transition-transform peer-checked:translate-x-6"></span>
            </span>
        </label>
    </div>
</div>
