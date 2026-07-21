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

        @isset($useCase)
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Catatan Perubahan Status</label>
            <textarea name="catatan_status" rows="2" placeholder="Wajib diisi bila status berubah agar keputusan dapat diaudit."
                      class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">{{ old('catatan_status') }}</textarea>
        </div>
        @endisset
    </div>

    @isset($useCase)
    @php $penilaian = $useCase->penilaianPrioritas; @endphp
    <div class="space-y-5" x-data="{ mode: 'manual' }">
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

        <!-- Toggle Manual vs Otomatis -->
        <div class="grid grid-cols-2 gap-2 bg-slate-100 p-1 rounded-xl">
            <button type="button" @click="mode = 'manual'"
                    :class="mode === 'manual' ? 'bg-white shadow text-telkom-red' : 'text-slate-500'"
                    class="py-2 rounded-lg text-xs font-bold transition-all">
                ✍️ Isi Manual
            </button>
            <button type="button" @click="mode = 'otomatis'"
                    :class="mode === 'otomatis' ? 'bg-white shadow text-telkom-red' : 'text-slate-500'"
                    class="py-2 rounded-lg text-xs font-bold transition-all">
                🤖 Hitung Otomatis
            </button>
        </div>

        <!-- Tombol analisis otomatis, cuma muncul kalau mode = otomatis -->
        <div x-show="mode === 'otomatis'" x-cloak>
            <button type="button" id="btnAnalisisOtomatis"
                    data-url="{{ route('use-cases.analisis-otomatis', $useCase) }}"
                    class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-1.5">
                <i data-lucide="sparkles" class="h-4 w-4"></i> Analisis & Isi Otomatis
            </button>
            <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">
                Sistem akan membaca deskripsi, latar belakang, dan tujuan use case untuk menyarankan skor. Kamu tetap bisa mengubahnya secara manual setelah itu.
            </p>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-3">
            @foreach([
                'dampak' => 'Dampak', 'kelayakan' => 'Kelayakan', 'ketersediaan_data' => 'Ketersediaan Data',
                'kesiapan_sdm' => 'Kesiapan SDM', 'kesiapan_infrastruktur' => 'Kesiapan Infrastruktur',
                'urgensi' => 'Urgensi', 'risiko_etika_skor' => 'Risiko Etika', 'kompleksitas_teknis' => 'Kompleksitas Teknis',
            ] as $field => $label)
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $label }} (1-5)</label>
                <select name="{{ $field }}" id="field_{{ $field }}" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm">
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

        @php($risiko = $useCase->risikoEtikaDetail)
        <div class="bg-white p-4 rounded-2xl border border-slate-200 space-y-3">
            <input type="hidden" name="risiko_etika_dikirim" value="1">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-700">Risiko Etika</h3>

            <label class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                <input type="checkbox" name="menggunakan_data_pribadi" value="1" @checked(old('menggunakan_data_pribadi', $risiko?->menggunakan_data_pribadi))>
                Menggunakan data pribadi
            </label>

            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500">Jenis Data Sensitif</label>
                <input type="text" name="jenis_data_sensitif" value="{{ old('jenis_data_sensitif', $risiko?->jenis_data_sensitif) }}"
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
            </div>

            @foreach([
                'risiko_privasi' => 'Risiko Privasi',
                'risiko_bias' => 'Risiko Bias',
                'risiko_ketergantungan_ai' => 'Ketergantungan AI',
                'risiko_kesalahan_output' => 'Kesalahan Output',
            ] as $field => $label)
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500">{{ $label }}</label>
                <select name="{{ $field }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    <option value="">-</option>
                    @foreach(['Rendah', 'Sedang', 'Tinggi'] as $level)
                        <option value="{{ $level }}" @selected(old($field, $risiko?->$field) === $level)>{{ $level }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach

            <label class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                <input type="checkbox" name="perlu_validasi_manusia" value="1" @checked(old('perlu_validasi_manusia', $risiko?->perlu_validasi_manusia))>
                Memerlukan validasi manusia
            </label>
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                <input type="checkbox" name="perlu_persetujuan_pengguna" value="1" @checked(old('perlu_persetujuan_pengguna', $risiko?->perlu_persetujuan_pengguna))>
                Memerlukan persetujuan pengguna
            </label>

            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500">Rekomendasi Mitigasi</label>
                <textarea name="rekomendasi_mitigasi" rows="3"
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">{{ old('rekomendasi_mitigasi', $risiko?->rekomendasi_mitigasi) }}</textarea>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('btnAnalisisOtomatis');
        if (!btn) return;

        btn.addEventListener('click', async function () {
            const url = btn.getAttribute('data-url');
            btn.disabled = true;
            btn.innerText = 'Menganalisis...';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json();

                Object.keys(data).forEach(function (field) {
                    const select = document.getElementById('field_' + field);
                    if (select) select.value = data[field];
                });

                btn.innerHTML = '<i data-lucide="check" class="h-4 w-4"></i> Skor Terisi Otomatis';
                if (window.lucide) lucide.createIcons();
            } catch (e) {
                alert('Gagal menganalisis. Coba lagi.');
                btn.innerText = 'Analisis & Isi Otomatis';
            } finally {
                btn.disabled = false;
            }
        });
    });
    </script>
    @endisset
</div>
