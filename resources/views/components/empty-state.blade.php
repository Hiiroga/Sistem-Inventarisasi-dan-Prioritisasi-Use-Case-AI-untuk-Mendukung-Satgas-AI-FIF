@props([
    'icon' => 'inbox',
    'title' => null,
    'text' => null,
    'compact' => false,
])

{{--
    Tampilan "belum ada data" yang konsisten di seluruh halaman.
    Contoh: <x-empty-state icon="search-x" title="Tidak ditemukan" text="Coba kata kunci lain." />
--}}
<div {{ $attributes->class(['flex flex-col items-center justify-center text-center', $compact ? 'py-6' : 'py-10']) }}>
    <span @class([
        'grid place-items-center rounded-2xl bg-slate-50 text-slate-300 border border-slate-100',
        'h-10 w-10' => $compact,
        'h-14 w-14' => ! $compact,
    ])>
        <i data-lucide="{{ $icon }}" @class(['h-5 w-5' => $compact, 'h-6 w-6' => ! $compact])></i>
    </span>

    @if($title)
        <p class="mt-3 text-sm font-bold text-slate-600">{{ $title }}</p>
    @endif

    @if($text)
        <p class="mt-1 text-xs text-slate-400 max-w-xs leading-relaxed">{{ $text }}</p>
    @endif

    @if(! $slot->isEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
