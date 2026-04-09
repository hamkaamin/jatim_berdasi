<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Helper;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Opd;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if (isset($request->scope) && $request->scope != null && $request->{$request->scope.'_id'} != null) {
            $data = Helper::getOpd($request->scope, $request->{$request->scope.'_id'}, $data);
            return view('daftar-opd', compact('data'));
        }
        if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) {
            $data = Opd::all();
        } elseif (Auth::user()->role == 3) {
            $data = Helper::getOpd('provinsi', Auth::user()->province_id, $data);
        } elseif (Auth::user()->role == 4) {
            $data = Helper::getOpd('kota', Auth::user()->regency_id, $data);
        } elseif (Helper::checkOpd('provinsi', Auth::user())) {
            $data = Helper::getOpd('provinsi', Auth::user()->opd->provinsi_id, $data);
        } elseif (Helper::checkOpd('kota', Auth::user())) {
            $data = Helper::getOpd('kota', Auth::user()->opd->kabkota_id, $data);
        } elseif (Helper::checkOpd('kecamatan', Auth::user())) {
            $data = Helper::getOpd('kecamatan', Auth::user()->opd->kecamatan_id, $data);
        } elseif (Helper::checkOpd('kelurahan', Auth::user())) {
            $data = Helper::getOpd('kelurahan', Auth::user()->opd->kelurahan_id, $data);
        }
        return view('daftar-opd', compact('data'));
    }

    public function change_scope(Request $request)
    {
        // Label harus satu kata & tanpa karakter spesial !
        // Label disamakan dengan value LabelNext, tapi kalau Label ada uppercase nya
        // Value LabelNext hardcoded
        $temp = [];
        $dataProvinsi = Provinsi::all();
        $dataKota = [];
        $dataKecamatan = [];
        $dataKelurahan = [];
        if (Auth::user()->role == 3) {
            $dataProvinsi = Provinsi::where('id', Auth::user()->province_id)->get();
        } elseif (Helper::checkOpd('provinsi', Auth::user())) {
            $dataProvinsi = Provinsi::where('id', Auth::user()->opd->provinsi_id)->get();
        }
        if (Auth::user()->role == 4) {
            $dataKota = Kota::where('id', Auth::user()->regency_id)->get();
        } elseif (Helper::checkOpd('kota', Auth::user())) {
            $dataKota = Kota::where('id', Auth::user()->opd->kabkota_id)->get();
        }
        if (Helper::checkOpd('kecamatan', Auth::user())) {
            $dataKecamatan = Kecamatan::where('id', Auth::user()->opd->kecamatan_id)->get();
        } elseif (Helper::checkOpd('kelurahan', Auth::user())) {
            $dataKelurahan = Kelurahan::where('id', Auth::user()->opd->kelurahan_id)->get();
        }
        if ($request->type == 'provinsi') {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => $dataProvinsi, 'labelNext' => null];
        } else {
            if (in_array(Auth::user()->role, [1,2,3]) || Helper::checkOpd('provinsi', Auth::user())) {
                $temp[] = ['label' => 'Provinsi', 'wilayah' => $dataProvinsi, 'labelNext' => 'kota'];
            }
            if ($request->type == 'kota') {
                $temp[] = ['label' => 'Kota', 'wilayah' => $dataKota, 'labelNext' => null];
            } else {
                if (in_array(Auth::user()->role, [1,2,3]) || Auth::user()->role == 4 || Helper::checkOpd('provinsi', Auth::user()) || Helper::checkOpd('kota', Auth::user())) {
                    $temp[] = ['label' => 'Kota', 'wilayah' => $dataKota, 'labelNext' => 'kecamatan'];
                }
                if ($request->type == 'kecamatan') {
                    $temp[] = ['label' => 'Kecamatan', 'wilayah' => $dataKecamatan, 'labelNext' => null];
                } else {
                    if (in_array(Auth::user()->role, [1,2,3]) || Auth::user()->role == 4 || Helper::checkOpd('provinsi', Auth::user()) || Helper::checkOpd('kota', Auth::user()) || Helper::checkOpd('kecamatan', Auth::user())) {
                        $temp[] = ['label' => 'Kecamatan', 'wilayah' => $dataKecamatan, 'labelNext' => 'kelurahan'];
                    }
                    if ($request->type == 'kelurahan') {
                        $temp[] = ['label' => 'Kelurahan', 'wilayah' => $dataKelurahan, 'labelNext' => null];
                    }
                }
            }
        }
        $html = "";
        foreach ($temp as $item) {
            $label = $item['label'];
            $wilayah = $item['wilayah'];
            $labelNext = $item['labelNext'];
            $type = $request->align;
            $html .= view('components.select-wilayah', compact('label', 'wilayah', 'labelNext', 'type'))->render();
        }
        return response()->json(array(
            'msg' => $html
        ), 200);
    }

    public function save(Request $request)
    {
        if ($request->hasFile('logo')) {
            $validated = $request->validate([
                'logo' => 'mimes:png,jpg,jpeg',
            ]);
        }
        if ($request->id == 0) {
            $validated = $request->validate([
                'scope' => 'required',
            ]);
            $data = new Opd;
            if ($request->scope == 'provinsi') {
                $data->provinsi_id = $request->provinsi_id;
            } elseif ($request->scope == 'kota') {
                $data->kabkota_id = $request->kota_id;
            } elseif ($request->scope == 'kecamatan') {
                $data->kecamatan_id = $request->kecamatan_id;
            } elseif ($request->scope == 'kelurahan') {
                $data->kelurahan_id = $request->kelurahan_id;
            }
            if (Auth::user()->role != 1) {
                $data->maker_id = Auth::user()->id;
            }
        } else {
            $data = Opd::findOrFail($request->id);
        }
        if (Auth::user()->role != 1) {
            $data->updater_id = Auth::user()->id;
        }
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->fax = $request->fax;
        $data->telp = $request->telp;
		$data->save();
        if ($request->hasFile('logo')) {
            $nama_file = Helper::save_file($request->file('logo'), uniqid(), 'logo_opd', $data->logo);
            $data->logo = $nama_file;
		    $data->save();
        }
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Opd::findOrFail($request->id);
        if ($data->logo != null && file_exists(public_path('/logo_opd/'.$data->logo))) {
            unlink(public_path('/logo_opd/'.$data->logo));
        }
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}