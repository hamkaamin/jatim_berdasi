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
    public function hasManyInovasi()
    {
        return $this->hasMany('App\Models\Inovasi', 'kategori_id', 'id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'kategori_id', 'id');
    }

    public function juris()
    {
        return $this->hasMany(Juri::class, 'kategori_id', 'id');
    }
}