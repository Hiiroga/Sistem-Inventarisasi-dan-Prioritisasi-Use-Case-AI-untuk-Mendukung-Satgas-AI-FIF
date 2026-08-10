@extends('layouts.main')
@section('title', 'Tambah Use Case')

@section('content')
<div class="space-y-6 ui-stagger">
    <div>
        <a href="{{ route('use-cases.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-telkom-red transition-colors">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Daftar Use Case
        </a>
        <h1 class="text-2xl font-black tracking-tight text-slate-900 mt-3">Tambah Use Case Baru</h1>
        <p class="text-slate-400 text-xs mt-1">
            Kode use case akan dibuat otomatis. Penilaian prioritas dapat diisi setelah use case tersimpan.
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

    <form action="{{ route('use-cases.store') }}" method="POST" class="ui-card p-6 sm:p-7 space-y-6">
        @csrf
        @include('use-cases._form')

        <div class="flex flex-wrap gap-2 pt-5 border-t border-slate-100">
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-telkom-red hover:bg-brand-600 text-white rounded-xl text-sm font-bold shadow-brand transition-all duration-200 hover:-translate-y-px">
                <i data-lucide="save" class="h-4 w-4"></i> Simpan Use Case
            </button>
            <a href="{{ route('use-cases.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-sm font-bold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
