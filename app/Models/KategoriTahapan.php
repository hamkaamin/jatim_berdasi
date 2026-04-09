<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTahapan extends Model
{
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo('App\Models\KategoriInovasi', 'kategori_id', 'id');
    }
    public function tahapan()
    {
        return $this->belongsTo('App\Models\Tahapan', 'tahapan_id', 'id');
    }
}