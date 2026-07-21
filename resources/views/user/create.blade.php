@extends('layouts.main')
@php($isEdit = isset($useCase))
@section('title', $isEdit ? 'Edit Usulan Use Case' : 'Usulkan Use Case Baru')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-6 max-w-3xl">
    <h1 class="text-xl font-extrabold text-slate-800 mb-5">{{ $isEdit ? 'Edit Usulan Use Case AI' : 'Usulkan Use Case AI Baru' }}</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-slate-700 text-sm px-4 py-3 rounded-xl">
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $isEdit ? route('user.update', $useCase) : route('user.store') }}" method="POST" class="space-y-4">
        @csrf
        @if($isEdit) @method('PUT') @endif
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Use Case</label>
            <input type="text" name="nama_use_case" value="{{ old('nama_use_case', $useCase->nama_use_case ?? '') }}" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">
        </div>
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</label>
            <textarea name="deskripsi" rows="3" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">{{ old('deskripsi', $useCase->deskripsi ?? '') }}</textarea>
        </div>
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Latar Belakang Masalah</label>
            <textarea name="latar_belakang_masalah" rows="2" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">{{ old('latar_belakang_masalah', $useCase->latar_belakang_masalah ?? '') }}</textarea>
        </div>
        <div class="space-y-1">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tujuan Use Case</label>
            <textarea name="tujuan_use_case" rows="2" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">{{ old('tujuan_use_case', $useCase->tujuan_use_case ?? '') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Unit Terkait</label>
                <input type="text" name="unit_terkait" value="{{ old('unit_terkait', $useCase->unit_terkait ?? '') }}" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Target Pengguna</label>
                <input type="text" name="target_pengguna" value="{{ old('target_pengguna', $useCase->target_pengguna ?? '') }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</label>
                <select name="kategori_id" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">
                    <option value="">-- Pilih --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(old('kategori_id', $useCase->kategori_id ?? '') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Teknologi AI</label>
                <input type="text" name="teknologi_ai" value="{{ old('teknologi_ai', $useCase->teknologi_ai ?? '') }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm">
            </div>
        </div>
        <div class="flex gap-2 pt-2">
            <button type="submit" class="px-5 py-2.5 bg-telkom-red hover:bg-red-700 text-white rounded-xl text-sm font-bold">{{ $isEdit ? 'Simpan Perubahan' : 'Kirim Usulan' }}</button>
            <a href="{{ route('user.dashboard') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold">Batal</a>
        </div>
    </form>
</div>
@endsection
