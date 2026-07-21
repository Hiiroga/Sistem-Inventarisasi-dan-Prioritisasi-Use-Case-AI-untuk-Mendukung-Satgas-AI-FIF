<?php

namespace App\Models;

use App\Services\PriorityScoreCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianPrioritas extends Model
{
    protected $table = 'penilaian_prioritas';

    protected $fillable = [
        'use_case_id', 'dampak', 'kelayakan', 'ketersediaan_data',
        'kesiapan_sdm', 'kesiapan_infrastruktur', 'urgensi',
        'risiko_etika_skor', 'kompleksitas_teknis',
        'estimasi_waktu', 'estimasi_biaya',
        'skor_prioritas', 'level_prioritas',
    ];

    /** @return BelongsTo<UseCase, $this> */
    public function useCase(): BelongsTo
    {
        return $this->belongsTo(UseCase::class, 'use_case_id');
    }

    protected static function booted(): void
    {
        static::saving(function (PenilaianPrioritas $item): void {
            if (
                $item->dampak !== null &&
                $item->kelayakan !== null &&
                $item->ketersediaan_data !== null &&
                $item->kesiapan_sdm !== null &&
                $item->kesiapan_infrastruktur !== null &&
                $item->urgensi !== null &&
                $item->risiko_etika_skor !== null &&
                $item->kompleksitas_teknis !== null
            ) {
                $result = app(PriorityScoreCalculator::class)->calculate([
                    'dampak' => $item->dampak,
                    'kelayakan' => $item->kelayakan,
                    'ketersediaan_data' => $item->ketersediaan_data,
                    'kesiapan_sdm' => $item->kesiapan_sdm,
                    'kesiapan_infrastruktur' => $item->kesiapan_infrastruktur,
                    'urgensi' => $item->urgensi,
                    'risiko_etika_skor' => $item->risiko_etika_skor,
                    'kompleksitas_teknis' => $item->kompleksitas_teknis,
                ]);

                $item->skor_prioritas = $result['score'];
                $item->level_prioritas = $result['level'];
            }
        });
    }
}
