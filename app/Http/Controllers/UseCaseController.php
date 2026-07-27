<?php

namespace App\Http\Controllers;

use App\Exports\UseCaseExport;
use App\Models\Kategori;
use App\Models\UseCase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UseCaseController extends Controller
{
    public function index(Request $request): View
    {
        $query = UseCase::with(['kategori', 'penilaianPrioritas']);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($query) use ($search) {
                $query->where('nama_use_case', 'like', "%{$search}%")
                    ->orWhere('pengusul', 'like', "%{$search}%")
                    ->orWhere('teknologi_ai', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        $useCases = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('use-cases.index', compact('useCases', 'kategoris'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('use-cases.create', compact('kategoris'));
    }

    public function store(Request $request): RedirectResponse
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

    public function show(UseCase $useCase): View
    {
        $useCase->load(['kategori', 'penilaianPrioritas', 'risikoEtikaDetail', 'statusHistories.changedBy']);

        return view('use-cases.show', compact('useCase'));
    }

    public function edit(UseCase $useCase): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $useCase->load(['penilaianPrioritas', 'risikoEtikaDetail']);

        return view('use-cases.edit', compact('useCase', 'kategoris'));
    }

    public function update(Request $request, UseCase $useCase): RedirectResponse
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
            'dampak' => 'nullable|integer|between:1,5',
            'kelayakan' => 'nullable|integer|between:1,5',
            'ketersediaan_data' => 'nullable|integer|between:1,5',
            'kesiapan_sdm' => 'nullable|integer|between:1,5',
            'kesiapan_infrastruktur' => 'nullable|integer|between:1,5',
            'urgensi' => 'nullable|integer|between:1,5',
            'risiko_etika_skor' => 'nullable|integer|between:1,5',
            'kompleksitas_teknis' => 'nullable|integer|between:1,5',
            'estimasi_waktu' => 'nullable|in:1 bulan,3 bulan,6 bulan',
            'estimasi_biaya' => 'nullable|in:Rendah,Sedang,Tinggi',
            'catatan_status' => 'nullable|string|max:1000',
            'menggunakan_data_pribadi' => 'nullable|boolean',
            'jenis_data_sensitif' => 'nullable|string|max:150',
            'risiko_privasi' => 'nullable|in:Rendah,Sedang,Tinggi',
            'risiko_bias' => 'nullable|in:Rendah,Sedang,Tinggi',
            'risiko_ketergantungan_ai' => 'nullable|in:Rendah,Sedang,Tinggi',
            'risiko_kesalahan_output' => 'nullable|in:Rendah,Sedang,Tinggi',
            'perlu_validasi_manusia' => 'nullable|boolean',
            'perlu_persetujuan_pengguna' => 'nullable|boolean',
            'rekomendasi_mitigasi' => 'nullable|string|max:5000',
        ]);

        $useCase->update(Arr::except($validated, [
            'dampak', 'kelayakan', 'ketersediaan_data', 'kesiapan_sdm',
            'kesiapan_infrastruktur', 'urgensi', 'risiko_etika_skor',
            'kompleksitas_teknis', 'estimasi_waktu', 'estimasi_biaya',
            'catatan_status', 'menggunakan_data_pribadi', 'jenis_data_sensitif',
            'risiko_privasi', 'risiko_bias', 'risiko_ketergantungan_ai',
            'risiko_kesalahan_output', 'perlu_validasi_manusia',
            'perlu_persetujuan_pengguna', 'rekomendasi_mitigasi',
        ]));

        // Update atau buat penilaian prioritas kalau field skor dikirim
        if ($request->filled('dampak')) {
            $useCase->penilaianPrioritas()->updateOrCreate(
                ['use_case_id' => $useCase->id],
                Arr::only($validated, [
                    'dampak', 'kelayakan', 'ketersediaan_data',
                    'kesiapan_sdm', 'kesiapan_infrastruktur', 'urgensi',
                    'risiko_etika_skor', 'kompleksitas_teknis',
                    'estimasi_waktu', 'estimasi_biaya',
                ])
            );
        }

        if ($request->boolean('risiko_etika_dikirim')) {
            $useCase->risikoEtikaDetail()->updateOrCreate(
                ['use_case_id' => $useCase->id],
                [
                    'menggunakan_data_pribadi' => $request->boolean('menggunakan_data_pribadi'),
                    'jenis_data_sensitif' => $validated['jenis_data_sensitif'] ?? null,
                    'risiko_privasi' => $validated['risiko_privasi'] ?? null,
                    'risiko_bias' => $validated['risiko_bias'] ?? null,
                    'risiko_ketergantungan_ai' => $validated['risiko_ketergantungan_ai'] ?? null,
                    'risiko_kesalahan_output' => $validated['risiko_kesalahan_output'] ?? null,
                    'perlu_validasi_manusia' => $request->boolean('perlu_validasi_manusia'),
                    'perlu_persetujuan_pengguna' => $request->boolean('perlu_persetujuan_pengguna'),
                    'rekomendasi_mitigasi' => $validated['rekomendasi_mitigasi'] ?? null,
                ],
            );
        }

        return redirect()->route('use-cases.index')
            ->with('success', 'Use case berhasil diperbarui.');
    }

    public function destroy(UseCase $useCase): RedirectResponse
    {
        $useCase->delete();

        return redirect()->route('use-cases.index')
            ->with('success', 'Use case berhasil dihapus.');
    }

    public function analisisOtomatis(UseCase $useCase): JsonResponse
    {
        $text = strtolower(
            $useCase->nama_use_case.' '.$useCase->deskripsi.' '.
            $useCase->latar_belakang_masalah.' '.$useCase->tujuan_use_case.' '.
            $useCase->teknologi_ai
        );

        /** @param array<int, string> $tinggi @param array<int, string> $rendah */
        $hitung = function (array $tinggi, array $rendah, int $dasar = 3) use ($text): int {
            $skor = $dasar
                + collect($tinggi)->filter(fn ($k) => str_contains($text, $k))->count()
                - collect($rendah)->filter(fn ($k) => str_contains($text, $k))->count();

            return max(1, min(5, $skor));
        };

        return response()->json([
            'dampak' => $hitung(['seluruh mahasiswa', 'banyak pengguna', 'signifikan', 'kampus', 'fakultas', 'universitas'], ['individu', 'kecil', 'terbatas']),
            'kelayakan' => $hitung(['sudah tersedia', 'mudah', 'sederhana', 'existing'], ['kompleks', 'sulit', 'mahal']),
            'ketersediaan_data' => $hitung(['data tersedia', 'dataset', 'sudah ada data'], ['data pribadi', 'sensitif', 'belum ada data', 'privasi']),
            'kesiapan_sdm' => $hitung(['tim it', 'sdm memadai', 'siap'], ['sdm terbatas', 'kurang tenaga', 'belum ada tim']),
            'kesiapan_infrastruktur' => $hitung(['infrastruktur memadai', 'server tersedia', 'cloud'], ['belum ada infrastruktur', 'server terbatas']),
            'urgensi' => $hitung(['mendesak', 'urgent', 'penting', 'krisis', 'darurat'], ['tidak mendesak', 'opsional']),
            'risiko_etika_skor' => $hitung(['data pribadi', 'sensitif', 'privasi', 'bias', 'diskriminasi'], ['anonim', 'tanpa data pribadi']),
            'kompleksitas_teknis' => $hitung(['deep learning', 'machine learning canggih', 'kompleks', 'model besar'], ['sederhana', 'mudah diimplementasi']),
        ]);
    }

    private function generateKode(): string
    {
        $last = UseCase::orderByDesc('id')->first();
        $number = $last ? ((int) substr($last->kode, 2)) + 1 : 1;

        return 'UC'.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
    }

    public function export(Request $request): BinaryFileResponse
    {
        $allowedColumns = [
            'kode', 'nama_use_case', 'kategori', 'status', 'deskripsi',
            'pengusul', 'teknologi_ai', 'skor_prioritas', 'level_prioritas',
        ];

        $validated = $request->validate([
            'use_case_ids' => ['required', 'array', 'min:1'],
            'use_case_ids.*' => ['integer', 'distinct', 'exists:use_cases,id'],
            'columns' => ['required', 'array', 'min:1'],
            'columns.*' => ['string', 'distinct', Rule::in($allowedColumns)],
        ]);

        return Excel::download(
            new UseCaseExport($validated['use_case_ids'], $validated['columns']),
            'data-use-case-ai-'.now()->format('Y-m-d').'.xlsx'
        );
    }
}
