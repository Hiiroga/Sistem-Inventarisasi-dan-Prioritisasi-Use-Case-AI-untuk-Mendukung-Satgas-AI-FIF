<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Use Case</label>
            <input type="text" name="nama_use_case" value="{{ old('nama_use_case', $useCase->nama_use_case ?? '') }}" required
                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
        </div>

        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</label>
            <textarea name="deskripsi" rows="3" required
                      class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">{{ old('deskripsi', $useCase->deskripsi ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Latar Belakang Masalah</label>
                <textarea name="latar_belakang_masalah" rows="3"
                          class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">{{ old('latar_belakang_masalah', $useCase->latar_belakang_masalah ?? '') }}</textarea>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tujuan Use Case</label>
                <textarea name="tujuan_use_case" rows="3"
                          class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">{{ old('tujuan_use_case', $useCase->tujuan_use_case ?? '') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengusul</label>
                <input type="text" name="pengusul" value="{{ old('pengusul', $useCase->pengusul ?? '') }}" required
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Unit Terkait</label>
                <input type="text" name="unit_terkait" value="{{ old('unit_terkait', $useCase->unit_terkait ?? '') }}" required
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Target Pengguna</label>
                <input type="text" name="target_pengguna" value="{{ old('target_pengguna', $useCase->target_pengguna ?? '') }}"
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Teknologi AI</label>
                <input type="text" name="teknologi_ai" value="{{ old('teknologi_ai', $useCase->teknologi_ai ?? '') }}"
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</label>
                <select name="kategori_id" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(old('kategori_id', $useCase->kategori_id ?? '') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status</label>
                <select name="status" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
                    @foreach(['Ide', 'Direncanakan', 'Prototype', 'Implementasi'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $useCase->status ?? 'Ide') == $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @isset($useCase)
    @php $penilaian = $useCase->penilaianPrioritas; @endphp
    <div class="space-y-5">
        <div class="bg-gradient-to-tr from-telkom-red to-telkom-maroon text-white rounded-2xl p-5 shadow-lg space-y-3">
            <h3 class="text-xs uppercase font-extrabold tracking-widest text-red-100 flex items-center gap-1.5">
                <i data-lucide="activity" class="h-4 w-4"></i> Penilaian Prioritas
            </h3>
            @if($penilaian?->skor_prioritas !== null)
            <div class="text-center py-2">
                <div class="text-5xl font-black">{{ $penilaian->skor_prioritas }}</div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-red-200 mt-1">{{ $penilaian->level_prioritas }}</div>
            </div>
            @else
            <p class="text-xs text-red-100">Isi field di bawah untuk menghitung skor prioritas.</p>
            @endif
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-3">
            @foreach([
                'dampak' => 'Dampak', 'kelayakan' => 'Kelayakan', 'ketersediaan_data' => 'Ketersediaan Data',
                'kesiapan_sdm' => 'Kesiapan SDM', 'kesiapan_infrastruktur' => 'Kesiapan Infrastruktur',
                'urgensi' => 'Urgensi', 'risiko_etika_skor' => 'Risiko Etika', 'kompleksitas_teknis' => 'Kompleksitas Teknis',
            ] as $field => $label)
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $label }} (1-5)</label>
                <select name="{{ $field }}" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    <option value="">-</option>
                    @for($i=1;$i<=5;$i++)
                        <option value="{{ $i }}" @selected(old($field, $penilaian->$field ?? '') == $i)>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            @endforeach

            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Estimasi Waktu</label>
                <select name="estimasi_waktu" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    <option value="">-</option>
                    @foreach(['1 bulan', '3 bulan', '6 bulan'] as $w)
                        <option value="{{ $w }}" @selected(old('estimasi_waktu', $penilaian->estimasi_waktu ?? '') == $w)>{{ $w }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Estimasi Biaya</label>
                <select name="estimasi_biaya" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    <option value="">-</option>
                    @foreach(['Rendah', 'Sedang', 'Tinggi'] as $b)
                        <option value="{{ $b }}" @selected(old('estimasi_biaya', $penilaian->estimasi_biaya ?? '') == $b)>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endisset
</div>