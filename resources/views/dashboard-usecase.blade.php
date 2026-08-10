@extends('layouts.main')
@section('title', 'Dashboard Use Case AI')

@section('content')
<div class="space-y-6 ui-stagger">

    {{-- ── Hero ── --}}
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-brand-900 text-white rounded-3xl p-6 md:p-9 overflow-hidden shadow-lift">
        <div class="relative z-10 max-w-2xl space-y-3.5">
            <h1 class="text-2xl md:text-[2rem] font-black tracking-tight leading-tight">Selamat datang kembali, Satgas AI! 👋</h1>
            <p class="text-slate-300 text-sm leading-relaxed font-light">
                Terdapat <strong class="text-white font-semibold">{{ $totalUseCase }} use case AI</strong>
                terdaftar untuk dilakukan penilaian prioritas, manajemen risiko etika, dan tata kelola terintegrasi.
            </p>
            <div class="pt-5 flex flex-wrap gap-2.5">
                <a href="{{ route('use-cases.create') }}"
                   class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-telkom-red hover:bg-brand-600 text-white rounded-xl text-xs font-bold shadow-brand transition-all duration-200 hover:-translate-y-px">
                    <i data-lucide="plus-circle" class="h-4 w-4"></i> Tambah Use Case
                </a>
                <a href="{{ route('use-cases.index') }}"
                   class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-xl text-xs font-bold transition-all duration-200">
                    Lihat Semua Data <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-[0.15] hidden md:block" aria-hidden="true">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 rounded-full border border-white/30"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full border border-brand-500/30"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] rounded-full border border-white/15"></div>
        </div>
    </section>

    {{-- ── Kartu ringkasan ── --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" aria-label="Ringkasan angka">
        @foreach([
            [
                'label' => 'Total Use Case', 'value' => $totalUseCase, 'suffix' => null,
                'icon' => 'layers', 'note' => 'Terdaftar dalam sistem', 'noteIcon' => 'check',
                'wrap' => 'bg-gradient-to-br from-telkom-red to-brand-600 shadow-brand',
            ],
            [
                'label' => 'Rata-rata Dampak', 'value' => $rataDampak ?? '-', 'suffix' => '/ 5',
                'icon' => 'trending-up', 'note' => 'Dampak & kebermanfaatan', 'noteIcon' => 'arrow-up-right',
                'wrap' => 'bg-gradient-to-br from-slate-500 to-telkom-grey shadow-card',
            ],
            [
                'label' => 'Rata-rata Risiko Etika', 'value' => $rataRisiko ?? '-', 'suffix' => '/ 5',
                'icon' => 'shield-alert', 'note' => 'Perlu perhatian mitigasi', 'noteIcon' => 'alert-triangle',
                'wrap' => 'bg-gradient-to-br from-slate-800 to-telkom-dark shadow-card',
            ],
        ] as $kpi)
            <article class="relative overflow-hidden text-white rounded-2xl p-5 {{ $kpi['wrap'] }}">
                <div class="absolute -right-5 -top-5 h-24 w-24 rounded-full bg-white/10" aria-hidden="true"></div>
                <div class="relative flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold uppercase tracking-wider opacity-80">{{ $kpi['label'] }}</p>
                        <p class="mt-1.5 text-[2rem] leading-none font-black tnum">
                            {{ $kpi['value'] }}@if($kpi['suffix'])<span class="text-sm font-semibold opacity-70 ml-1">{{ $kpi['suffix'] }}</span>@endif
                        </p>
                    </div>
                    <span class="h-9 w-9 shrink-0 grid place-items-center rounded-xl bg-white/15 border border-white/20">
                        <i data-lucide="{{ $kpi['icon'] }}" class="h-4.5 w-4.5"></i>
                    </span>
                </div>
                <p class="relative mt-4 pt-3 border-t border-white/20 text-[11px] opacity-85 flex items-center gap-1.5">
                    <i data-lucide="{{ $kpi['noteIcon'] }}" class="h-3.5 w-3.5"></i> {{ $kpi['note'] }}
                </p>
            </article>
        @endforeach
    </section>

    {{-- ── Grafik baris pertama ── --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="ui-card p-5 lg:col-span-2">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-800">Use Case per Kategori</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Sebaran usulan pada {{ $perKategori->count() }} kategori.</p>
                </div>
                <span class="h-8 w-8 shrink-0 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                </span>
            </div>
            @if($perKategori->sum('use_cases_count') > 0)
                <div class="h-60"><canvas id="chartKategori"></canvas></div>
            @else
                <x-empty-state icon="bar-chart-3" text="Belum ada use case untuk ditampilkan." class="h-60" />
            @endif
        </div>

        <div class="ui-card p-5">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-800">Distribusi Status</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Tahapan pengerjaan use case.</p>
                </div>
                <span class="h-8 w-8 shrink-0 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="pie-chart" class="h-4 w-4"></i>
                </span>
            </div>
            @if($perStatus->sum() > 0)
                <div class="h-60"><canvas id="chartStatus"></canvas></div>
            @else
                <x-empty-state icon="pie-chart" text="Belum ada data status." class="h-60" />
            @endif
        </div>
    </section>

    {{-- ── Grafik baris kedua + Top 5 ── --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="ui-card p-5">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-800">Level Prioritas</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Hasil kalkulasi skor prioritas.</p>
                </div>
                <span class="h-8 w-8 shrink-0 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="gauge" class="h-4 w-4"></i>
                </span>
            </div>
            @if($perLevel->sum() > 0)
                <div class="h-52"><canvas id="chartLevel"></canvas></div>
            @else
                <x-empty-state icon="gauge" text="Belum ada use case yang dinilai." class="h-52" />
            @endif
        </div>

        <div class="ui-card p-5 lg:col-span-2">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-800 flex items-center gap-1.5">
                        <i data-lucide="award" class="h-4 w-4 text-telkom-red"></i> Top 5 Use Case
                    </h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Peringkat berdasarkan skor prioritas tertinggi.</p>
                </div>
                <a href="{{ route('use-cases.index') }}" class="shrink-0 text-[11px] font-bold text-telkom-red hover:underline underline-offset-2 whitespace-nowrap">
                    Lihat semua
                </a>
            </div>

            <div class="overflow-x-auto ui-scroll -mx-1 px-1">
                <table class="w-full text-sm min-w-[34rem]">
                    <thead>
                        <tr class="text-left text-[10px] uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <th scope="col" class="py-2.5 pr-3 w-10">#</th>
                            <th scope="col" class="py-2.5 pr-3">Nama Use Case</th>
                            <th scope="col" class="py-2.5 pr-3">Kategori</th>
                            <th scope="col" class="py-2.5 pr-3 text-right">Skor</th>
                            <th scope="col" class="py-2.5 text-right">Level</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($top5 as $uc)
                            @php
                                $rank = $loop->iteration;
                                $rankStyle = match($rank) {
                                    1 => 'bg-amber-100 text-amber-700',
                                    2 => 'bg-slate-200 text-slate-600',
                                    3 => 'bg-orange-100 text-orange-700',
                                    default => 'bg-slate-50 text-slate-400',
                                };
                                $level = $uc->penilaianPrioritas->level_prioritas;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 pr-3">
                                    <span class="h-6 w-6 grid place-items-center rounded-lg text-[11px] font-black tnum {{ $rankStyle }}">{{ $rank }}</span>
                                </td>
                                <td class="py-3 pr-3">
                                    <a href="{{ route('use-cases.show', $uc) }}" class="group block">
                                        <span class="font-semibold text-slate-700 group-hover:text-telkom-red transition-colors">{{ $uc->nama_use_case }}</span>
                                        <span class="block text-[11px] font-semibold text-telkom-red/70 tnum">{{ $uc->kode }}</span>
                                    </a>
                                </td>
                                <td class="py-3 pr-3 text-slate-500 text-xs">{{ $uc->kategori->nama_kategori ?? '-' }}</td>
                                <td class="py-3 pr-3 text-right font-black text-slate-800 tnum">{{ $uc->penilaianPrioritas->skor_prioritas }}</td>
                                <td class="py-3 text-right">
                                    <x-level-badge :level="$level" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10">
                                    <x-empty-state icon="inbox" text="Belum ada use case dengan skor prioritas." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(() => {
    // ── Gaya bersama untuk seluruh grafik ──────────────────────────────
    Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#94A3B8';

    const tooltipStyle = {
        backgroundColor: '#0F172A',
        titleFont: { weight: '700', size: 12 },
        bodyFont: { size: 11 },
        padding: 10,
        cornerRadius: 8,
        displayColors: false,
    };

    const donutLegend = {
        position: 'bottom',
        labels: { boxWidth: 8, boxHeight: 8, usePointStyle: true, pointStyle: 'circle', padding: 14, color: '#64748B' },
    };

    // Warna dipetakan per label agar tidak tertukar saat urutan data berubah.
    const STATUS_COLORS = {
        'Ide': '#94A3B8',
        'Direncanakan': '#E52521',
        'Prototype': '#C8102E',
        'Implementasi': '#1E293B',
    };
    const LEVEL_COLORS = {
        'Tinggi': '#16A34A',
        'Sedang': '#EAB308',
        'Rendah': '#DC2626',
    };
    const colorsFor = (labels, map) => labels.map((l, i) => map[l] ?? ['#E52521', '#717476', '#1E293B', '#C8102E'][i % 4]);

    // ── Use Case per Kategori ─────────────────────────────────────────
    const elKategori = document.getElementById('chartKategori');
    if (elKategori) {
        const ctx = elKategori.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, elKategori.parentElement.clientHeight || 240);
        gradient.addColorStop(0, '#E52521');
        gradient.addColorStop(1, '#F97169');

        new Chart(elKategori, {
            type: 'bar',
            data: {
                labels: @json($perKategori->pluck('nama_kategori')),
                datasets: [{
                    label: 'Jumlah use case',
                    data: @json($perKategori->pluck('use_cases_count')),
                    backgroundColor: gradient,
                    hoverBackgroundColor: '#C8102E',
                    borderRadius: 8,
                    maxBarThickness: 44,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: '#F1F5F9' },
                        border: { display: false },
                    },
                },
            },
        });
    }

    // ── Distribusi Status ─────────────────────────────────────────────
    const elStatus = document.getElementById('chartStatus');
    if (elStatus) {
        const labels = @json($perStatus->keys());
        new Chart(elStatus, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: @json($perStatus->values()),
                    backgroundColor: colorsFor(labels, STATUS_COLORS),
                    borderColor: '#FFFFFF',
                    borderWidth: 3,
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: { legend: donutLegend, tooltip: tooltipStyle },
            },
        });
    }

    // ── Level Prioritas ───────────────────────────────────────────────
    const elLevel = document.getElementById('chartLevel');
    if (elLevel) {
        const labels = @json($perLevel->keys());
        new Chart(elLevel, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: @json($perLevel->values()),
                    backgroundColor: colorsFor(labels, LEVEL_COLORS),
                    borderColor: '#FFFFFF',
                    borderWidth: 3,
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: { legend: donutLegend, tooltip: tooltipStyle },
            },
        });
    }
})();
</script>
@endpush
@endsection
