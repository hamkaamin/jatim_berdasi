<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indikator extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function param()
    {
        return $this->hasMany('App\Models\Parameter', 'indikator_id', 'id');
    }

    public function upload()
    {
        return $this->hasMany(Upload::class, 'indikator_id', 'id');
    }
}
