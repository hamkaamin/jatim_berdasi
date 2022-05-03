<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Hash;
use App\Models\Opd;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $data = User::where('id', '<>', Auth::user()->id)->get();
        return view('daftar-pengguna', compact('data'));
    }

    public function change_role(Request $request)
    {
        $temp = [];
        $html = "";
        if ($request->type == 3) {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => null];
        } elseif ($request->type == 4) {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => 'kota'];
            $temp[] = ['label' => 'Kota', 'wilayah' => [], 'labelNext' => null];
        } elseif ($request->type == 5) {
            $temp[] = ['label' => 'OPD', 'wilayah' => Opd::doesntHave('users')->get(), 'labelNext' => null];
        }
        foreach ($temp as $item) {
            $label = $item['label'];
            $wilayah = $item['wilayah'];
            $labelNext = $item['labelNext'];
            $html .= view('components.select-wilayah', compact('label', 'wilayah', 'labelNext'))->render();
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
                'username' => 'unique:users,username',
                'email' => 'unique:users,email',
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
