<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KategoriInovasi extends Model
{
    use HasFactory;

    public function indikators()
    {
        return $this->hasMany(Indikator::class, 'kategori_id', 'id');
    }

    public function tahapan()
    {
        return $this->hasMany(KategoriTahapan::class, 'kategori_id', 'id');
    }
    public function opd()
    {
        return $this->hasMany(KategoriOpd::class, 'kategori_id', 'id');
    }
    public function hasManyInovasi()
    {
        return $this->hasMany('App\Models\Inovasi', 'kategori_id', 'id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'kategori_id', 'id')->orderBy('id', 'asc');
    }

    public function juris()
    {
        return $this->hasMany(Juri::class, 'kategori_id', 'id');
    }

    public static function get_penilaian_inovasi($jenis,$kategori_id)
    {
        if($jenis == 'iga'){
                $inovasi = Inovasi::where('label',0)->where('status',2)->where('kategori_id',$kategori_id)->where('tahun',Auth::user()->tahun)->get()
                ->sortByDesc(function ($item) {
                    $jurisCount = sizeof($item->kategori->juris);
                    $totalNilai = $item->penilaian->sum('pivot.nilai');
                    return $jurisCount > 0 ? $totalNilai / $jurisCount : 0;
                });
        }else if($jenis == 'inotek'){
            $inovasi = Inovasi::with(['kategori.juris', 'penilaian']) // Load relasi
            ->where('label', 1)
            ->where('status', 2)
            ->where('kategori_id',$kategori_id)
            ->where('tahun',Auth::user()->tahun)
            ->get() // Ambil data dulu
            ->sortByDesc(function ($item) {
                $jurisCount = sizeof($item->kategori->juris);
                $totalNilai = $item->penilaian->sum('pivot.nilai');
                return $jurisCount > 0 ? $totalNilai / $jurisCount : 0;
            });
        }
        return $inovasi;
    }
}