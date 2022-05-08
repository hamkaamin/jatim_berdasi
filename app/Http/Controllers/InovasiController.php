<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Helper;
use App\Models\Bentuk;
use App\Models\Inisiator;
use App\Models\Inovasi;
use App\Models\Jenis;
use App\Models\Tahapan;
use App\Models\Urusan;
use Illuminate\Http\Request;

class InovasiController extends Controller
{
    public function index_masyarakat()
    {
        $tahapan = Tahapan::all();
        $inovasi = Inovasi::all();
        $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
        return view('inovasi', compact('tahapan', 'tahapanKolom', 'inovasi'));
    }

    public function edit(Request $request)
    {
        if (count($request->input()) == 1 && $request->has('id')) {
            $data = null;
            $tahapan = Tahapan::all();
            $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
            $inisiator = Inisiator::all();
            $jenis = Jenis::all();
            $bentuk = Bentuk::all();
            $urusan = Urusan::all();
            if ($request->id != 0) {
                $data = Inovasi::findOrFail($request->id);
            }
            return view('form-inovasi', compact('data', 'tahapan', 'inisiator', 'jenis', 'bentuk', 'urusan', 'tahapanKolom'));
        } else {
            return redirect()->back();
        }
    }

    public function save(Request $request)
    {
        $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
        $tempArr = [];
        if ($request->id == 0) {
            $data = new Inovasi;
            $data->user_id = Auth::user()->id;
            $data->kode = uniqid();
        } else {
            $data = Inovasi::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->tahapan_id = $request->tahapan_id;
        $data->inisiator_id = $request->inisiator_id;
        $data->jenis_id = $request->jenis_id;
        $data->bentuk_id = $request->bentuk_id;
        $data->covid = $request->covid;
        $data->rancang_bangun = $request->rancang_bangun;
        $data->tujuan = $request->tujuan;
        $data->manfaat = $request->manfaat;
        $data->hasil = $request->hasil;
        $data->status = $request->status;
		$data->save();
        $data->urusan()->sync($request->urusan_id);
        foreach ($tahapanKolom as $item) {
            $tempArr[$item->id] = ['waktu' => $request->{'waktu_tahapan_'.$item->id}];
        }
        $data->tahapan()->sync($tempArr);
        if ($request->hasFile('anggaran')) {
            $nama_file = Helper::save_file($request->file('anggaran'), uniqid(), 'file_anggaran', $data->anggaran);
            $data->anggaran = $nama_file;
		    $data->save();
        }
        if ($request->hasFile('profil_bisnis')) {
            $nama_file = Helper::save_file($request->file('profil_bisnis'), uniqid(), 'file_profil_bisnis', $data->profil_bisnis);
            $data->profil_bisnis = $nama_file;
		    $data->save();
        }
        return redirect(route('inovasi.masyarakat.index'))->with('success', Config::get('save_success').'. Mohon melengkapi data-data indikator agar Inovasi dapat diproses !');
    }

    public function delete(Request $request)
    {
        $data = Inovasi::findOrFail($request->id);
        foreach ($data->upload()->get() as $item) {
            $item->delete();
        }
        if ($data->anggaran != null && file_exists(public_path('/file_anggaran/'.$data->anggaran))) {
            unlink(public_path('/file_anggaran/'.$data->anggaran));
        }
        if ($data->profil_bisnis != null && file_exists(public_path('/file_profil_bisnis/'.$data->profil_bisnis))) {
            unlink(public_path('/file_profil_bisnis/'.$data->profil_bisnis));
        }
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
