@extends('layouts.main')
@section('title', 'Daftar Use Case')

@section('content')
<div class="space-y-6" x-data="useCaseExport()">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Daftar Usulan Use Case AI</h1>
            <p class="text-slate-400 text-xs mt-0.5">Pantau, filter, dan telusuri seluruh ide dan proyek kecerdasan buatan.</p>
        </div>
        <div class="flex gap-2">
            <button type="button" x-show="!exportMode" @click="startExport()" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                <i data-lucide="download" class="h-4 w-4"></i> Export Excel
            </button>
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
        <div x-show="exportMode" x-transition class="p-4 border-b border-slate-100 bg-green-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <p class="text-sm font-bold text-slate-700"><span x-text="selected.length"></span> use case dipilih</p>
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" @click="cancelExport()" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-bold hover:bg-slate-50">Batalkan</button>
                <button type="button" @click="toggleAll()" class="px-3.5 py-2 rounded-xl border border-green-200 bg-white text-green-700 text-xs font-bold hover:bg-green-50" x-text="allSelected ? 'Batalkan Pilih Semua' : 'Pilih Semua'"></button>
                <button type="button" @click="columnModal = true" :disabled="selected.length === 0" class="px-3.5 py-2 rounded-xl bg-green-600 text-white text-xs font-bold hover:bg-green-700 disabled:opacity-40 disabled:cursor-not-allowed">Lanjut Export</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                    <tr>
                        <th x-show="exportMode" class="text-center py-3 px-4 w-12">
                            <input type="checkbox" :checked="allSelected" @change="toggleAll()" aria-label="Pilih semua use case di halaman ini" class="h-4 w-4 rounded border-slate-300 text-green-600 focus:ring-green-500">
                        </th>
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
                        <td x-show="exportMode" class="py-3 px-4 text-center">
                            <input type="checkbox" value="{{ $useCase->id }}" x-model.number="selected" aria-label="Pilih {{ $useCase->nama_use_case }}" class="h-4 w-4 rounded border-slate-300 text-green-600 focus:ring-green-500">
                        </td>
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
                    <tr><td :colspan="exportMode ? 9 : 8" class="text-center text-slate-400 py-10">Belum ada data use case.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-50">{{ $useCases->links() }}</div>
    </div>

    <div x-show="columnModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50" @keydown.escape.window="columnModal = false">
        <div x-show="columnModal" x-transition @click.outside="columnModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">
            <form method="GET" action="{{ route('use-cases.export') }}" @submit="finishExport()">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-extrabold text-slate-800">Pilih Kolom Export</h2>
                    <p class="text-xs text-slate-400 mt-1">Pilih informasi yang akan dimasukkan ke file Excel.</p>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="use_case_ids[]" :value="id">
                    </template>
                    @foreach([
                        'kode' => 'Kode',
                        'nama_use_case' => 'Nama Use Case',
                        'kategori' => 'Kategori',
                        'status' => 'Status',
                        'deskripsi' => 'Deskripsi',
                        'pengusul' => 'Pengusul',
                        'teknologi_ai' => 'Teknologi AI',
                        'skor_prioritas' => 'Skor Prioritas',
                        'level_prioritas' => 'Level Prioritas',
                    ] as $value => $label)
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="{{ $value }}" x-model="columns" class="h-4 w-4 rounded border-slate-300 text-green-600 focus:ring-green-500">
                        <span class="text-xs font-semibold text-slate-600">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <div class="p-4 bg-slate-50 flex justify-end gap-2">
                    <button type="button" @click="columnModal = false" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-bold">Batalkan</button>
                    <button type="submit" :disabled="columns.length === 0" class="px-4 py-2.5 rounded-xl bg-green-600 text-white text-xs font-bold hover:bg-green-700 disabled:opacity-40">
                        Export <span x-text="selected.length"></span> Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function useCaseExport() {
        return {
            exportMode: false,
            columnModal: false,
            selected: [],
            pageIds: @json($useCases->pluck('id')->values()),
            columns: ['kode', 'nama_use_case', 'kategori', 'status', 'skor_prioritas', 'level_prioritas'],
            get allSelected() {
                return this.pageIds.length > 0 && this.pageIds.every(id => this.selected.includes(id));
            },
            startExport() {
                this.exportMode = true;
            },
            toggleAll() {
                this.selected = this.allSelected ? [] : [...this.pageIds];
            },
            cancelExport() {
                this.exportMode = false;
                this.columnModal = false;
                this.selected = [];
            },
            finishExport() {
                setTimeout(() => this.cancelExport(), 500);
            },
        };
    }
</script>
@endpush
