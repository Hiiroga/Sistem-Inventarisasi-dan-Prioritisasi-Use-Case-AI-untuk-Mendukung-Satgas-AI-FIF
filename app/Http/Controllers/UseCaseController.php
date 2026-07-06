<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\UseCase;
use Illuminate\Http\Request;
use App\Exports\UseCaseExport;
use Maatwebsite\Excel\Facades\Excel;

class UseCaseController extends Controller
{
    public function index(Request $request)
    {
        $query = UseCase::with(['kategori', 'penilaianPrioritas']);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('nama_use_case', 'like', '%' . $request->search . '%');
        }

        $useCases = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('use-cases.index', compact('useCases', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('use-cases.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_use_case' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'latar_belakang_masalah' => 'nullable|string',
            'tujuan_use_case' => 'nullable|string',
            'pengusul' => 'required|string|max:100',
            'unit_terkait' => 'required|string|max:100',
            'target_pengguna' => 'nullable|string|max:150',
            'kategori_id' => 'required|exists:kategories,id',
            'teknologi_ai' => 'nullable|string|max:150',
            'status' => 'required|in:Ide,Direncanakan,Prototype,Implementasi',
        ]);

        $validated['kode'] = $this->generateKode();

        UseCase::create($validated);

        return redirect()->route('use-cases.index')
            ->with('success', 'Use case berhasil ditambahkan.');
    }

    public function show(UseCase $useCase)
    {
        $useCase->load(['kategori', 'penilaianPrioritas', 'risikoEtikaDetail']);
        return view('use-cases.show', compact('useCase'));
    }

    public function edit(UseCase $useCase)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $useCase->load(['penilaianPrioritas', 'risikoEtikaDetail']);
        return view('use-cases.edit', compact('useCase', 'kategoris'));
    }

    public function update(Request $request, UseCase $useCase)
    {
        $validated = $request->validate([
            'nama_use_case' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'latar_belakang_masalah' => 'nullable|string',
            'tujuan_use_case' => 'nullable|string',
            'pengusul' => 'required|string|max:100',
            'unit_terkait' => 'required|string|max:100',
            'target_pengguna' => 'nullable|string|max:150',
            'kategori_id' => 'required|exists:kategories,id',
            'teknologi_ai' => 'nullable|string|max:150',
            'status' => 'required|in:Ide,Direncanakan,Prototype,Implementasi',
        ]);

        $useCase->update($validated);

        // Update atau buat penilaian prioritas kalau field skor dikirim
        if ($request->filled('dampak')) {
            $useCase->penilaianPrioritas()->updateOrCreate(
                ['use_case_id' => $useCase->id],
                $request->only([
                    'dampak', 'kelayakan', 'ketersediaan_data',
                    'kesiapan_sdm', 'kesiapan_infrastruktur', 'urgensi',
                    'risiko_etika_skor', 'kompleksitas_teknis',
                    'estimasi_waktu', 'estimasi_biaya',
                ])
            );
        }

        return redirect()->route('use-cases.index')
            ->with('success', 'Use case berhasil diperbarui.');
    }

    public function destroy(UseCase $useCase)
    {
        $useCase->delete();

        return redirect()->route('use-cases.index')
            ->with('success', 'Use case berhasil dihapus.');
    }

    private function generateKode(): string
    {
        $last = UseCase::orderByDesc('id')->first();
        $number = $last ? ((int) substr($last->kode, 2)) + 1 : 1;
        return 'UC' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function export()
    {
        return Excel::download(new UseCaseExport, 'data-use-case-ai-' . now()->format('Y-m-d') . '.xlsx');
    }
}