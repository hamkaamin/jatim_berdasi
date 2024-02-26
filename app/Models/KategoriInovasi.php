<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriInovasi extends Model
{
    use HasFactory;

    public function indikators()
    {
        return $this->hasMany(Indikator::class, 'kategori_id', 'id');
    }

    public function tahapan()
    {
        return $this->hasMany(KategoriTahapan::class, 'kategori_id', 'id');
    }
    public function opd()
    {
        return $this->hasMany(KategoriOpd::class, 'kategori_id', 'id');
    }
}