@extends('layouts.main')
@section('title', 'Dashboard Saya')

@section('content')
@php
    $sudahDinilai = $myUseCases->filter(fn ($uc) => $uc->penilaianPrioritas?->skor_prioritas !== null)->count();
    $masihIde = $perStatus['Ide'] ?? 0;
@endphp

<div class="space-y-6 ui-stagger">

    {{-- ── Hero ── --}}
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-brand-900 text-white rounded-3xl p-6 md:p-9 overflow-hidden shadow-lift">
        <div class="relative z-10 max-w-2xl space-y-3.5">
            <h1 class="text-2xl md:text-[2rem] font-black tracking-tight leading-tight">Halo, {{ auth()->user()->name }} 👋</h1>
            <p class="text-slate-300 text-sm leading-relaxed font-light">
                @if($total > 0)
                    Kamu sudah mengusulkan <strong class="text-white font-semibold">{{ $total }} use case AI</strong>.
                    Pantau status dan hasil penilaiannya di bawah ini.
                @else
                    Belum ada usulan dari kamu. Mulai dengan mengirimkan ide pemanfaatan AI pertamamu.
                @endif
            </p>
            <div class="pt-5">
                <a href="{{ route('user.create') }}"
                   class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-telkom-red hover:bg-brand-600 text-white rounded-xl text-xs font-bold shadow-brand transition-all duration-200 hover:-translate-y-px">
                    <i data-lucide="plus-circle" class="h-4 w-4"></i> Usulkan Use Case Baru
                </a>
            </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-[0.15] hidden md:block" aria-hidden="true">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 rounded-full border border-white/30"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full border border-brand-500/30"></div>
        </div>
    </section>

    {{-- ── Ringkasan ── --}}
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4" aria-label="Ringkasan usulan saya">
        @foreach([
            ['Total Usulan', $total, 'layers', 'bg-brand-50 text-telkom-red'],
            ['Sudah Dinilai', $sudahDinilai, 'badge-check', 'bg-emerald-50 text-emerald-600'],
            ['Masih Berstatus Ide', $masihIde, 'lightbulb', 'bg-amber-50 text-amber-600'],
        ] as [$label, $nilai, $icon, $tone])
            <article class="ui-card p-5 flex items-start gap-4">
                <span class="h-11 w-11 shrink-0 grid place-items-center rounded-2xl {{ $tone }}">
                    <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                </span>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ $label }}</p>
                    <p class="text-2xl font-black text-slate-800 leading-none mt-1.5 tnum">{{ $nilai }}</p>
                </div>
            </article>
        @endforeach
    </section>

    {{-- ── Tabel usulan ── --}}
    <div class="ui-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-sm font-extrabold text-slate-800">Status Usulan Saya</h2>
            @if($perStatus->isNotEmpty())
                <div class="flex flex-wrap gap-1.5">
                    @foreach($perStatus as $status => $jumlah)
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-slate-500 bg-slate-50 border border-slate-100 px-2.5 py-1 rounded-full">
                            {{ $status }} <span class="font-black text-slate-700 tnum">{{ $jumlah }}</span>
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="overflow-x-auto ui-scroll">
            <table class="w-full text-sm min-w-[46rem]">
                <thead class="bg-slate-50/80 text-[10px] uppercase tracking-wider text-slate-400">
                    <tr>
                        <th scope="col" class="text-left py-3 px-4">Kode</th>
                        <th scope="col" class="text-left py-3 px-4">Nama Use Case</th>
                        <th scope="col" class="text-left py-3 px-4">Kategori</th>
                        <th scope="col" class="text-left py-3 px-4">Status</th>
                        <th scope="col" class="text-left py-3 px-4">Skor Prioritas</th>
                        <th scope="col" class="text-right py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($myUseCases as $uc)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4">
                                <span class="inline-block font-bold text-[11px] text-telkom-red bg-brand-50 px-2 py-1 rounded-lg tnum">{{ $uc->kode }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-semibold text-slate-700 line-clamp-1">{{ $uc->nama_use_case }}</span>
                                <span class="block text-[11px] text-slate-400 mt-0.5 tnum">{{ $uc->created_at->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-xs">{{ $uc->kategori->nama_kategori ?? '-' }}</td>
                            <td class="py-3 px-4"><x-status-badge :status="$uc->status" /></td>
                            <td class="py-3 px-4">
                                @if($uc->penilaianPrioritas?->skor_prioritas !== null)
                                    <span class="inline-flex items-center gap-2">
                                        <span class="font-black text-slate-800 tnum">{{ $uc->penilaianPrioritas->skor_prioritas }}</span>
                                        <x-level-badge :level="$uc->penilaianPrioritas->level_prioritas" />
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-slate-400">
                                        <i data-lucide="clock" class="h-3 w-3"></i> Menunggu penilaian
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if($uc->status === 'Ide')
                                    <a href="{{ route('user.edit', $uc) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-600 hover:border-brand-200 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                                        <i data-lucide="edit-3" class="h-3.5 w-3.5"></i> Edit
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-slate-300"
                                          title="Usulan yang sudah diproses tidak dapat diubah">
                                        <i data-lucide="lock" class="h-3 w-3"></i> Terkunci
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state icon="folder-open"
                                               title="Belum ada usulan"
                                               text="Kamu belum mengusulkan use case apa pun. Kirim ide pertamamu sekarang.">
                                    <a href="{{ route('user.create') }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-telkom-red text-white text-xs font-bold hover:bg-brand-600 transition-colors">
                                        <i data-lucide="plus-circle" class="h-3.5 w-3.5"></i> Usulkan Use Case
                                    </a>
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
