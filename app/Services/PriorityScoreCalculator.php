<?php

namespace App\Services;

class PriorityScoreCalculator
{
    /**
     * @param  array<string, int>  $scores
     * @return array{score: int, level: string}
     */
    public function calculate(array $scores): array
    {
        $score = $scores['dampak']
            + $scores['kelayakan']
            + $scores['ketersediaan_data']
            + $scores['kesiapan_sdm']
            + $scores['kesiapan_infrastruktur']
            + $scores['urgensi']
            - $scores['risiko_etika_skor']
            - $scores['kompleksitas_teknis'];

        return [
            'score' => $score,
            'level' => match (true) {
                $score >= 8 => 'Tinggi',
                $score >= 4 => 'Sedang',
                default => 'Rendah',
            },
        ];
    }
}
