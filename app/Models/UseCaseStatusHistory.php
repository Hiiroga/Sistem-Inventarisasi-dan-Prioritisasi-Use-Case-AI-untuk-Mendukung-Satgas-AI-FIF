<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UseCaseStatusHistory extends Model
{
    protected $fillable = [
        'use_case_id', 'changed_by', 'status_sebelumnya', 'status_baru', 'catatan',
    ];

    public function useCase()
    {
        return $this->belongsTo(UseCase::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
