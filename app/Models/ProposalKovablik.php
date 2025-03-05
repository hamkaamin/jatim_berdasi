<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalKovablik extends Model
{
    use HasFactory, SoftDeletes;


    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function integration()
    {
        return $this->belongsTo('App\Models\Integration', 'kab_integration_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
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

    public function kategori()
    {
        return $this->belongsTo('App\Models\KategoriKovablik', 'kategori_id', 'id');
    }

    public function kelompok()
    {
        return $this->belongsTo('App\Models\KelompokKovablik', 'kelompok_id', 'id');
    }
}
