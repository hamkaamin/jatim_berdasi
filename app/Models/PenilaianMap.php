<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianMap extends Model
{
    use HasFactory;

    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class, 'inovasi_id', 'id');
    }

    public function juri()
    {
        return $this->belongsTo(Juri::class, 'juri_id', 'id');
    }
}