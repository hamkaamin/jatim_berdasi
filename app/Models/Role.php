<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Helper;

class Role extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'id');
    }

    public static function get_user ($request, $role_id)
    {
        $user = Auth::user();
        $data = User::where('id', '<>', 0);
        if ($user->role != 1 && $user->role != 2) {
            $data = $data->whereNotIn('role', [1,2]);
            $arrOpd = [];
            $opds = [];
            if ($user->role == 3 || Helper::checkOpd('provinsi', $user)) {
                $arrKota = [];
                $idWilayah = $user->role == 3 ? $user->province_id : $user->opd->provinsi_id;
                $provinsi = Provinsi::findOrFail($idWilayah);
                $opds = (isset($request->scope) && $request->scope != null && $request->{$request->scope.'_id'} != null) ? Helper::getOpd($request->scope, $request->{$request->scope.'_id'}, $opds) : Helper::getOpd('provinsi', $idWilayah, $opds);
                foreach ($provinsi->kota()->get() as $kota) {
                    $arrKota[] = $kota->id;
                }
                foreach ($opds as $opd) {
                    $arrOpd[] = $opd->id;
                }
                $data = $data->where(function($query) use ($user, $arrKota, $arrOpd, $idWilayah){
                    $query->where('maker_id', $user->id)->orWhere('province_id', $idWilayah)->orWhereIn('regency_id', $arrKota)->orWhereIn('opd_id', $arrOpd);
                });
            } elseif ($user->role == 4 || Helper::checkOpd('kota', $user)) {
                $idWilayah = $user->role == 4 ? $user->regency_id : $user->opd->kabkota_id;
                $opds = (isset($request->scope) && $request->scope != null && $request->{$request->scope.'_id'} != null) ? Helper::getOpd($request->scope, $request->{$request->scope.'_id'}, $opds) : Helper::getOpd('kota', $idWilayah, $opds);
                foreach ($opds as $opd) {
                    $arrOpd[] = $opd->id;
                }
                $data = $data->where(function($query) use ($user, $arrOpd, $idWilayah){
                    $query->where('maker_id', $user->id)->orWhere('regency_id', $idWilayah)->orWhereIn('opd_id', $arrOpd);
                });
            } elseif (Helper::checkOpd('kecamatan', $user) || Helper::checkOpd('kelurahan', $user)) {
                $idWilayah = Helper::checkOpd('kecamatan', $user) ? $user->opd->kecamatan_id : $user->opd->kelurahan_id ;
                $opds = Helper::checkOpd('kecamatan', $user) ? Helper::getOpd('kecamatan', $idWilayah, $opds) : Helper::getOpd('kelurahan', $idWilayah, $opds);
                $opds = (isset($request->scope) && $request->scope != null && $request->{$request->scope.'_id'} != null) ? Helper::getOpd($request->scope, $request->{$request->scope.'_id'}, $opds) : $opds;
                foreach ($opds as $opd) {
                    $arrOpd[] = $opd->id;
                }
                $data = $data->where(function($query) use ($user, $arrOpd){
                    $query->where('maker_id', $user->id)->orWhereIn('opd_id', $arrOpd);
                });
            } elseif ($user->role == 6) {
                $idWilayah = "";
                if ($user->province_id != null) {
                    $idWilayah = $user->province_id;
                    $data = $data->where(function($query) use ($user, $idWilayah){
                        $query->where('maker_id', $user->id)->orWhere('province_id', $idWilayah);
                    });
                } elseif ($user->regency_id != null) {
                    $idWilayah = $user->regency_id;
                    $data = $data->where(function($query) use ($user, $idWilayah){
                        $query->where('maker_id', $user->id)->orWhere('regency_id', $idWilayah);
                    });
                } elseif ($user->opd_id != null) {
                    $idWilayah = $user->opd_id;
                    $data = $data->where(function($query) use ($user, $idWilayah){
                        $query->where('maker_id', $user->id)->orWhere('opd_id', $idWilayah);
                    });
                }

            }
        }
        $data = $data->where('role', $role_id)->limit(10)->get(); 
        
        return $data;
    }
}