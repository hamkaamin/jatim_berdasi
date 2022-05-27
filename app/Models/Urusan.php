<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urusan extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function inovasi()
    {
        return $this->belongsToMany(Inovasi::class, 'urusan_inovasi', 'urusan_id', 'inovasi_id');
    }
}
