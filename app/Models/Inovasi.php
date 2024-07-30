<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inovasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];


    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }

    public function inisiator()
    {
        return $this->belongsTo('App\Models\Inisiator', 'inisiator_id', 'id')->withTrashed();
    }

    public function jenis()
    {
        return $this->belongsTo('App\Models\Jenis', 'jenis_id', 'id')->withTrashed();
    }

    public function bentuk()
    {
        return $this->belongsTo('App\Models\Bentuk', 'bentuk_id', 'id')->withTrashed();
    }

    public function belongsToTahapan()
    {
        return $this->belongsTo('App\Models\Tahapan', 'tahapan_id', 'id')->withTrashed();
    }

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'provinsi_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo('App\Models\Kota', 'kota_id', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'kecamatan_id', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo('App\Models\Kelurahan', 'kelurahan_id', 'id');
    }

    public function urusan()
    {
        return $this->belongsToMany('App\Models\Urusan', 'urusan_inovasi', 'inovasi_id', 'urusan_id')->withTrashed();
    }

    public function tahapan()
    {
        return $this->belongsToMany('App\Models\Tahapan', 'tahapan_inovasi', 'inovasi_id', 'tahapan_id')->withPivot('waktu')->withTrashed();
    }

    public function indikator()
    {
        return $this->belongsToMany('App\Models\Indikator', 'indikator_inovasi', 'inovasi_id', 'indikator_id')->withPivot('param_awal', 'param_akhir', 'bobot_awal', 'bobot_akhir', 'catatan')->withTrashed();
    }

    public function upload()
    {
        return $this->hasMany('App\Models\Upload', 'inovasi_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Models\KategoriInovasi', 'kategori_id', 'id');
    }
}