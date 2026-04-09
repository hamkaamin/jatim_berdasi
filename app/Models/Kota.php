<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'regencies';

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_id', 'id');
    }

    public function kecamatan()
    {
        return $this->hasMany('App\Models\Kecamatan', 'regency_id', 'id');
    }

    public function inovasi()
    {
        return $this->hasMany('App\Models\Inovasi', 'kota_id', 'id');
    }
}
