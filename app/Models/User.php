<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; // this sould be imported

class User extends Authenticatable implements JWTSubject 
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    public function opd()
    {
        return $this->belongsTo('App\Models\Opd', 'opd_id', 'id')->withTrashed();
    }

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'province_id', 'id');
    }

    public function kota()
    {
        return $this->belongsTo('App\Models\Kota', 'regency_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [
        'username'=>$this->username,
        'name'=>$this->name
      ];
    }
}