<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'regency_id', 'id');
    }

    public function kelurahan()
    {
        return $this->hasMany('App\Models\Kelurahan', 'district_id', 'id');
    }
}
