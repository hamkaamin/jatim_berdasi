<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKovablikMap extends Model
{
    use HasFactory;

    public function kovablik()
    {
        return $this->belongsTo(ProposalKovablik::class, 'proposal_id', 'id');
    }

    public function juri()
    {
        return $this->belongsTo(Juri::class, 'juri_id', 'id');
    }
}
