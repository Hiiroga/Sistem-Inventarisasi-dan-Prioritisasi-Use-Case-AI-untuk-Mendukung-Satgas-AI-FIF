@extends('layouts.main')
@section('title', 'Dashboard Saya')

@section('content')
<div class="space-y-6">
    <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 text-white rounded-3xl p-6 md:p-8 shadow-xl">
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-500/20 text-red-300 border border-red-500/30">
            <i data-lucide="user" class="h-3.5 w-3.5"></i> Halaman Pengusul
        </span>
        <h1 class="text-2xl md:text-3xl font-black tracking-tight mt-3">Halo, {{ auth()->user()->name }} 👋</h1>
        <p class="text-slate-300 text-sm mt-2">Kamu sudah mengusulkan <strong class="text-white">{{ $total }}</strong> use case AI.</p>
        <a href="{{ route('user.create') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-telkom-red hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
            + Usulkan Use Case Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-50">
            <h3 class="text-sm font-extrabold text-slate-800">Status Usulan Saya</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="text-left py-3 px-4">Kode</th>
                        <th class="text-left py-3 px-4">Nama Use Case</th>
                        <th class="text-left py-3 px-4">Kategori</th>
                        <th class="text-left py-3 px-4">Status</th>
                        <th class="text-left py-3 px-4">Skor Prioritas</th>
                        <th class="text-left py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($myUseCases as $uc)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-semibold text-telkom-red">{{ $uc->kode }}</td>
                        <td class="py-3 px-4">{{ $uc->nama_use_case }}</td>
                        <td class="py-3 px-4 text-slate-500">{{ $uc->kategori->nama_kategori ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-600">{{ $uc->status }}</span>
                        </td>
                        <td class="py-3 px-4">
                            @if($uc->status === 'Ide')
                                <a href="{{ route('user.edit', $uc) }}" class="text-xs font-bold text-telkom-red hover:underline">Edit</a>
                            @else
                                <span class="text-xs text-slate-300">Terkunci</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($uc->penilaianPrioritas?->skor_prioritas !== null)
                                {{ $uc->penilaianPrioritas->skor_prioritas }} ({{ $uc->penilaianPrioritas->level_prioritas }})
                            @else
                                <span class="text-slate-300 text-xs">Belum dinilai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-slate-400 py-10">Kamu belum mengusulkan use case apapun.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
