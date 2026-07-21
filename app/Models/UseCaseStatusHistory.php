<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UseCaseStatusHistory extends Model
{
    protected $fillable = [
        'use_case_id', 'changed_by', 'status_sebelumnya', 'status_baru', 'catatan',
    ];

    /** @return BelongsTo<UseCase, $this> */
    public function useCase(): BelongsTo
    {
        return $this->belongsTo(UseCase::class);
    }

    /** @return BelongsTo<User, $this> */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
