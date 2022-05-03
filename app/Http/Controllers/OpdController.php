<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Opd;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index()
    {
        $data = Opd::all();
        return view('daftar-opd', compact('data'));
    }

    public function change_scope(Request $request)
    {
        // Label harus satu kata & tanpa karakter spesial !
        // Label disamakan dengan value LabelNext, tapi kalau Label ada uppercase nya
        // Value LabelNext hardcoded
        $temp = [];
        if ($request->type == 'provinsi') {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => null];
        } elseif ($request->type == 'kota') {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => 'kota'];
            $temp[] = ['label' => 'Kota', 'wilayah' => [], 'labelNext' => null];
        } elseif ($request->type == 'kecamatan') {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => 'kota'];
            $temp[] = ['label' => 'Kota', 'wilayah' => [], 'labelNext' => 'kecamatan'];
            $temp[] = ['label' => 'Kecamatan', 'wilayah' => [], 'labelNext' => null];
        } elseif ($request->type == 'kelurahan') {
            $temp[] = ['label' => 'Provinsi', 'wilayah' => Provinsi::all(), 'labelNext' => 'kota'];
            $temp[] = ['label' => 'Kota', 'wilayah' => [], 'labelNext' => 'kecamatan'];
            $temp[] = ['label' => 'Kecamatan', 'wilayah' => [], 'labelNext' => 'kelurahan'];
            $temp[] = ['label' => 'Kelurahan', 'wilayah' => [], 'labelNext' => null];
        }
        $html = "";
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
                $data->kota_id = $request->kota_id;
            } elseif ($request->scope == 'kecamatan') {
                $data->kecamatan_id = $request->kecamatan_id;
            } elseif ($request->scope == 'kelurahan') {
                $data->kelurahan_id = $request->kelurahan_id;
            }
        } else {
            $data = Opd::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->fax = $request->fax;
        $data->telp = $request->telp;
		$data->save();
        if ($request->hasFile('logo')) {
            if ($data->logo != null && file_exists(public_path('/logo_opd/'.$data->logo))) {
                unlink(public_path('/logo_opd/'.$data->logo));
            }
            $file = $request->file('logo');
            $nama_file = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move('logo_opd', $nama_file);
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
