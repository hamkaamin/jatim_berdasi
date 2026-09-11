<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriNilaiKovablik extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::deleting(function ($node) {
            foreach ($node->children as $child) {
                $child->delete(); // rekursif via event -> cascade soft-delete penuh
            }
        });
    }

    public function tahapans()
    {
        return $this->belongsTo(TahapanKovablik::class, 'tahapan_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('id');
    }
}
