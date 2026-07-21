<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\UseCase;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $myUseCases = UseCase::with(['kategori', 'penilaianPrioritas'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $total = $myUseCases->count();
        $perStatus = $myUseCases->groupBy('status')->map->count();

        return view('user.dashboard', compact('myUseCases', 'total', 'perStatus'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('user.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_use_case' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'latar_belakang_masalah' => 'nullable|string',
            'tujuan_use_case' => 'nullable|string',
            'unit_terkait' => 'required|string|max:100',
            'target_pengguna' => 'nullable|string|max:150',
            'kategori_id' => 'required|exists:kategories,id',
            'teknologi_ai' => 'nullable|string|max:150',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['pengusul'] = auth()->user()->name;
        $validated['status'] = 'Ide';

        $last = UseCase::orderByDesc('id')->first();
        $number = $last ? ((int) preg_replace('/\D/', '', $last->kode)) + 1 : 1;
        $validated['kode'] = 'UC'.str_pad($number, 3, '0', STR_PAD_LEFT);

        UseCase::create($validated);

        return redirect()->route('user.dashboard')
            ->with('success', 'Usulan use case berhasil dikirim! Menunggu penilaian dari Satgas AI.');
    }

    public function edit(UseCase $useCase)
    {
        $this->ensureEditableByCurrentUser($useCase);

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('user.create', compact('useCase', 'kategoris'));
    }

    public function update(Request $request, UseCase $useCase)
    {
        $this->ensureEditableByCurrentUser($useCase);

        $validated = $request->validate([
            'nama_use_case' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'latar_belakang_masalah' => 'nullable|string',
            'tujuan_use_case' => 'nullable|string',
            'unit_terkait' => 'required|string|max:100',
            'target_pengguna' => 'nullable|string|max:150',
            'kategori_id' => 'required|exists:kategories,id',
            'teknologi_ai' => 'nullable|string|max:150',
        ]);

        $useCase->update($validated);

        return redirect()->route('user.dashboard')
            ->with('success', 'Usulan use case berhasil diperbarui.');
    }

    private function ensureEditableByCurrentUser(UseCase $useCase): void
    {
        abort_unless($useCase->user_id === auth()->id(), 403);
        abort_unless($useCase->status === 'Ide', 403, 'Usulan yang sudah diproses tidak dapat diubah.');
    }
}
