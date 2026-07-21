@extends('layouts.main')
@section('title', 'Detail Use Case')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('use-cases.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-telkom-red hover:underline">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Daftar Use Case
        </a>
        <div class="flex gap-2">
            <a href="{{ route('use-cases.edit', $useCase) }}" class="inline-flex items-center gap-1 bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-200 text-xs font-bold px-3 py-1.5 rounded-lg transition-all">
                <i data-lucide="edit-3" class="h-3.5 w-3.5"></i> Edit
            </a>
            <form action="{{ route('use-cases.destroy', $useCase) }}" method="POST" onsubmit="return confirm('Yakin hapus use case ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-telkom-red border border-red-200 text-xs font-bold px-3 py-1.5 rounded-lg transition-all">
                    <i data-lucide="trash-2" class="h-3.5 w-3.5"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: main info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-xs space-y-6">
                <div class="space-y-2 border-b border-slate-50 pb-5">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-telkom-red bg-red-50 px-2.5 py-0.5 rounded">{{ $useCase->kode }}</span>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $useCase->kategori->nama_kategori ?? '-' }}</span>
                    </div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">{{ $useCase->nama_use_case }}</h1>
                    <div class="flex flex-wrap items-center gap-3 pt-1 text-xs font-semibold text-slate-500">
                        <span class="flex items-center gap-1"><i data-lucide="user" class="h-4 w-4 text-red-400"></i> Pengusul: <strong class="text-slate-700">{{ $useCase->pengusul }}</strong></span>
                        <span class="h-3.5 w-px bg-slate-200"></span>
                        <span class="flex items-center gap-1"><i data-lucide="cpu" class="h-4 w-4 text-red-400"></i> Teknologi: <strong class="text-slate-700">{{ $useCase->teknologi_ai ?: '-' }}</strong></span>
                    </div>
                </div>

                <div class="space-y-5 text-sm">
                    <div class="space-y-1.5">
                        <h3 class="font-extrabold text-slate-800 text-xs uppercase tracking-wider flex items-center gap-1.5">
                            <i data-lucide="file-text" class="h-4 w-4 text-red-400"></i> Deskripsi Singkat
                        </h3>
                        <p class="text-slate-600 leading-relaxed font-light">{{ $useCase->deskripsi }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <h3 class="font-extrabold text-slate-800 text-xs uppercase tracking-wider flex items-center gap-1.5">
                            <i data-lucide="alert-triangle" class="h-4 w-4 text-red-400"></i> Latar Belakang Masalah
                        </h3>
                        <p class="text-slate-600 leading-relaxed font-light">{{ $useCase->latar_belakang_masalah ?: '-' }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <h3 class="font-extrabold text-slate-800 text-xs uppercase tracking-wider flex items-center gap-1.5">
                            <i data-lucide="file-check" class="h-4 w-4 text-red-400"></i> Tujuan & Target Dampak
                        </h3>
                        <p class="text-slate-600 leading-relaxed font-light">{{ $useCase->tujuan_use_case ?: '-' }}</p>
                    </div>
                </div>

                <!-- Kartu Etika: pakai field asli risiko_etika_details kita -->
                @if($useCase->risikoEtikaDetail)
                <div class="border-t border-slate-100 pt-5 space-y-4">
                    <h3 class="font-extrabold text-slate-800 text-sm tracking-tight flex items-center gap-2">
                        <i data-lucide="shield-alert" class="h-4.5 w-4.5 text-telkom-maroon"></i> Aspek Etika & Mitigasi Risiko AI
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1"><i data-lucide="lock" class="h-3.5 w-3.5 text-blue-500"></i> Risiko Privasi</span>
                            <p class="text-xs text-slate-600 font-light leading-relaxed">{{ $useCase->risikoEtikaDetail->risiko_privasi ?? '-' }}</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1"><i data-lucide="scale" class="h-3.5 w-3.5 text-amber-500"></i> Risiko Bias</span>
                            <p class="text-xs text-slate-600 font-light leading-relaxed">{{ $useCase->risikoEtikaDetail->risiko_bias ?? '-' }}</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1"><i data-lucide="heart-handshake" class="h-3.5 w-3.5 text-green-500"></i> Rekomendasi Mitigasi</span>
                            <p class="text-xs text-slate-600 font-light leading-relaxed">{{ $useCase->risikoEtikaDetail->rekomendasi_mitigasi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-50 text-xs">
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100 space-y-1">
                        <span class="font-bold text-slate-400 uppercase tracking-wider block">Unit Terkait</span>
                        <span class="font-extrabold text-slate-700 text-sm">{{ $useCase->unit_terkait }}</span>
                    </div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100 space-y-1">
                        <span class="font-bold text-slate-400 uppercase tracking-wider block">Target Pengguna</span>
                        <span class="font-extrabold text-slate-700 text-sm">{{ $useCase->target_pengguna ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: skor prioritas -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-xs text-center space-y-5">
                <h3 class="font-extrabold text-slate-800 text-sm border-b border-slate-50 pb-2">Skor Prioritas</h3>

                @if($useCase->penilaianPrioritas?->skor_prioritas !== null)
                <div class="py-2">
                    <div class="text-6xl font-black text-telkom-red tracking-tight">{{ $useCase->penilaianPrioritas->skor_prioritas }}</div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mt-1">{{ $useCase->penilaianPrioritas->level_prioritas }}</span>
                </div>

                <div class="space-y-3 text-xs font-semibold text-left">
                    @foreach([
                        'dampak' => 'Dampak', 'kelayakan' => 'Kelayakan', 'ketersediaan_data' => 'Ketersediaan Data',
                        'kompleksitas_teknis' => 'Kompleksitas Teknis', 'risiko_etika_skor' => 'Risiko Etika',
                    ] as $field => $label)
                    <div class="space-y-1">
                        <div class="flex justify-between text-slate-500">
                            <span>{{ $label }}</span>
                            <span class="text-slate-800">{{ $useCase->penilaianPrioritas->$field ?? '-' }} / 5</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-telkom-red rounded-full" style="width: {{ ($useCase->penilaianPrioritas->$field ?? 0) * 20 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-slate-400 py-6">Belum dinilai. Klik Edit untuk mengisi skor prioritas.</p>
                @endif
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-xs space-y-4">
                <h3 class="font-extrabold text-slate-800 text-sm border-b border-slate-50 pb-2">Histori Status</h3>
                @forelse($useCase->statusHistories as $history)
                    <div class="border-l-2 border-red-200 pl-3 text-xs space-y-1">
                        <p class="font-bold text-slate-700">
                            {{ $history->status_sebelumnya ?: 'Baru' }} → {{ $history->status_baru }}
                        </p>
                        <p class="text-slate-500">{{ $history->catatan ?: 'Tanpa catatan.' }}</p>
                        <p class="text-[10px] text-slate-400">
                            {{ $history->changedBy?->name ?? 'Sistem' }} · {{ $history->created_at->translatedFormat('d M Y H:i') }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">Belum ada histori status.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
