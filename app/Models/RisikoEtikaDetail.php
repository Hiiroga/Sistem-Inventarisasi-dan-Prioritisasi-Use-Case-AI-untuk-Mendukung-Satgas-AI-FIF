<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RisikoEtikaDetail extends Model
{
    protected $table = 'risiko_etika_details';

    protected $fillable = [
        'use_case_id', 'menggunakan_data_pribadi', 'jenis_data_sensitif',
        'risiko_privasi', 'risiko_bias', 'risiko_ketergantungan_ai',
        'risiko_kesalahan_output', 'perlu_validasi_manusia',
        'perlu_persetujuan_pengguna', 'rekomendasi_mitigasi',
    ];

    protected $casts = [
        'menggunakan_data_pribadi' => 'boolean',
        'perlu_validasi_manusia' => 'boolean',
        'perlu_persetujuan_pengguna' => 'boolean',
    ];

    public function useCase()
    {
        return $this->belongsTo(UseCase::class, 'use_case_id');
    }
}