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
        return $this->belongsTo(Integration::class, 'kab_integration_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKovablik::class, 'kategori_id', 'id');
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokKovablik::class, 'kelompok_id', 'id');
    }

    public function tahapan()
    {
        return $this->belongsTo(TahapanKovablik::class, 'tahapan_id');
    }

    public function penilaian()
    {
        return $this->belongsToMany(KategoriNilaiKovablik::class, 'penilaian_kovabliks', 'proposal_id', 'penilaian_id')
            ->withPivot('user_id', 'catatan_saran', 'nilai', 'juri_tahap');
    }
}
