<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UseCase extends Model
{
    protected $table = 'use_cases';

    protected $fillable = [
        'user_id', 'kode', 'nama_use_case', 'deskripsi', 'latar_belakang_masalah',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(UseCaseStatusHistory::class)->latest();
    }

    protected static function booted(): void
    {
        static::created(function (UseCase $useCase): void {
            $useCase->statusHistories()->create([
                'changed_by' => auth()->id(),
                'status_baru' => $useCase->status,
                'catatan' => 'Use case dibuat.',
            ]);
        });

        static::updated(function (UseCase $useCase): void {
            if (! $useCase->wasChanged('status')) {
                return;
            }

            $useCase->statusHistories()->create([
                'changed_by' => auth()->id(),
                'status_sebelumnya' => $useCase->getOriginal('status'),
                'status_baru' => $useCase->status,
                'catatan' => request()->input('catatan_status'),
            ]);
        });
    }
}
