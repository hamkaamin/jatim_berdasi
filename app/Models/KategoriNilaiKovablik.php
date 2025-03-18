<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriNilaiKovablik extends Model
{
    use HasFactory, SoftDeletes;

    public function tahapans()
    {
        return $this->belongsTo(TahapanKovablik::class, 'tahapan_id');
    }
}
