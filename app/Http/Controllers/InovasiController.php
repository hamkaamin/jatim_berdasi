<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Helper;
use App\Models\Bentuk;
use App\Models\Indikator;
use App\Models\Inisiator;
use App\Models\Inovasi;
use App\Models\Jenis;
use App\Models\Tahapan;
use App\Models\Upload;
use App\Models\Urusan;
use Illuminate\Http\Request;

class InovasiController extends Controller
{
    public function index_masyarakat()
    {
        $tahapan = Tahapan::all();
        $inovasi = Inovasi::all();
        if (Auth::user()->role == 2) {
            $inovasi = Inovasi::where('status', '<>', 0)->get();
        }
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
            $temp = [];
            if ($request->status == 1) {
                if ($data->nama == null) {
                    $temp[] = "Lengkapi data Nama Inovasi terlebih dahulu !";
                }
                if ($data->bentuk_id == null) {
                    $temp[] = "Lengkapi data Bentuk Inovasi terlebih dahulu !";
                }
                if ($data->indikator()->count() <= 0 || $data->indikator()->wherePivot('param_awal', null)->orWherePivot('bobot_awal', null)->count() > 0) {
                    $temp[] = "Lengkapi data parameter dan bobot tiap INDIKATOR terlebih dahulu !";
                } else {
                    foreach ($data->indikator()->where('wajib', 1)->get() as $indikator) {
                        $upload = Upload::where('indikator_id', $indikator->id)->where('inovasi_id', $data->id)->count();
                        if ($upload <= 0) {
                            $temp[] = "Upload file pendukung untuk Indikator ".$indikator->nama." terlebih dahulu !";
                        }
                    }
                }
                if (count($temp) > 0) {
                    $msg = "<ul>";
                    foreach ($temp as $item) {
                        $msg .= "<li>".$item."</li>";
                    }
                    $msg .= "</ul>";
                    return redirect()->back()->with('error', $msg);
                } else {
                    $data->status = $request->status;
                    $data->save();
                    return redirect(route('inovasi.masyarakat.index'))->with('success', 'Data Inovasi berhasil di-submit dan masuk ke tahap <b>Proses</b> ! Harap menunggu pengumuman lebih lanjut. Terima kasih');
                }
            }
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

    public function update(Request $request)
    {
        $inovasi = Inovasi::findOrFail($request->id);
        $inovasi->status = $request->status;
        $inovasi->keterangan = $request->keterangan;
        $inovasi->save();
        return redirect()->back()->with('success', Config::get('save_success').'. Status Inovasi berhasil diperbarui !');
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

    public function index_indikator(Request $request)
    {
        if (count($request->input()) == 1 && $request->has('id')) {
            $inovasi = Inovasi::findOrFail($request->id);
            $data = [];
            if ($inovasi->indikator()->count() == 0) {
                $indikator = Indikator::all();
                foreach ($indikator as $item) {
                    $inovasi->indikator()->attach($item->id);
                }
            }
            $data = $inovasi->indikator()->get();
            return view('indikator', compact('data', 'inovasi'));
        } else {
            return redirect()->back();
        }
    }

    public function index_upload(Request $request)
    {
        if (count($request->input()) == 2 && $request->has('id') && $request->has('indikator')) {
            $data = Upload::where('inovasi_id', $request->id)->where('indikator_id', $request->indikator)->get();
            $inovasi = Inovasi::findOrFail($request->id);
            $indikator = Indikator::findOrFail($request->indikator);
            $kolom = Helper::generateKolomUpload($indikator);
            return view('upload', compact('data', 'kolom', 'inovasi'));
        } else {
            return redirect()->back();
        }
    }
}
