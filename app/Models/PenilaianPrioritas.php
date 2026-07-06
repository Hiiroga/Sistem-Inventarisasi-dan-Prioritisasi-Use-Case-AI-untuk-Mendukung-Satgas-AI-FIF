<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function useCase()
    {
        return $this->belongsTo(UseCase::class, 'use_case_id');
    }

    protected static function booted()
    {
        static::saving(function (PenilaianPrioritas $item) {
            if (
                $item->dampak !== null &&
                $item->kelayakan !== null &&
                $item->ketersediaan_data !== null &&
                $item->kesiapan_sdm !== null &&
                $item->urgensi !== null &&
                $item->risiko_etika_skor !== null &&
                $item->kompleksitas_teknis !== null
            ) {
                $item->skor_prioritas = $item->dampak + $item->kelayakan
                    + $item->ketersediaan_data + $item->kesiapan_sdm
                    + $item->urgensi - $item->risiko_etika_skor
                    - $item->kompleksitas_teknis;

                $item->level_prioritas = match (true) {
                    $item->skor_prioritas >= 8 => 'Tinggi',
                    $item->skor_prioritas >= 4 => 'Sedang',
                    default => 'Rendah',
                };
            }
        });
    }
}