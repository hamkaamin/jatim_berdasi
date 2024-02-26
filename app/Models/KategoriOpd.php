<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriOpd extends Model
{
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo('App\Models\KategoriInovasi', 'kategori_id', 'id');
    }
    public function opd()
    {
        return $this->belongsTo('App\Models\Opd', 'opd_id', 'id');
    }
}