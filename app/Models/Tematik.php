<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tematik extends Model
{
    use HasFactory;

    public function detailTematiks()
    {
        return $this->hasMany('App\Models\DetailTematik', 'tematik_id', 'id');
    }
}