<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'provinsi_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo('App\Models\Kota', 'kabkota_id', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'kecamatan_id', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo('App\Models\Kelurahan', 'kelurahan_id', 'id');
    }

    public function maker()
    {
        return $this->belongsTo('App\Models\User', 'maker_id', 'id')->withTrashed();
    }

    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updater_id', 'id')->withTrashed();
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'opd_id', 'id');
    }
}
