<?php

namespace App\Exports;

use App\Models\UseCase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * @implements WithMapping<UseCase>
 */
class UseCaseExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    /** @return Collection<int, UseCase> */
    public function collection(): Collection
    {
        return UseCase::with(['kategori', 'penilaianPrioritas'])->get();
    }

    /** @return array<int, string> */
    public function headings(): array
    {
        return [
            'Kode', 'Nama Use Case', 'Deskripsi', 'Latar Belakang Masalah',
            'Tujuan Use Case', 'Pengusul', 'Unit Terkait', 'Target Pengguna',
            'Kategori', 'Teknologi AI', 'Status',
            'Dampak', 'Kelayakan', 'Ketersediaan Data', 'Kesiapan SDM',
            'Kesiapan Infrastruktur', 'Urgensi', 'Risiko Etika', 'Kompleksitas Teknis',
            'Estimasi Waktu', 'Estimasi Biaya', 'Skor Prioritas', 'Level Prioritas',
        ];
    }

    /** @return array<int, mixed> */
    public function map(mixed $useCase): array
    {
        $p = $useCase->penilaianPrioritas;

        return [
            $useCase->kode,
            $useCase->nama_use_case,
            $useCase->deskripsi,
            $useCase->latar_belakang_masalah,
            $useCase->tujuan_use_case,
            $useCase->pengusul,
            $useCase->unit_terkait,
            $useCase->target_pengguna,
            $useCase->kategori->nama_kategori ?? '-',
            $useCase->teknologi_ai,
            $useCase->status,
            $p->dampak ?? '-',
            $p->kelayakan ?? '-',
            $p->ketersediaan_data ?? '-',
            $p->kesiapan_sdm ?? '-',
            $p->kesiapan_infrastruktur ?? '-',
            $p->urgensi ?? '-',
            $p->risiko_etika_skor ?? '-',
            $p->kompleksitas_teknis ?? '-',
            $p->estimasi_waktu ?? '-',
            $p->estimasi_biaya ?? '-',
            $p->skor_prioritas ?? '-',
            $p->level_prioritas ?? '-',
        ];
    }

    /** @return array<int|string, mixed> */
    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A1:W1')->getFont()->setBold(true);
        $sheet->getStyle('A1:W1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('2E5395');
        $sheet->getStyle('A1:W1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:W1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
