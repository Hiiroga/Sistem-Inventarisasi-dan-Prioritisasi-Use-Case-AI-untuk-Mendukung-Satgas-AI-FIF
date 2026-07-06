<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategories';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function useCases()
    {
        return $this->hasMany(UseCase::class, 'kategori_id');
    }
}