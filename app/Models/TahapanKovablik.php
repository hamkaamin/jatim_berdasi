<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahapanKovablik extends Model
{
    use HasFactory, SoftDeletes;

    public function kategoriNilais()
    {
        return $this->hasMany(KategoriNilaiKovablik::class, 'tahapan_id');
    }

    public function proposals()
    {
        return $this->hasMany(ProposalKovablik::class, 'tahapan_id');
    }
}
