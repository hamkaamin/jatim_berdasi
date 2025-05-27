<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class KelompokKovablik extends Model
{
    use HasFactory;
    protected $table = 'kelompok_kovabliks';

    public function hasManyKovablik()
    {
        return $this->hasMany(ProposalKovablik::class, 'kelompok_id', 'id');
    }

    public function tahapan()
    {
        return $this->belongsToMany(TahapanKovablik::class, 'proposal_kovabliks', 'kelompok_id', 'tahapan_id')
            ->distinct();
    }

    public function juris()
    {
        return $this->hasMany(JuriKovablik::class, 'kelompok_id', 'id');
    }

    public function verifikators()
    {
        return $this->hasMany(VerifikatorKovablik::class, 'kelompok_id', 'id');
    }

    public static function get_penilaian_kovablik($kelompok_id, $juri_tahap)
    {
        $kovablik = ProposalKovablik::with(['kelompok.juris', 'penilaian'])
            ->where('status', 2)
            ->where('kelompok_id', $kelompok_id)
            ->where('tahun', Auth::user()->tahun)
            ->where('juri_tahap', '!=', 0)
            ->where('juri_tahap', $juri_tahap)
            ->get() // Ambil data dulu
            ->sortByDesc(function ($item) {
                $jurisCount = sizeof($item->kelompok->juris);
                $totalNilai = $item->penilaian->sum('pivot.nilai');
                return $jurisCount > 0 ? $totalNilai / $jurisCount : 0;
            });
        return $kovablik;
    }
}
