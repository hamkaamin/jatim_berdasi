<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
