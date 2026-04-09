<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefinisiOperasional extends Model
{
    use HasFactory;
    public function kategori()
    {
        return $this->belongsTo('App\Models\KategoriInovasi', 'kategori_id', 'id');
    }
    public function indikator()
    {
        return $this->belongsTo('App\Models\Indikator', 'indikator_id', 'id');
    }
}