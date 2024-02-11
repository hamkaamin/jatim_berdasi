<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriInvoasi extends Model
{
    use HasFactory;

    public function indikators()
    {
        return $this->hasMany(Indikator::class, 'kategori_id', 'id');
    }
}