<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'villages';

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function kelurahan()
    {
        return $this->hasMany('App\Models\Kelurahan', 'district_id', 'id');
    }
}
