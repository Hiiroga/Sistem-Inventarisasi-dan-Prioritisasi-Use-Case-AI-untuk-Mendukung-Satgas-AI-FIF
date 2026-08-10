@extends('layouts.main')
@section('title', 'Detail Use Case')

@section('content')
@php
    $penilaian = $useCase->penilaianPrioritas;
    $skor = $penilaian?->skor_prioritas;

    // Rentang skor teoretis: (6 parameter positif × 1..5) − risiko etika − kompleksitas.
    $skorMin = -4;
    $skorMax = 28;
    $skorPersen = $skor === null ? 0 : max(0, min(100, round((($skor - $skorMin) / ($skorMax - $skorMin)) * 100)));

    $warnaLevel = match($penilaian?->level_prioritas) {
        'Tinggi' => ['#16A34A', 'text-emerald-600'],
        'Sedang' => ['#EAB308', 'text-amber-500'],
        'Rendah' => ['#DC2626', 'text-red-600'],
        default => ['#E52521', 'text-telkom-red'],
    };

    // Warna untuk tingkat risiko etika (Rendah / Sedang / Tinggi).
    $toneRisiko = fn (?string $nilai) => match($nilai) {
        'Rendah' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'Sedang' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'Tinggi' => 'bg-red-50 text-red-700 ring-red-100',
        default => 'bg-slate-100 text-slate-500 ring-slate-200/70',
    };
@endphp

<div class="space-y-6 ui-stagger">

    {{-- ── Bilah navigasi & aksi ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('use-cases.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-telkom-red transition-colors">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Daftar Use Case
        </a>
        <div class="flex gap-2 no-print">
            <a href="{{ route('use-cases.edit', $useCase) }}"
               class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition-colors">
                <i data-lucide="edit-3" class="h-3.5 w-3.5"></i> Edit
            </a>
            <form action="{{ route('use-cases.destroy', $useCase) }}" method="POST" onsubmit="return confirm('Yakin hapus use case ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-white hover:bg-red-50 text-telkom-red border border-red-200 text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition-colors">
                    <i data-lucide="trash-2" class="h-3.5 w-3.5"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Kolom kiri: informasi utama ── --}}
        <div class="lg:col-span-2 space-y-6">
            <article class="ui-card p-6 sm:p-7 space-y-7">
                <header class="space-y-3 border-b border-slate-100 pb-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[11px] font-bold text-telkom-red bg-brand-50 px-2.5 py-1 rounded-lg tnum">{{ $useCase->kode }}</span>
                        <span class="text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600">{{ $useCase->kategori->nama_kategori ?? '-' }}</span>
                        <x-status-badge :status="$useCase->status" />
                    </div>

                    <h1 class="text-2xl sm:text-[1.75rem] font-black text-slate-900 tracking-tight leading-tight">{{ $useCase->nama_use_case }}</h1>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-1 text-xs text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="user" class="h-4 w-4 text-brand-400"></i>
                            Pengusul: <strong class="font-semibold text-slate-700">{{ $useCase->pengusul }}</strong>
                        </span>
                        <span class="hidden sm:block h-3.5 w-px bg-slate-200"></span>
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="cpu" class="h-4 w-4 text-brand-400"></i>
                            Teknologi: <strong class="font-semibold text-slate-700">{{ $useCase->teknologi_ai ?: '-' }}</strong>
                        </span>
                        <span class="hidden sm:block h-3.5 w-px bg-slate-200"></span>
                        <span class="flex items-center gap-1.5 tnum">
                            <i data-lucide="calendar" class="h-4 w-4 text-brand-400"></i>
                            {{ $useCase->created_at->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </header>

                <div class="space-y-6">
                    @foreach([
                        ['file-text', 'Deskripsi Singkat', $useCase->deskripsi],
                        ['alert-triangle', 'Latar Belakang Masalah', $useCase->latar_belakang_masalah],
                        ['target', 'Tujuan & Target Dampak', $useCase->tujuan_use_case],
                    ] as [$icon, $judul, $isi])
                        <section class="space-y-2">
                            <h2 class="font-extrabold text-slate-800 text-[11px] uppercase tracking-[0.1em] flex items-center gap-1.5">
                                <i data-lucide="{{ $icon }}" class="h-4 w-4 text-brand-400"></i> {{ $judul }}
                            </h2>
                            <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $isi ?: '—' }}</p>
                        </section>
                    @endforeach
                </div>

                {{-- Aspek etika --}}
                @if($useCase->risikoEtikaDetail)
                    @php $risiko = $useCase->risikoEtikaDetail; @endphp
                    <section class="border-t border-slate-100 pt-6 space-y-4">
                        <h2 class="font-extrabold text-slate-800 text-sm tracking-tight flex items-center gap-2">
                            <i data-lucide="shield-alert" class="h-4.5 w-4.5 text-telkom-maroon"></i> Aspek Etika &amp; Mitigasi Risiko AI
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
                            @foreach([
                                ['lock', 'Risiko Privasi', $risiko->risiko_privasi],
                                ['scale', 'Risiko Bias', $risiko->risiko_bias],
                                ['unplug', 'Ketergantungan AI', $risiko->risiko_ketergantungan_ai],
                                ['circle-alert', 'Kesalahan Output', $risiko->risiko_kesalahan_output],
                            ] as [$icon, $judul, $nilai])
                                <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-100 space-y-2">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                                        <i data-lucide="{{ $icon }}" class="h-3.5 w-3.5"></i> {{ $judul }}
                                    </span>
                                    <span class="inline-flex text-[11px] font-bold px-2.5 py-1 rounded-full ring-1 ring-inset {{ $toneRisiko($nilai) }}">
                                        {{ $nilai ?: '—' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-100 space-y-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Data Pribadi</span>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ $risiko->menggunakan_data_pribadi ? 'Menggunakan data pribadi' : 'Tidak menggunakan data pribadi' }}
                                    @if($risiko->jenis_data_sensitif)
                                        — <span class="text-slate-500">{{ $risiko->jenis_data_sensitif }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-100 space-y-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kontrol Wajib</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach([
                                        ['Validasi manusia', $risiko->perlu_validasi_manusia],
                                        ['Persetujuan pengguna', $risiko->perlu_persetujuan_pengguna],
                                    ] as [$labelKontrol, $aktif])
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-lg {{ $aktif ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                            <i data-lucide="{{ $aktif ? 'check' : 'minus' }}" class="h-3 w-3"></i> {{ $labelKontrol }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-emerald-50/70 to-white p-4 rounded-2xl border border-emerald-100 space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 flex items-center gap-1.5">
                                <i data-lucide="heart-handshake" class="h-3.5 w-3.5"></i> Rekomendasi Mitigasi
                            </span>
                            <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $risiko->rekomendasi_mitigasi ?: '—' }}</p>
                        </div>
                    </section>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-6 border-t border-slate-100">
                    @foreach([
                        ['building-2', 'Unit Terkait', $useCase->unit_terkait],
                        ['users', 'Target Pengguna', $useCase->target_pengguna],
                    ] as [$icon, $judul, $isi])
                        <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-100 flex items-start gap-3">
                            <span class="h-8 w-8 shrink-0 grid place-items-center rounded-lg bg-white border border-slate-100 text-slate-400">
                                <i data-lucide="{{ $icon }}" class="h-4 w-4"></i>
                            </span>
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $judul }}</span>
                                <span class="font-bold text-slate-700 text-sm">{{ $isi ?: '—' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>

        {{-- ── Kolom kanan: skor & histori ── --}}
        <div class="space-y-6">
            <section class="ui-card p-6 space-y-5">
                <h2 class="font-extrabold text-slate-800 text-sm border-b border-slate-100 pb-3">Skor Prioritas</h2>

                @if($skor !== null)
                    {{-- Cincin skor --}}
                    <div class="flex flex-col items-center">
                        <div class="relative h-36 w-36 rounded-full grid place-items-center"
                             style="background: conic-gradient({{ $warnaLevel[0] }} {{ $skorPersen * 3.6 }}deg, #F1F5F9 0deg);"
                             role="img" aria-label="Skor prioritas {{ $skor }}, level {{ $penilaian->level_prioritas }}">
                            <div class="h-28 w-28 rounded-full bg-white grid place-items-center shadow-inner">
                                <span class="text-4xl font-black tracking-tight tnum {{ $warnaLevel[1] }}">{{ $skor }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Skor</span>
                            </div>
                        </div>
                        <div class="mt-3"><x-level-badge :level="$penilaian->level_prioritas" /></div>
                    </div>

                    {{-- Rincian parameter --}}
                    <div class="space-y-3.5 text-xs pt-1">
                        @foreach([
                            'dampak' => 'Dampak',
                            'kelayakan' => 'Kelayakan',
                            'ketersediaan_data' => 'Ketersediaan Data',
                            'kesiapan_sdm' => 'Kesiapan SDM',
                            'kesiapan_infrastruktur' => 'Kesiapan Infrastruktur',
                            'urgensi' => 'Urgensi',
                            'risiko_etika_skor' => 'Risiko Etika',
                            'kompleksitas_teknis' => 'Kompleksitas Teknis',
                        ] as $field => $label)
                            @php
                                $nilai = $penilaian->$field;
                                // Risiko & kompleksitas mengurangi skor, jadi ditandai berbeda.
                                $pengurang = in_array($field, ['risiko_etika_skor', 'kompleksitas_teknis'], true);
                            @endphp
                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center gap-2">
                                    <span class="font-semibold text-slate-500 flex items-center gap-1.5">
                                        @if($pengurang)
                                            <i data-lucide="minus-circle" class="h-3 w-3 text-red-400"></i>
                                        @endif
                                        {{ $label }}
                                    </span>
                                    <span class="font-bold text-slate-800 tnum shrink-0">{{ $nilai ?? '—' }} <span class="font-medium text-slate-300">/ 5</span></span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $pengurang ? 'bg-red-400' : 'bg-telkom-red' }}"
                                         style="width: {{ ($nilai ?? 0) * 20 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($penilaian->estimasi_waktu || $penilaian->estimasi_biaya)
                        <div class="grid grid-cols-2 gap-2.5 pt-4 border-t border-slate-100">
                            <div class="bg-slate-50/70 rounded-xl p-3 border border-slate-100">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Estimasi Waktu</span>
                                <span class="text-xs font-bold text-slate-700">{{ $penilaian->estimasi_waktu ?: '—' }}</span>
                            </div>
                            <div class="bg-slate-50/70 rounded-xl p-3 border border-slate-100">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Estimasi Biaya</span>
                                <span class="text-xs font-bold text-slate-700">{{ $penilaian->estimasi_biaya ?: '—' }}</span>
                            </div>
                        </div>
                    @endif
                @else
                    <x-empty-state icon="gauge" title="Belum dinilai" text="Klik tombol Edit untuk mengisi skor prioritas use case ini.">
                        <a href="{{ route('use-cases.edit', $useCase) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-telkom-red text-white text-xs font-bold hover:bg-brand-600 transition-colors">
                            <i data-lucide="edit-3" class="h-3.5 w-3.5"></i> Isi Penilaian
                        </a>
                    </x-empty-state>
                @endif
            </section>

            {{-- Histori status --}}
            <section class="ui-card p-6 space-y-4">
                <h2 class="font-extrabold text-slate-800 text-sm border-b border-slate-100 pb-3">Histori Status</h2>

                @forelse($useCase->statusHistories as $history)
                    <div class="relative pl-6 pb-4 last:pb-0
                                before:absolute before:left-[5px] before:top-4 before:bottom-0 before:w-px before:bg-slate-100 last:before:hidden">
                        <span class="absolute left-0 top-1.5 h-2.5 w-2.5 rounded-full bg-telkom-red ring-4 ring-brand-50"></span>
                        <p class="text-xs font-bold text-slate-700 flex flex-wrap items-center gap-1.5">
                            <span class="text-slate-400">{{ $history->status_sebelumnya ?: 'Baru' }}</span>
                            <i data-lucide="arrow-right" class="h-3 w-3 text-slate-300"></i>
                            <span>{{ $history->status_baru }}</span>
                        </p>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $history->catatan ?: 'Tanpa catatan.' }}</p>
                        <p class="text-[10px] text-slate-400 mt-1.5 tnum">
                            {{ $history->changedBy?->name ?? 'Sistem' }} · {{ $history->created_at->translatedFormat('d M Y H:i') }}
                        </p>
                    </div>
                @empty
                    <x-empty-state compact icon="history" text="Belum ada histori status." />
                @endforelse
            </section>
        </div>
    </div>
</div>
@endsection
