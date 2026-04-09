<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bentuk extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function inovasi()
    {
        return $this->hasMany(Inovasi::class, 'bentuk_id', 'id');
    }
}
