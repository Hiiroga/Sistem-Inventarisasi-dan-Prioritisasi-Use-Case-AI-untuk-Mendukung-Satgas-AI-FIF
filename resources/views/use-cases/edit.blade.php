@extends('layouts.main')
@section('title', 'Edit Use Case')

@section('content')
<div class="space-y-6 ui-stagger">
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <a href="{{ route('use-cases.show', $useCase) }}"
               class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-telkom-red transition-colors">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Detail Use Case
            </a>
            <div class="flex flex-wrap items-center gap-2.5 mt-3">
                <h1 class="text-2xl font-black tracking-tight text-slate-900">Edit Use Case</h1>
                <span class="text-[11px] font-bold text-telkom-red bg-brand-50 px-2.5 py-1 rounded-lg tnum">{{ $useCase->kode }}</span>
            </div>
            <p class="text-slate-400 text-xs mt-1">{{ $useCase->nama_use_case }}</p>
        </div>
        <x-status-badge :status="$useCase->status" class="mt-1" />
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

    <form action="{{ route('use-cases.update', $useCase) }}" method="POST" class="ui-card p-6 sm:p-7 space-y-6">
        @csrf @method('PUT')
        @include('use-cases._form')

        <div class="flex flex-wrap gap-2 pt-5 border-t border-slate-100">
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-telkom-red hover:bg-brand-600 text-white rounded-xl text-sm font-bold shadow-brand transition-all duration-200 hover:-translate-y-px">
                <i data-lucide="save" class="h-4 w-4"></i> Simpan Perubahan
            </button>
            <a href="{{ route('use-cases.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-sm font-bold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
