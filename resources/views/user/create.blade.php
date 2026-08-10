@extends('layouts.main')
@php($isEdit = isset($useCase))
@section('title', $isEdit ? 'Edit Usulan Use Case' : 'Usulkan Use Case Baru')

@section('content')
<div class="max-w-3xl space-y-6 ui-stagger">

    <div>
        <a href="{{ route('user.dashboard') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-telkom-red transition-colors">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Dashboard Saya
        </a>
        <div class="flex flex-wrap items-center gap-2.5 mt-3">
            <h1 class="text-2xl font-black tracking-tight text-slate-900">
                {{ $isEdit ? 'Edit Usulan Use Case AI' : 'Usulkan Use Case AI Baru' }}
            </h1>
            @if($isEdit)
                <span class="text-[11px] font-bold text-telkom-red bg-brand-50 px-2.5 py-1 rounded-lg tnum">{{ $useCase->kode }}</span>
            @endif
        </div>
        <p class="text-slate-400 text-xs mt-1">
            {{ $isEdit
                ? 'Perubahan hanya dapat dilakukan selama usulan masih berstatus Ide.'
                : 'Silahkan mengisi data berikut. Penilaian prioritas akan dilakukan oleh tim Satgas AI.' }}
        </p>
    </div>

    @if($errors->any())
        <div role="alert" class="flex items-start gap-3 bg-red-50 border border-red-100 text-slate-700 text-sm px-4 py-3.5 rounded-2xl">
            <i data-lucide="alert-circle" class="h-4.5 w-4.5 text-red-500 shrink-0 mt-0.5"></i>
            <div>
                <p class="font-bold text-red-700 text-xs uppercase tracking-wider mb-1">Periksa kembali isian berikut</p>
                <ul class="list-disc pl-4 space-y-0.5 text-xs">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ $isEdit ? route('user.update', $useCase) : route('user.store') }}" method="POST"
          class="ui-card p-6 sm:p-7 space-y-3">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <fieldset class="space-y-3">
            <legend class="flex items-center gap-1 text-[11px] font-extrabold uppercase tracking-[0.1em] text-slate-400 mb-3">
                <span class="h-6 w-6 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="lightbulb" class="h-3.5 w-3.5"></i>
                </span>
                Ide Use Case
            </legend>

            <div class="space-y-1.5 pt-1.5">
                <label for="nama_use_case" class="ui-label pb-1">Nama Use Case <span class="text-telkom-red">*</span></label>
                <input id="nama_use_case" type="text" name="nama_use_case"
                       value="{{ old('nama_use_case', $useCase->nama_use_case ?? '') }}" required
                       placeholder="Contoh: Asisten AI untuk penyusunan RPS"
                       @if($errors->has('nama_use_case')) aria-invalid="true" @endif
                       class="ui-field">
                @error('nama_use_case')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-1.5 pt-1.5">
                <label for="deskripsi" class="ui-label pb-1">Deskripsi <span class="text-telkom-red">*</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="3" required
                          placeholder="Jelaskan singkat cara kerja dan manfaat use case ini."
                          @if($errors->has('deskripsi')) aria-invalid="true" @endif
                          class="ui-field">{{ old('deskripsi', $useCase->deskripsi ?? '') }}</textarea>
                @error('deskripsi')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-1.5 pt-1.5">
                <label for="latar_belakang_masalah" class="ui-label pb-1">Latar Belakang Masalah</label>
                <textarea id="latar_belakang_masalah" name="latar_belakang_masalah" rows="2"
                          placeholder="Masalah apa yang ingin diselesaikan?"
                          class="ui-field">{{ old('latar_belakang_masalah', $useCase->latar_belakang_masalah ?? '') }}</textarea>
            </div>

            <div class="space-y-1.5 pt-1.5">
                <label for="tujuan_use_case" class="ui-label pb-1">Tujuan Use Case</label>
                <textarea id="tujuan_use_case" name="tujuan_use_case" rows="2"
                          placeholder="Hasil atau dampak yang diharapkan."
                          class="ui-field">{{ old('tujuan_use_case', $useCase->tujuan_use_case ?? '') }}</textarea>
            </div>
        </fieldset>

        <fieldset class="space-y-4 pt-2 border-t border-slate-100">
            <legend class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.1em] text-slate-400 mb-3 pt-4">
                <span class="h-6 w-6 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                    <i data-lucide="tags" class="h-3.5 w-3.5"></i>
                </span>
                Detail Tambahan
            </legend>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="unit_terkait" class="ui-label">Unit Terkait <span class="text-telkom-red">*</span></label>
                    <input id="unit_terkait" type="text" name="unit_terkait"
                           value="{{ old('unit_terkait', $useCase->unit_terkait ?? '') }}" required
                           placeholder="Contoh: Prodi Informatika"
                           @if($errors->has('unit_terkait')) aria-invalid="true" @endif
                           class="ui-field">
                    @error('unit_terkait')<p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-1.5">
                    <label for="target_pengguna" class="ui-label">Target Pengguna</label>
                    <input id="target_pengguna" type="text" name="target_pengguna"
                           value="{{ old('target_pengguna', $useCase->target_pengguna ?? '') }}"
                           placeholder="Contoh: Mahasiswa, Dosen"
                           class="ui-field">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
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
                    <label for="teknologi_ai" class="ui-label">Teknologi AI</label>
                    <input id="teknologi_ai" type="text" name="teknologi_ai"
                           value="{{ old('teknologi_ai', $useCase->teknologi_ai ?? '') }}"
                           placeholder="Contoh: LLM, NLP, Computer Vision"
                           class="ui-field">
                </div>
            </div>
        </fieldset>

        <div class="flex flex-wrap gap-2 pt-10 border-t border-slate-100">
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-telkom-red hover:bg-brand-600 text-white rounded-xl text-sm font-bold shadow-brand transition-all duration-200 hover:-translate-y-px">
                <i data-lucide="{{ $isEdit ? 'save' : 'send' }}" class="h-4 w-4"></i>
                {{ $isEdit ? 'Simpan Perubahan' : 'Kirim Usulan' }}
            </button>
            <a href="{{ route('user.dashboard') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-sm font-bold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
