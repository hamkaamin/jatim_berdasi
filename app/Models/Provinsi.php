<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function kota()
    {
        return $this->hasMany('App\Models\Kota', 'province_id', 'id');
    }
}
