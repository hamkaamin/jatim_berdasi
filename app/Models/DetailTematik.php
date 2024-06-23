<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTematik extends Model
{
    use HasFactory;
    // add relation tematik using tematik_id as foreign key
    public function tematik()
    {
        return $this->belongsTo(Tematik::class, 'tematik_id', 'id');
    }
}