<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Hash;
use Helper;
use App\Models\Kota;
use App\Models\Opd;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        set_time_limit(0);
        $user = Auth::user();
        $data = User::where('id', '<>', $user->id);
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
        $data = $data->get();
        // dd($data);
        return view('daftar-pengguna', compact('data'));
    }

    public function change_role(Request $request)
    {
        $temp = [];
        $html = "";
        $user = Auth::user();
        if ($request->type == 3) {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => null];
        } elseif ($request->type == 4) {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => 'kota'];
            $temp[] = ['label' => 'Kota', 'wilayah' => [], 'labelNext' => null];
        } elseif ($request->type == 5) {
            $opdAll = Opd::doesntHave('users');
            $arrOpd = [];
            $opds = [];
            if (Auth::user()->id != 1) {
                if (Auth::user()->role == 3 || Helper::checkOpd('provinsi', $user)) {
                    $idWilayah = $user->role == 3 ? $user->province_id : $user->opd->provinsi_id;
                    $opds = Helper::getOpd('provinsi', $idWilayah, $opds);
                } elseif ($user->role == 4 || Helper::checkOpd('kota', $user)) {
                    $idWilayah = $user->role == 4 ? $user->regency_id : $user->opd->kabkota_id;
                    $opds = Helper::getOpd('kota', $idWilayah, $opds);
                } elseif (Helper::checkOpd('kecamatan', $user) || Helper::checkOpd('kelurahan', $user)) {
                    $idWilayah = Helper::checkOpd('kecamatan', $user) ? $user->opd->kecamatan_id : $user->opd->kelurahan_id ;
                    $opds = Helper::checkOpd('kecamatan', $user) ? Helper::getOpd('kecamatan', $idWilayah, $opds) : Helper::getOpd('kelurahan', $idWilayah, $opds);
                }
                foreach ($opds as $opd) {
                    $arrOpd[] = $opd->id;
                }
                $opdAll = $opdAll->whereIn('id', $arrOpd);
            }
            $opdAll = $opdAll->get();
            $temp[] = ['label' => 'OPD', 'wilayah' => $opdAll, 'labelNext' => null];
        }
        foreach ($temp as $item) {
            $label = $item['label'];
            $wilayah = $item['wilayah'];
            $labelNext = $item['labelNext'];
            $type = 'row';
            $html .= view('components.select-wilayah', compact('label', 'wilayah', 'labelNext', 'type'))->render();
        }
        return response()->json(array(
            'msg' => $html
        ), 200);
    }

    public function save(Request $request)
    {
        $username = strtolower($request->username);
        if ($request->id == 0) {
            $validated = $request->validate([
                'role' => 'required',
                'email' => 'unique:users,email,NULL,id,deleted_at,NULL',
            ]);
            $data = new User;
            $data->password = Hash::make($username);
            $data->role = (int)$request->role;
            $role_id = (int)$request->role;
            if ($role_id == 3) {
                $data->province_id = $request->provinsi_id;
            } elseif ($role_id == 4) {
                $data->regency_id = $request->kota_id;
            } elseif ($role_id == 5) {
                $data->opd_id = $request->opd_id;
            } elseif ($role_id == 6) {
                if (Auth::user()->role == 3) {
                    $data->province_id = Auth::user()->province_id;
                } elseif (Auth::user()->role == 4) {
                    $data->regency_id = Auth::user()->regency_id;
                } elseif (Auth::user()->role == 5) {
                    $data->opd_id = Auth::user()->opd_id;
                }

            }
            if (Auth::user()->role != 1) {
                $data->maker_id = Auth::user()->id;
            }
        } else {
            $data = User::findOrFail($request->id);
            $temp = User::where('id', '<>', $data->id)->where('username', $username)->count();
            if ($temp > 0) {
                return redirect()->back()->with('error', 'Username yang Anda masukkan sudah dipakai !');
            }
            $temp = User::where('id', '<>', $data->id)->where('email', $request->email)->count();
            if ($temp > 0) {
                return redirect()->back()->with('error', 'Email yang Anda masukkan sudah dipakai !');
            }
        }
        $data->name = $request->name;
        $data->username = $username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->jabatan_id = $request->jabatan_id;
        $data->golongan_id = $request->golongan_id;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function reset_pass(Request $request)
    {
        $data = User::findOrFail($request->id);
        $data->password = Hash::make($data->username);
        $data->save();
        return redirect()->back()->with('success', 'Password dengan username = '.$data->username.' berhasil di-reset !');
    }

    public function delete(Request $request)
    {
        $data = User::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}