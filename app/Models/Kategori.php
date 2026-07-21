<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategories';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    /** @return HasMany<UseCase, $this> */
    public function useCases(): HasMany
    {
        return $this->hasMany(UseCase::class, 'kategori_id');
    }
}
