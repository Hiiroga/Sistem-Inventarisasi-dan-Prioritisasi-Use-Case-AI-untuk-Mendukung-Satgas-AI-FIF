{{--
    Formulir use case untuk Admin (dipakai oleh use-cases/create & use-cases/edit).
    Blok penilaian prioritas dan risiko etika hanya muncul pada mode edit,
    yaitu ketika variabel $useCase tersedia.
--}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kolom kiri: data use case ── --}}
    <div class="lg:col-span-2 space-y-6">

        <fieldset class="space-y-4">
            <legend class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.1em] text-slate-400 mb-3">
                <span class="h-6 w-6 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="file-text" class="h-3.5 w-3.5"></i>
                </span>
                Informasi Use Case
            </legend>

            <div class="space-y-1.5">
                <label for="nama_use_case" class="ui-label">Nama Use Case <span class="text-telkom-red">*</span></label>
                <input id="nama_use_case" type="text" name="nama_use_case"
                       value="{{ old('nama_use_case', $useCase->nama_use_case ?? '') }}" required
                       placeholder="Contoh: Chatbot layanan akademik mahasiswa"
                       @if($errors->has('nama_use_case')) aria-invalid="true" @endif
                       class="ui-field">
                @error('nama_use_case')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-1.5">
                <label for="deskripsi" class="ui-label">Deskripsi <span class="text-telkom-red">*</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="3" required
                          placeholder="Jelaskan secara singkat apa yang dilakukan use case ini."
                          @if($errors->has('deskripsi')) aria-invalid="true" @endif
                          class="ui-field">{{ old('deskripsi', $useCase->deskripsi ?? '') }}</textarea>
                @error('deskripsi')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="latar_belakang_masalah" class="ui-label">Latar Belakang Masalah</label>
                    <textarea id="latar_belakang_masalah" name="latar_belakang_masalah" rows="3"
                              placeholder="Masalah apa yang ingin diselesaikan?"
                              class="ui-field">{{ old('latar_belakang_masalah', $useCase->latar_belakang_masalah ?? '') }}</textarea>
                </div>
                <div class="space-y-1.5">
                    <label for="tujuan_use_case" class="ui-label">Tujuan Use Case</label>
                    <textarea id="tujuan_use_case" name="tujuan_use_case" rows="3"
                              placeholder="Target dampak yang diharapkan."
                              class="ui-field">{{ old('tujuan_use_case', $useCase->tujuan_use_case ?? '') }}</textarea>
                </div>
            </div>
        </fieldset>

        <fieldset class="space-y-4 pt-2 border-t border-slate-100">
            <legend class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.1em] text-slate-400 mb-3 pt-4">
                <span class="h-6 w-6 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="users" class="h-3.5 w-3.5"></i>
                </span>
                Pemangku Kepentingan
            </legend>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="pengusul" class="ui-label">Pengusul <span class="text-telkom-red">*</span></label>
                    <input id="pengusul" type="text" name="pengusul"
                           value="{{ old('pengusul', $useCase->pengusul ?? '') }}" required
                           @if($errors->has('pengusul')) aria-invalid="true" @endif
                           class="ui-field">
                    @error('pengusul')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-1.5">
                    <label for="unit_terkait" class="ui-label">Unit Terkait <span class="text-telkom-red">*</span></label>
                    <input id="unit_terkait" type="text" name="unit_terkait"
                           value="{{ old('unit_terkait', $useCase->unit_terkait ?? '') }}" required
                           @if($errors->has('unit_terkait')) aria-invalid="true" @endif
                           class="ui-field">
                    @error('unit_terkait')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="target_pengguna" class="ui-label">Target Pengguna</label>
                    <input id="target_pengguna" type="text" name="target_pengguna"
                           value="{{ old('target_pengguna', $useCase->target_pengguna ?? '') }}"
                           placeholder="Contoh: Mahasiswa, Dosen, Tendik"
                           class="ui-field">
                </div>
                <div class="space-y-1.5">
                    <label for="teknologi_ai" class="ui-label">Teknologi AI</label>
                    <input id="teknologi_ai" type="text" name="teknologi_ai"
                           value="{{ old('teknologi_ai', $useCase->teknologi_ai ?? '') }}"
                           placeholder="Contoh: LLM, Computer Vision, NLP"
                           class="ui-field">
                </div>
            </div>
        </fieldset>

        <fieldset class="space-y-4 pt-2 border-t border-slate-100">
            <legend class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.1em] text-slate-400 mb-3 pt-4">
                <span class="h-6 w-6 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="tags" class="h-3.5 w-3.5"></i>
                </span>
                Klasifikasi &amp; Status
            </legend>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="kategori_id" class="ui-label">Kategori <span class="text-telkom-red">*</span></label>
                    <select id="kategori_id" name="kategori_id" required
                            @if($errors->has('kategori_id')) aria-invalid="true" @endif
                            class="ui-field">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected(old('kategori_id', $useCase->kategori_id ?? '') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-1.5">
                    <label for="status" class="ui-label">Status <span class="text-telkom-red">*</span></label>
                    <select id="status" name="status" required class="ui-field">
                        @foreach(['Ide', 'Direncanakan', 'Prototype', 'Implementasi'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $useCase->status ?? 'Ide') == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @isset($useCase)
                <div class="space-y-1.5">
                    <label for="catatan_status" class="ui-label">Catatan Perubahan Status</label>
                    <textarea id="catatan_status" name="catatan_status" rows="2"
                              placeholder="Wajib diisi bila status berubah agar keputusan dapat diaudit."
                              class="ui-field">{{ old('catatan_status') }}</textarea>
                    <p class="text-[11px] text-slate-400 flex items-center gap-1.5">
                        <i data-lucide="info" class="h-3.5 w-3.5 shrink-0"></i>
                        Catatan akan tersimpan pada histori status use case.
                    </p>
                </div>
            @endisset
        </fieldset>
    </div>

    {{-- ── Kolom kanan: penilaian (hanya saat edit) ── --}}
    @isset($useCase)
        @php $penilaian = $useCase->penilaianPrioritas; @endphp

        <div class="space-y-5 lg:sticky lg:top-24 lg:self-start" x-data="{ mode: 'manual' }">

            {{-- Ringkasan skor --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-telkom-red to-telkom-maroon text-white rounded-2xl p-5 shadow-brand">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white/10" aria-hidden="true"></div>
                <h3 class="relative text-[11px] uppercase font-extrabold tracking-[0.12em] text-brand-100 flex items-center gap-1.5">
                    <i data-lucide="activity" class="h-4 w-4"></i> Penilaian Prioritas
                </h3>
                @if($penilaian?->skor_prioritas !== null)
                    <div class="relative text-center py-3">
                        <div class="text-5xl font-black tracking-tight tnum">{{ $penilaian->skor_prioritas }}</div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-brand-200 mt-1.5">{{ $penilaian->level_prioritas }}</div>
                    </div>
                @else
                    <p class="relative text-xs text-brand-100 mt-2.5 leading-relaxed">
                        Lengkapi seluruh parameter di bawah untuk menghitung skor prioritas secara otomatis.
                    </p>
                @endif
            </div>

            {{-- Pilihan cara pengisian --}}
            <div>
                <p class="ui-label mb-2">Cara pengisian</p>
                <div class="grid grid-cols-2 gap-1.5 bg-slate-100 p-1.5 rounded-2xl" role="group" aria-label="Cara pengisian skor">
                    <button type="button" @click="mode = 'manual'"
                            :aria-pressed="(mode === 'manual').toString()"
                            :class="mode === 'manual' ? 'bg-white shadow-xs text-telkom-red' : 'text-slate-500 hover:text-slate-700'"
                            class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-200">
                        <i data-lucide="pen-line" class="h-3.5 w-3.5"></i> Manual
                    </button>
                    <button type="button" @click="mode = 'otomatis'"
                            :aria-pressed="(mode === 'otomatis').toString()"
                            :class="mode === 'otomatis' ? 'bg-white shadow-xs text-telkom-red' : 'text-slate-500 hover:text-slate-700'"
                            class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-200">
                        <i data-lucide="sparkles" class="h-3.5 w-3.5"></i> Otomatis
                    </button>
                </div>
            </div>

            {{-- Tombol analisis otomatis --}}
            <div x-show="mode === 'otomatis'" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2.5">
                <button type="button" id="btnAnalisisOtomatis"
                        data-url="{{ route('use-cases.analisis-otomatis', $useCase) }}"
                        class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 disabled:opacity-60 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i data-lucide="sparkles" class="h-4 w-4"></i> Analisis &amp; Isi Otomatis
                </button>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Sistem membaca deskripsi, latar belakang, dan tujuan use case untuk menyarankan skor.
                    Kamu tetap bisa mengubahnya secara manual setelah itu.
                </p>
            </div>

            {{-- Parameter skor --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-4 space-y-3.5">
                <h3 class="text-[11px] font-extrabold uppercase tracking-[0.1em] text-slate-500">Parameter Skor</h3>

                @foreach([
                    'dampak' => ['Dampak', false],
                    'kelayakan' => ['Kelayakan', false],
                    'ketersediaan_data' => ['Ketersediaan Data', false],
                    'kesiapan_sdm' => ['Kesiapan SDM', false],
                    'kesiapan_infrastruktur' => ['Kesiapan Infrastruktur', false],
                    'urgensi' => ['Urgensi', false],
                    'risiko_etika_skor' => ['Risiko Etika', true],
                    'kompleksitas_teknis' => ['Kompleksitas Teknis', true],
                ] as $field => [$label, $pengurang])
                    <div class="space-y-1.5">
                        <label for="field_{{ $field }}" class="ui-label flex items-center gap-1.5">
                            @if($pengurang)
                                <i data-lucide="minus-circle" class="h-3 w-3 text-red-400" title="Mengurangi skor"></i>
                            @endif
                            {{ $label }} <span class="text-slate-300 normal-case tracking-normal font-semibold">(1–5)</span>
                        </label>
                        <select name="{{ $field }}" id="field_{{ $field }}" class="ui-field !py-2">
                            <option value="">—</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" @selected(old($field, $penilaian->$field ?? '') == $i)>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                @endforeach

                <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                    <div class="space-y-1.5">
                        <label for="estimasi_waktu" class="ui-label">Estimasi Waktu</label>
                        <select id="estimasi_waktu" name="estimasi_waktu" class="ui-field !py-2">
                            <option value="">—</option>
                            @foreach(['1 bulan', '3 bulan', '6 bulan'] as $w)
                                <option value="{{ $w }}" @selected(old('estimasi_waktu', $penilaian->estimasi_waktu ?? '') == $w)>{{ $w }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label for="estimasi_biaya" class="ui-label">Estimasi Biaya</label>
                        <select id="estimasi_biaya" name="estimasi_biaya" class="ui-field !py-2">
                            <option value="">—</option>
                            @foreach(['Rendah', 'Sedang', 'Tinggi'] as $b)
                                <option value="{{ $b }}" @selected(old('estimasi_biaya', $penilaian->estimasi_biaya ?? '') == $b)>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Risiko etika --}}
            @php($risiko = $useCase->risikoEtikaDetail)
            <div class="bg-white border border-slate-200 rounded-2xl p-4 space-y-3.5">
                <input type="hidden" name="risiko_etika_dikirim" value="1">

                <h3 class="text-[11px] font-extrabold uppercase tracking-[0.1em] text-slate-500 flex items-center gap-1.5">
                    <i data-lucide="shield-alert" class="h-3.5 w-3.5 text-telkom-maroon"></i> Risiko Etika
                </h3>

                <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 p-2.5 -mx-1 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="menggunakan_data_pribadi" value="1"
                           @checked(old('menggunakan_data_pribadi', $risiko?->menggunakan_data_pribadi))
                           class="ui-check rounded border-slate-300">
                    Menggunakan data pribadi
                </label>

                <div class="space-y-1.5">
                    <label for="jenis_data_sensitif" class="ui-label">Jenis Data Sensitif</label>
                    <input id="jenis_data_sensitif" type="text" name="jenis_data_sensitif"
                           value="{{ old('jenis_data_sensitif', $risiko?->jenis_data_sensitif) }}"
                           placeholder="Contoh: NIM, nilai, data kesehatan"
                           class="ui-field !py-2">
                </div>

                @foreach([
                    'risiko_privasi' => 'Risiko Privasi',
                    'risiko_bias' => 'Risiko Bias',
                    'risiko_ketergantungan_ai' => 'Ketergantungan AI',
                    'risiko_kesalahan_output' => 'Kesalahan Output',
                ] as $field => $label)
                    <div class="space-y-1.5">
                        <label for="risk_{{ $field }}" class="ui-label">{{ $label }}</label>
                        <select id="risk_{{ $field }}" name="{{ $field }}" class="ui-field !py-2">
                            <option value="">—</option>
                            @foreach(['Rendah', 'Sedang', 'Tinggi'] as $level)
                                <option value="{{ $level }}" @selected(old($field, $risiko?->$field) === $level)>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <div class="space-y-0.5 pt-1">
                    <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 p-2.5 -mx-1 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="perlu_validasi_manusia" value="1"
                               @checked(old('perlu_validasi_manusia', $risiko?->perlu_validasi_manusia))
                               class="ui-check rounded border-slate-300">
                        Memerlukan validasi manusia
                    </label>
                    <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 p-2.5 -mx-1 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="perlu_persetujuan_pengguna" value="1"
                               @checked(old('perlu_persetujuan_pengguna', $risiko?->perlu_persetujuan_pengguna))
                               class="ui-check rounded border-slate-300">
                        Memerlukan persetujuan pengguna
                    </label>
                </div>

                <div class="space-y-1.5">
                    <label for="rekomendasi_mitigasi" class="ui-label">Rekomendasi Mitigasi</label>
                    <textarea id="rekomendasi_mitigasi" name="rekomendasi_mitigasi" rows="3"
                              placeholder="Langkah mitigasi yang disarankan."
                              class="ui-field !py-2">{{ old('rekomendasi_mitigasi', $risiko?->rekomendasi_mitigasi) }}</textarea>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('btnAnalisisOtomatis');
            if (! btn) return;

            const labelAwal = btn.innerHTML;

            const setLabel = function (html) {
                btn.innerHTML = html;
                if (window.lucide) lucide.createIcons();
            };

            btn.addEventListener('click', async function () {
                const url = btn.getAttribute('data-url');
                btn.disabled = true;
                setLabel('<i data-lucide="loader" class="h-4 w-4 animate-spin"></i> Menganalisis…');

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
                        if (! select) return;

                        select.value = data[field];
                        // Sorot sekilas field yang baru terisi agar perubahan terlihat.
                        select.style.transition = 'box-shadow .3s';
                        select.style.boxShadow = '0 0 0 4px rgba(22, 163, 74, .18)';
                        setTimeout(() => { select.style.boxShadow = ''; }, 1200);
                    });

                    setLabel('<i data-lucide="check" class="h-4 w-4"></i> Skor Terisi Otomatis');
                    setTimeout(() => setLabel(labelAwal), 3000);
                } catch (e) {
                    alert('Gagal menganalisis. Coba lagi.');
                    setLabel(labelAwal);
                } finally {
                    btn.disabled = false;
                }
            });
        });
        </script>
    @endisset
</div>
