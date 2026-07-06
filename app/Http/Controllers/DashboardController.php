<?php

namespace App\Http\Controllers;

use App\Models\UseCase;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUseCase = UseCase::count();

        $rataDampak = round(
            \App\Models\PenilaianPrioritas::whereNotNull('dampak')->avg('dampak'), 1
        );
        $rataRisiko = round(
            \App\Models\PenilaianPrioritas::whereNotNull('risiko_etika_skor')->avg('risiko_etika_skor'), 1
        );

        // Data untuk bar chart: jumlah use case per kategori
        $perKategori = Kategori::withCount('useCases')->orderBy('nama_kategori')->get();

        // Data untuk pie chart: distribusi status
        $perStatus = UseCase::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Data untuk pie chart: distribusi level prioritas
        $perLevel = \App\Models\PenilaianPrioritas::whereNotNull('level_prioritas')
            ->selectRaw('level_prioritas, count(*) as total')
            ->groupBy('level_prioritas')
            ->pluck('total', 'level_prioritas');

        // Top 5 use case skor tertinggi
        $top5 = UseCase::with('penilaianPrioritas')
            ->whereHas('penilaianPrioritas', fn($q) => $q->whereNotNull('skor_prioritas'))
            ->get()
            ->sortByDesc(fn($uc) => $uc->penilaianPrioritas->skor_prioritas)
            ->take(5);

        return view('dashboard-usecase', compact(
            'totalUseCase', 'rataDampak', 'rataRisiko',
            'perKategori', 'perStatus', 'perLevel', 'top5'
        ));
    }
}