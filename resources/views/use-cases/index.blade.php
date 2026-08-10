@extends('layouts.main')
@section('title', 'Daftar Use Case')

@section('content')
@php
    $adaFilter = request()->filled('search') || request()->filled('kategori_id') || request()->filled('status');
@endphp

<div class="space-y-6 ui-stagger" x-data="useCaseExport()">

    {{-- ── Judul halaman ── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Daftar Usulan Use Case AI</h1>
            <p class="text-slate-400 text-xs mt-1">Pantau, filter, dan telusuri seluruh ide dan proyek kecerdasan buatan.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button" x-show="!exportMode" @click="startExport()"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold shadow-xs transition-all duration-200">
                <i data-lucide="download" class="h-4 w-4"></i> Export Excel
            </button>
            <a href="{{ route('use-cases.create') }}"
               class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-telkom-red hover:bg-brand-600 text-white text-xs font-bold shadow-brand transition-all duration-200 hover:-translate-y-px">
                <i data-lucide="plus-circle" class="h-4 w-4"></i> Tambah Use Case
            </a>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <form method="GET" class="ui-card p-4 sm:p-5">
        <div class="flex flex-col lg:flex-row gap-4 lg:items-end">
            <div class="flex-1 min-w-0 space-y-1.5">
                <label for="filter-search" class="ui-label">Kata kunci</label>
                <div class="relative">
                    <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                    <input id="filter-search" type="search" name="search" value="{{ request('search') }}"
                           placeholder="Nama use case, pengusul, teknologi, atau kode…"
                           class="ui-field !pl-10 !h-9 !py-0">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex gap-3 lg:items-end">
                <div class="space-y-1.5 lg:w-44">
                    <label for="filter-kategori" class="ui-label">Kategori</label>
                    <select id="filter-kategori" name="kategori_id" class="ui-field !h-9 !py-0">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5 lg:w-40">
                    <label for="filter-status" class="ui-label">Status</label>
                    <select id="filter-status" name="status" class="ui-field !h-9 !py-0">
                        <option value="">Semua Status</option>
                        @foreach(['Ide', 'Direncanakan', 'Prototype', 'Implementasi'] as $status)
                            <option value="{{ $status }}" @selected(request('status') == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 sm:col-span-2">
                    <button type="submit"
                            class="flex-1 lg:flex-none inline-flex items-center justify-center gap-1.5 h-9 px-4 bg-emerald-700 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                        <i data-lucide="filter" class="h-3.5 w-3.5"></i> Terapkan
                    </button>
                    @if($adaFilter)
                        <a href="{{ route('use-cases.index') }}"
                           class="inline-flex items-center justify-center gap-1.5 h-9 px-4 border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-bold transition-colors">
                            <i data-lucide="x" class="h-3.5 w-3.5"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    {{-- ── Tabel ── --}}
    <div class="ui-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-3">
            <p class="text-xs font-semibold text-slate-500">
                Menampilkan <span class="font-bold text-slate-700 tnum">{{ $useCases->count() }}</span>
                dari <span class="font-bold text-slate-700 tnum">{{ $useCases->total() }}</span> use case
                @if($adaFilter)<span class="text-slate-400">(terfilter)</span>@endif
            </p>
        </div>

        {{-- Bilah aksi mode export --}}
        <div x-show="exportMode" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-5 py-3.5 border-b border-emerald-100 bg-emerald-50/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <p class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <i data-lucide="check-square" class="h-4 w-4 text-emerald-600"></i>
                <span x-text="selected.length"></span> use case dipilih
            </p>
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" @click="cancelExport()"
                        class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-bold hover:bg-slate-50 transition-colors">Batalkan</button>
                <button type="button" @click="toggleAll()"
                        class="px-3.5 py-2 rounded-xl border border-emerald-200 bg-white text-emerald-700 text-xs font-bold hover:bg-emerald-50 transition-colors"
                        x-text="allSelected ? 'Batalkan Pilih Semua' : 'Pilih Semua'"></button>
                <button type="button" @click="columnModal = true" :disabled="selected.length === 0"
                        class="px-3.5 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                    Lanjut Export
                </button>
            </div>
        </div>

        <div class="overflow-x-auto ui-scroll">
            <table class="w-full text-sm min-w-[56rem]">
                <thead class="bg-slate-50/80 text-[10px] uppercase tracking-wider text-slate-400">
                    <tr>
                        <th x-show="exportMode" x-cloak scope="col" class="text-center py-3 px-4 w-12">
                            <input type="checkbox" :checked="allSelected" @change="toggleAll()"
                                   aria-label="Pilih semua use case di halaman ini"
                                   class="ui-check rounded border-slate-300">
                        </th>
                        <th scope="col" class="text-left py-3 px-4">Kode</th>
                        <th scope="col" class="text-left py-3 px-4">Nama Use Case</th>
                        <th scope="col" class="text-left py-3 px-4">Kategori</th>
                        <th scope="col" class="text-left py-3 px-4">Status</th>
                        <th scope="col" class="text-left py-3 px-4">Diusulkan</th>
                        <th scope="col" class="text-right py-3 px-4">Skor</th>
                        <th scope="col" class="text-left py-3 px-4">Level</th>
                        <th scope="col" class="text-right py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($useCases as $useCase)
                        @php $level = $useCase->penilaianPrioritas->level_prioritas ?? null; @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td x-show="exportMode" x-cloak class="py-3 px-4 text-center">
                                <input type="checkbox" value="{{ $useCase->id }}" x-model.number="selected"
                                       aria-label="Pilih {{ $useCase->nama_use_case }}"
                                       class="ui-check rounded border-slate-300">
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-block font-bold text-[11px] text-telkom-red bg-brand-50 px-2 py-1 rounded-lg tnum">{{ $useCase->kode }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('use-cases.show', $useCase) }}" class="group block max-w-xs">
                                    <span class="font-semibold text-slate-700 group-hover:text-telkom-red transition-colors line-clamp-1">{{ $useCase->nama_use_case }}</span>
                                    <span class="block text-[11px] text-slate-400 mt-0.5 truncate">oleh {{ $useCase->pengusul }}</span>
                                </a>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-xs">{{ $useCase->kategori->nama_kategori ?? '-' }}</td>
                            <td class="py-3 px-4"><x-status-badge :status="$useCase->status" /></td>
                            <td class="py-3 px-4 text-slate-400 text-xs whitespace-nowrap tnum">{{ $useCase->created_at->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4 text-right font-black text-slate-800 tnum">{{ $useCase->penilaianPrioritas->skor_prioritas ?? '—' }}</td>
                            <td class="py-3 px-4"><x-level-badge :level="$level" /></td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('use-cases.show', $useCase) }}" title="Lihat detail"
                                       class="h-8 w-8 grid place-items-center rounded-lg text-slate-400 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                        <span class="sr-only">Detail {{ $useCase->nama_use_case }}</span>
                                    </a>
                                    <a href="{{ route('use-cases.edit', $useCase) }}" title="Ubah"
                                       class="h-8 w-8 grid place-items-center rounded-lg text-slate-400 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                                        <i data-lucide="edit-3" class="h-4 w-4"></i>
                                        <span class="sr-only">Edit {{ $useCase->nama_use_case }}</span>
                                    </a>
                                    <form action="{{ route('use-cases.destroy', $useCase) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus use case ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="h-8 w-8 grid place-items-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            <span class="sr-only">Hapus {{ $useCase->nama_use_case }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td :colspan="exportMode ? 9 : 8" colspan="8">
                                @if($adaFilter)
                                    <x-empty-state icon="search-x"
                                                   title="Tidak ada hasil yang cocok"
                                                   text="Coba ubah kata kunci atau kosongkan filter kategori dan status.">
                                        <a href="{{ route('use-cases.index') }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition-colors">
                                            <i data-lucide="rotate-ccw" class="h-3.5 w-3.5"></i> Reset filter
                                        </a>
                                    </x-empty-state>
                                @else
                                    <x-empty-state icon="folder-open"
                                                   title="Belum ada use case"
                                                   text="Mulai dengan menambahkan usulan use case AI pertama.">
                                        <a href="{{ route('use-cases.create') }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-telkom-red text-white text-xs font-bold hover:bg-brand-600 transition-colors">
                                            <i data-lucide="plus-circle" class="h-3.5 w-3.5"></i> Tambah Use Case
                                        </a>
                                    </x-empty-state>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($useCases->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/40">{{ $useCases->links() }}</div>
        @endif
    </div>

    {{-- ── Modal pilih kolom export ── --}}
    <div x-show="columnModal" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         @keydown.escape.window="columnModal = false"
         role="dialog" aria-modal="true" aria-labelledby="judul-modal-export">
        <div x-show="columnModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-3 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             @click.outside="columnModal = false"
             class="bg-white rounded-3xl shadow-lift w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
            <form method="GET" action="{{ route('use-cases.export') }}" @submit="finishExport()" class="flex flex-col min-h-0">
                <div class="p-6 border-b border-slate-100 flex items-start gap-3.5">
                    <span class="h-10 w-10 shrink-0 grid place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="file-spreadsheet" class="h-5 w-5"></i>
                    </span>
                    <div>
                        <h2 id="judul-modal-export" class="text-lg font-extrabold text-slate-800">Pilih Kolom Export</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Tentukan informasi yang akan dimasukkan ke file Excel.</p>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-2.5 overflow-y-auto ui-scroll">
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
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 hover:border-slate-200 cursor-pointer transition-colors has-[:checked]:bg-emerald-50/60 has-[:checked]:border-emerald-200">
                            <input type="checkbox" name="columns[]" value="{{ $value }}" x-model="columns" class="ui-check rounded border-slate-300">
                            <span class="text-xs font-semibold text-slate-600">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2">
                    <p class="text-[11px] text-slate-400 hidden sm:block">
                        <span x-text="columns.length"></span> kolom dipilih
                    </p>
                    <div class="flex gap-2 ml-auto">
                        <button type="button" @click="columnModal = false"
                                class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-xs font-bold hover:bg-slate-100 transition-colors">Batalkan</button>
                        <button type="submit" :disabled="columns.length === 0"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                            <i data-lucide="download" class="h-3.5 w-3.5"></i>
                            Export <span x-text="selected.length"></span> Data
                        </button>
                    </div>
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
