<?php

namespace App\Http\Controllers;

use App\Models\KategoriNilaiKovablik;
use App\Models\TahapanKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class KategoriNilaiKovablikController extends Controller
{
    public function index()
    {
        $data = KategoriNilaiKovablik::all();
        $data_tahapan = TahapanKovablik::orderBy('id','asc')->get();
        return view('master.kategori_nilai_kovablik', compact('data', 'data_tahapan'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriNilaiKovablik();
        } else {
            $data = KategoriNilaiKovablik::findOrFail($request->id);
        }
        $data->bagian = $request->bagian;
        $data->indikator = $_POST['indikator'];
        $data->nilai_min = $request->nilai_min;
        $data->nilai_max = $request->nilai_max;
        $data->bobot_nilai = $request->bobot_nilai;
        $data->tahapan_id = $request->tahapan_id;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriNilaiKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
