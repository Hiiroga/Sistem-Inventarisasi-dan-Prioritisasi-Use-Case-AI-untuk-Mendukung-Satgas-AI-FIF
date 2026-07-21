<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read Kategori|null $kategori
 * @property-read PenilaianPrioritas|null $penilaianPrioritas
 * @property-read RisikoEtikaDetail|null $risikoEtikaDetail
 */
class UseCase extends Model
{
    protected $table = 'use_cases';

    protected $fillable = [
        'user_id', 'kode', 'nama_use_case', 'deskripsi', 'latar_belakang_masalah',
        'tujuan_use_case', 'pengusul', 'unit_terkait', 'target_pengguna',
        'kategori_id', 'teknologi_ai', 'status',
    ];

    /** @return BelongsTo<Kategori, $this> */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /** @return HasOne<PenilaianPrioritas, $this> */
    public function penilaianPrioritas(): HasOne
    {
        return $this->hasOne(PenilaianPrioritas::class, 'use_case_id');
    }

    /** @return HasOne<RisikoEtikaDetail, $this> */
    public function risikoEtikaDetail(): HasOne
    {
        return $this->hasOne(RisikoEtikaDetail::class, 'use_case_id');
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return HasMany<UseCaseStatusHistory, $this> */
    public function statusHistories(): HasMany
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
