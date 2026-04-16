<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuriKovablik extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function penilaianMap()
    {
        return $this->hasMany(PenilaianKovablikMap::class, 'juri_id', 'id');
    }
}
