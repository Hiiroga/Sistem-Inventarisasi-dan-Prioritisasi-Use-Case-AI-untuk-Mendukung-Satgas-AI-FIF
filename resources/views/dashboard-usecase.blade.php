@extends('layouts.main')
@section('title', 'Dashboard Use Case AI')

@section('content')
<div class="space-y-6">

    <!-- Hero banner -->
    <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 text-white rounded-3xl p-6 md:p-8 overflow-hidden shadow-xl">
        <div class="relative z-10 max-w-2xl space-y-3">
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-500/20 text-red-300 border border-red-500/30">
                <i data-lucide="zap" class="h-3.5 w-3.5"></i> Satgas AI FIF — Dashboard Utama
            </span>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight">Welcome back, Satgas AI! 👋</h1>
            <p class="text-slate-300 text-sm leading-relaxed font-light">
                Semua sistem berjalan optimal. Terdapat <strong class="text-white">{{ $totalUseCase }} Use Case AI</strong>
                terdaftar untuk dilakukan penilaian prioritas, manajemen risiko etika, dan tata kelola terintegrasi.
            </p>
            <div class="pt-2 flex flex-wrap gap-2.5">
                <a href="{{ route('use-cases.create') }}" class="px-5 py-2.5 bg-telkom-red hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                    + Tambah Use Case
                </a>
                <a href="{{ route('use-cases.index') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/15 text-white border border-white/20 rounded-xl text-xs font-bold transition-all">
                    Lihat Semua Data
                </a>
            </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-15 hidden md:block">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 rounded-full border border-white/30"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full border border-red-500/20"></div>
        </div>
    </div>

    <!-- KPI cards -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-telkom-red text-white rounded-2xl p-5 shadow-md space-y-1">
            <span class="text-[11px] font-bold uppercase tracking-wider opacity-85">Total Use Case</span>
            <div class="text-3xl font-black">{{ $totalUseCase }}</div>
            <p class="text-[11px] opacity-80 border-t border-white/20 pt-2 mt-2">✓ Terdaftar dalam sistem</p>
        </div>
        <div class="bg-telkom-grey text-white rounded-2xl p-5 shadow-md space-y-1">
            <span class="text-[11px] font-bold uppercase tracking-wider opacity-85">Rata-rata Dampak</span>
            <div class="text-3xl font-black">{{ $rataDampak ?? '-' }} <span class="text-sm font-medium opacity-80">/ 5</span></div>
            <p class="text-[11px] opacity-80 border-t border-white/20 pt-2 mt-2">↗ Dampak & Kebermanfaatan</p>
        </div>
        <div class="bg-telkom-dark text-white rounded-2xl p-5 shadow-md space-y-1 col-span-2 lg:col-span-1">
            <span class="text-[11px] font-bold uppercase tracking-wider opacity-85">Rata-rata Risiko Etika</span>
            <div class="text-3xl font-black">{{ $rataRisiko ?? '-' }}</div>
            <p class="text-[11px] opacity-80 border-t border-white/20 pt-2 mt-2">⚠ Perlu perhatian mitigasi</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-xs lg:col-span-2 space-y-3">
            <h3 class="text-sm font-extrabold text-slate-800">Use Case per Kategori</h3>
            <div class="h-56"><canvas id="chartKategori"></canvas></div>
        </div>
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-xs space-y-3">
            <h3 class="text-sm font-extrabold text-slate-800">Distribusi Status</h3>
            <div class="h-56"><canvas id="chartStatus"></canvas></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-xs space-y-3">
            <h3 class="text-sm font-extrabold text-slate-800">Level Prioritas</h3>
            <div class="h-48"><canvas id="chartLevel"></canvas></div>
        </div>

        <!-- Top 5 -->
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-xs lg:col-span-2 space-y-3">
            <h3 class="text-sm font-extrabold text-slate-800 flex items-center gap-1.5">
                <i data-lucide="award" class="h-4 w-4 text-telkom-red"></i> Top 5 Use Case — Skor Prioritas Tertinggi
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <th class="py-2 pr-3">Kode</th>
                            <th class="py-2 pr-3">Nama Use Case</th>
                            <th class="py-2 pr-3">Kategori</th>
                            <th class="py-2 pr-3">Skor</th>
                            <th class="py-2">Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($top5 as $uc)
                        <tr class="border-b border-slate-50">
                            <td class="py-2.5 pr-3 font-semibold text-telkom-red">{{ $uc->kode }}</td>
                            <td class="py-2.5 pr-3">{{ $uc->nama_use_case }}</td>
                            <td class="py-2.5 pr-3 text-slate-500">{{ $uc->kategori->nama_kategori ?? '-' }}</td>
                            <td class="py-2.5 pr-3 font-bold">{{ $uc->penilaianPrioritas->skor_prioritas }}</td>
                            <td class="py-2.5">{{ $uc->penilaianPrioritas->level_prioritas }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-slate-400 py-6">Belum ada use case dengan skor prioritas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const kategoriLabels = @json($perKategori->pluck('nama_kategori'));
    const kategoriData = @json($perKategori->pluck('use_cases_count'));
    new Chart(document.getElementById('chartKategori'), {
        type: 'bar',
        data: { labels: kategoriLabels, datasets: [{ label: 'Jumlah', data: kategoriData, backgroundColor: '#E52521', borderRadius: 6 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    const statusLabels = @json($perStatus->keys());
    const statusData = @json($perStatus->values());
    new Chart(document.getElementById('chartStatus'), {
        type: 'pie',
        data: { labels: statusLabels, datasets: [{ data: statusData, backgroundColor: ['#E52521', '#717476', '#1E293B', '#C8102E'] }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const levelLabels = @json($perLevel->keys());
    const levelData = @json($perLevel->values());
    new Chart(document.getElementById('chartLevel'), {
        type: 'pie',
        data: { labels: levelLabels, datasets: [{ data: levelData, backgroundColor: ['#16A34A', '#EAB308', '#DC2626'] }] },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush
@endsection