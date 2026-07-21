@extends('layouts.main')
@section('title', 'Daftar Use Case')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Daftar Usulan Use Case AI</h1>
            <p class="text-slate-400 text-xs mt-0.5">Pantau, filter, dan telusuri seluruh ide dan proyek kecerdasan buatan.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('use-cases.export') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                <i data-lucide="download" class="h-4 w-4"></i> Export Excel
            </a>
            <a href="{{ route('use-cases.create') }}" class="px-5 py-2.5 rounded-xl bg-telkom-red text-white hover:bg-red-700 text-sm font-bold shadow-md transition-all flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="h-4.5 w-4.5"></i> Usulkan Use Case
            </a>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="relative w-full md:max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kata kunci, pengusul, teknologi..."
                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 pl-10 text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red transition-all">
            <i data-lucide="search" class="absolute left-3.5 top-3 h-4 w-4 text-slate-400"></i>
        </div>
        <div class="flex flex-wrap w-full md:w-auto items-center gap-2.5">
            <select name="kategori_id" class="bg-slate-50 border border-slate-100 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-500 cursor-pointer focus:outline-none">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
            <select name="status" class="bg-slate-50 border border-slate-100 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-500 cursor-pointer focus:outline-none">
                <option value="">Semua Status</option>
                @foreach(['Ide', 'Direncanakan', 'Prototype', 'Implementasi'] as $status)
                    <option value="{{ $status }}" @selected(request('status') == $status)>{{ $status }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-telkom-red text-white rounded-xl text-xs font-bold hover:bg-red-700 transition-all">Filter</button>
        </div>
    </form>

    <!-- Tabel -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="text-left py-3 px-4">Kode</th>
                        <th class="text-left py-3 px-4">Nama Use Case</th>
                        <th class="text-left py-3 px-4">Kategori</th>
                        <th class="text-left py-3 px-4">Status</th>
                        <th class="text-left py-3 px-4">Diusulkan</th>
                        <th class="text-left py-3 px-4">Skor</th>
                        <th class="text-left py-3 px-4">Level</th>
                        <th class="text-left py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($useCases as $useCase)
                    @php $level = $useCase->penilaianPrioritas->level_prioritas ?? null; @endphp
                    <tr class="hover:bg-slate-50 transition-all">
                        <td class="py-3 px-4 font-semibold text-telkom-red">{{ $useCase->kode }}</td>
                        <td class="py-3 px-4 font-medium text-slate-700">{{ $useCase->nama_use_case }}</td>
                        <td class="py-3 px-4 text-slate-500">{{ $useCase->kategori->nama_kategori ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-600">{{ $useCase->status }}</span>
                        </td>
                        <td class="py-3 px-4 text-slate-400 text-xs whitespace-nowrap">{{ $useCase->created_at->translatedFormat('d M Y') }}</td>
                        <td class="py-3 px-4 font-bold">{{ $useCase->penilaianPrioritas->skor_prioritas ?? '-' }}</td>
                        <td class="py-3 px-4">
                            @if($level)
                                @php
                                    $badgeColor = match($level) {
                                        'Tinggi' => 'bg-green-50 text-green-700',
                                        'Sedang' => 'bg-amber-50 text-amber-700',
                                        default => 'bg-red-50 text-red-700',
                                    };
                                @endphp
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $badgeColor }}">{{ $level }}</span>
                            @else
                                <span class="text-slate-300 text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-1.5">
                                <a href="{{ route('use-cases.show', $useCase) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-telkom-red" title="Detail">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </a>
                                <a href="{{ route('use-cases.edit', $useCase) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-telkom-red" title="Edit">
                                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                                </a>
                                <form action="{{ route('use-cases.destroy', $useCase) }}" method="POST" onsubmit="return confirm('Yakin hapus use case ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600" title="Hapus">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-slate-400 py-10">Belum ada data use case.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-50">{{ $useCases->links() }}</div>
    </div>
</div>
@endsection