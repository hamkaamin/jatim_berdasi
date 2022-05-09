<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tahapan extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    public function hasManyInovasi()
    {
        return $this->hasMany('App\Models\Inovasi', 'tahapan_id', 'id');
    }

    public function belongsToManyInovasi()
    {
        return $this->belongsToMany('App\Models\Inovasi', 'tahapan_inovasi', 'tahapan_id', 'inovasi_id')->withPivot('waktu');
    }
}
