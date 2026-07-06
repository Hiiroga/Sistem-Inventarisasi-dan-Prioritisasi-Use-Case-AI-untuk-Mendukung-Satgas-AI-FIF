<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UseCase extends Model
{
    protected $table = 'use_cases';

    protected $fillable = [
        'kode', 'nama_use_case', 'deskripsi', 'latar_belakang_masalah',
        'tujuan_use_case', 'pengusul', 'unit_terkait', 'target_pengguna',
        'kategori_id', 'teknologi_ai', 'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function penilaianPrioritas()
    {
        return $this->hasOne(PenilaianPrioritas::class, 'use_case_id');
    }

    public function risikoEtikaDetail()
    {
        return $this->hasOne(RisikoEtikaDetail::class, 'use_case_id');
    }
}