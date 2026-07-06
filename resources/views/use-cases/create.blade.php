@extends('layouts.main')
@section('title', 'Tambah Use Case')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-6">
    <h1 class="text-xl font-extrabold text-slate-800 mb-5">Tambah Use Case Baru</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-slate-700 text-sm px-4 py-3 rounded-xl">
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('use-cases.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('use-cases._form')
        <div class="flex gap-2 pt-2">
            <button type="submit" class="px-5 py-2.5 bg-telkom-red hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-md transition-all">Simpan</button>
            <a href="{{ route('use-cases.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</a>
        </div>
    </form>
</div>
@endsection