<?php

namespace Tests\Unit;

use App\Services\PriorityScoreCalculator;
use PHPUnit\Framework\TestCase;

class PriorityScoreCalculatorTest extends TestCase
{
    public function test_it_calculates_score_and_level_consistently(): void
    {
        $result = (new PriorityScoreCalculator)->calculate([
            'dampak' => 3,
            'kelayakan' => 3,
            'ketersediaan_data' => 3,
            'kesiapan_sdm' => 3,
            'kesiapan_infrastruktur' => 5,
            'urgensi' => 3,
            'risiko_etika_skor' => 3,
            'kompleksitas_teknis' => 3,
        ]);

        $this->assertSame(['score' => 14, 'level' => 'Tinggi'], $result);
    }
}
