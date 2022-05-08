<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inovasi extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function belongsToTahapan()
    {
        return $this->belongsTo('App\Models\Tahapan', 'tahapan_id', 'id');
    }

    public function urusan()
    {
        return $this->belongsToMany('App\Models\Urusan', 'urusan_inovasi', 'inovasi_id', 'urusan_id');
    }

    public function tahapan()
    {
        return $this->belongsToMany('App\Models\Tahapan', 'tahapan_inovasi', 'inovasi_id', 'tahapan_id')->withPivot('waktu');
    }

    public function indikator()
    {
        return $this->belongsToMany('App\Models\Indikator', 'indikator_inovasi', 'inovasi_id', 'indikator_id')->withPivot('param_awal', 'param_akhir', 'bobot_awal', 'bobot_akhir');
    }

    public function upload()
    {
        return $this->hasMany('App\Models\Upload', 'inovasi_id', 'id');
    }
}
