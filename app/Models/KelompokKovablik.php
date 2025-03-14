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
        return $this->hasMany('App\Models\ProposalKovablik', 'kategori_id', 'id');
    }
}
