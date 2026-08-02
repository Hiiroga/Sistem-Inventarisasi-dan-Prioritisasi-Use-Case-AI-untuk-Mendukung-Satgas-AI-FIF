<?php

namespace App\Exports;

use App\Models\UseCase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * @implements WithMapping<UseCase>
 */
class UseCaseExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    /**
     * @param  array<int, int>  $useCaseIds
     * @param  array<int, string>  $columns
     */
    public function __construct(
        private readonly array $useCaseIds,
        private readonly array $columns,
    ) {}

    /** @var array<string, string> */
    private const HEADINGS = [
        'kode' => 'Kode',
        'nama_use_case' => 'Nama Use Case',
        'kategori' => 'Kategori',
        'status' => 'Status',
        'deskripsi' => 'Deskripsi',
        'pengusul' => 'Pengusul',
        'teknologi_ai' => 'Teknologi AI',
        'skor_prioritas' => 'Skor Prioritas',
        'level_prioritas' => 'Level Prioritas',
    ];

    /** @return Collection<int, UseCase> */
    public function collection(): Collection
    {
        return UseCase::with(['kategori', 'penilaianPrioritas'])
            ->whereIn('id', $this->useCaseIds)
            ->get()
            ->sortBy(fn (UseCase $useCase) => array_search($useCase->id, $this->useCaseIds, true))
            ->values();
    }

    /** @return array<int, string> */
    public function headings(): array
    {
        return array_map(fn (string $column) => self::HEADINGS[$column], $this->columns);
    }

    /** @return array<int, mixed> */
    public function map(mixed $useCase): array
    {
        $p = $useCase->penilaianPrioritas;

        $values = [
            'kode' => $useCase->kode,
            'nama_use_case' => $useCase->nama_use_case,
            'kategori' => $useCase->kategori->nama_kategori ?? '-',
            'status' => $useCase->status,
            'deskripsi' => $useCase->deskripsi,
            'pengusul' => $useCase->pengusul,
            'teknologi_ai' => $useCase->teknologi_ai ?: '-',
            'skor_prioritas' => $p->skor_prioritas ?? '-',
            'level_prioritas' => $p->level_prioritas ?? '-',
        ];

        return array_map(fn (string $column) => $values[$column], $this->columns);
    }

    /** @return array<int|string, mixed> */
    public function styles(Worksheet $sheet): array
    {
        $lastColumn = Coordinate::stringFromColumnIndex(count($this->columns));
        $headingRange = "A1:{$lastColumn}1";

        $sheet->getStyle($headingRange)->getFont()->setBold(true);
        $sheet->getStyle($headingRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E52521');
        $sheet->getStyle($headingRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headingRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
