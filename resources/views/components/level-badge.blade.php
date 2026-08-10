@props(['level' => null])

{{-- Lencana level prioritas: Tinggi / Sedang / Rendah. --}}
@php
    $style = match($level) {
        'Tinggi' => ['bg-emerald-50 text-emerald-700 ring-emerald-100', 'arrow-up'],
        'Sedang' => ['bg-amber-50 text-amber-700 ring-amber-100', 'minus'],
        'Rendah' => ['bg-red-50 text-red-700 ring-red-100', 'arrow-down'],
        default => null,
    };
@endphp

@if($style)
    <span {{ $attributes->class(['inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full ring-1 ring-inset', $style[0]]) }}>
        <i data-lucide="{{ $style[1] }}" class="h-3 w-3"></i>{{ $level }}
    </span>
@else
    <span {{ $attributes->class(['text-slate-300 text-xs']) }}>—</span>
@endif
