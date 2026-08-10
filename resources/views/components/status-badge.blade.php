@props(['status' => null])

{{-- Lencana status use case: Ide / Direncanakan / Prototype / Implementasi. --}}
@php
    [$tone, $icon] = match($status) {
        'Ide' => ['bg-slate-100 text-slate-600 ring-slate-200/70', 'lightbulb'],
        'Direncanakan' => ['bg-sky-50 text-sky-700 ring-sky-100', 'calendar-clock'],
        'Prototype' => ['bg-violet-50 text-violet-700 ring-violet-100', 'flask-conical'],
        'Implementasi' => ['bg-emerald-50 text-emerald-700 ring-emerald-100', 'rocket'],
        default => ['bg-slate-100 text-slate-500 ring-slate-200/70', 'circle-dashed'],
    };
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full ring-1 ring-inset whitespace-nowrap', $tone]) }}>
    <i data-lucide="{{ $icon }}" class="h-3 w-3"></i>{{ $status ?: '—' }}
</span>
