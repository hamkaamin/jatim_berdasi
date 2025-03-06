<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKovablik extends Model
{
    use HasFactory;
    protected $table = 'kategori_kovabliks';

    public function hasManyKovablik()
    {
        return $this->hasMany('App\Models\ProposalKovablik', 'kategori_id', 'id');
    }
}
