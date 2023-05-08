<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Excel;
use Helper;
use PDF;
use App\Models\Bentuk;
use App\Models\Indikator;
use App\Models\Inisiator;
use App\Models\Inovasi;
use App\Models\Jenis;
use App\Models\Tahapan;
use App\Models\Upload;
use App\Models\Urusan;
use App\Exports\InovasiExport;
use App\Models\KategoriInvoasi;
use Illuminate\Http\Request;

class InovasiController extends Controller
{
    public function index(Request $request, $area)
    {
        $tahapan = Tahapan::all();
        $inovasi = Inovasi::where('deleted_at', 0);
        $label = "";
        $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
        if ($area == 'daerah') {
            $inovasi = Inovasi::where('status', 2);
            $label = "Daerah";
        } elseif ($area == 'masyarakat') {
            $inovasi = Inovasi::where('label', 0);
            $label = "Awards";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            } 
        } elseif ($area == 'pemda') {
            $inovasi = Inovasi::where('label', 1);
            $label = "Pemda";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            }
        }
        
        if (Auth::user()->role == 4) {
            $inovasi = $inovasi->where('user_id', Auth::user()->id);
        }

        if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
            $inovasi = $inovasi->where('provinsi_id', Auth::user()->province_id);
        } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
            $inovasi = $inovasi->where('provinsi_id', Auth::user()->opd->provinsi_id);
        } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
            $inovasi = $inovasi->where('kota_id', Auth::user()->regency_id);
        } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
            $inovasi = $inovasi->where('kota_id', Auth::user()->opd->kabkota_id);
        } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
            $inovasi = $inovasi->where('kecamatan_id', Auth::user()->opd->kecamatan_id);
        } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
            $inovasi = $inovasi->where('kelurahan_id', Auth::user()->opd->kelurahan_id);
        }
        $inovasi = $inovasi->get();
        return view('inovasi.index', compact('tahapan', 'tahapanKolom', 'inovasi', 'label'));
    }

    public function edit(Request $request)
    { 
        if (count($request->input()) <= 3 && isset($request->id)) {
            $data = null;
            $tahapan = Tahapan::all();
            $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
            $inisiator = Inisiator::all();
            $jenis = Jenis::all();
            $bentuk = Bentuk::all();
            $urusan = Urusan::all();
            $kategori = KategoriInvoasi::all();
            $label = 0;
            if (isset($request->label)) {
                $label = $request->label;
            }
            if ($request->id != 0) {
                $data = Inovasi::findOrFail($request->id);
                $label = $data->label;
            }
            return view('inovasi.form-inovasi', compact('data','kategori', 'tahapan', 'inisiator', 'jenis', 'bentuk', 'urusan', 'tahapanKolom', 'label'));
        } else { 
            return redirect()->back();
        }
    }

    public function limit_words($string, $word_limit) {
        $string = strip_tags($string);
        $words = explode(' ', strip_tags($string));
        $return = trim(implode(' ', array_slice($words, 0, $word_limit)));
        if(strlen($return) < strlen($string)){
            $return = 'Maximal 300 kata';
        }
        return $return;
    }

    public function save(Request $request)
    {
        $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
        $tempArr = [];
        if ($request->id == 0) {
            $data = new Inovasi;
            $data->user_id = Auth::user()->id;
            $data->kode = uniqid();
            if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
                $data->provinsi_id = Auth::user()->province_id;
            } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
                $data->provinsi_id = Auth::user()->opd->provinsi_id;
            } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
                $data->provinsi_id = Auth::user()->kota->provinsi->id;
                $data->kota_id = Auth::user()->regency_id;
            } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
                $data->provinsi_id = Auth::user()->opd->kota->provinsi->id;
                $data->kota_id = Auth::user()->opd->kabkota_id;
            } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
                $data->provinsi_id = Auth::user()->opd->kecamatan->kota->provinsi->id;
                $data->kota_id = Auth::user()->opd->kecamatan->kota->id;
                $data->kecamatan_id = Auth::user()->opd->kecamatan_id;
            } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
                $data->provinsi_id = Auth::user()->opd->kelurahan->kecamatan->kota->provinsi->id;
                $data->kota_id = Auth::user()->opd->kelurahan->kecamatan->kota->id;
                $data->kecamatan_id = Auth::user()->opd->kelurahan->kecamatan->id;
                $data->kelurahan_id = Auth::user()->opd->kelurahan_id;
            }
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
                if ($data->indikator()->count() <= 0 || $data->indikator()->where('wajib', 1)->wherePivot('bobot_awal', null)->count() > 0) {
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
                    $route = $request->label == 1 ? route('inovasi.index', ['area' => 'pemda']) : route('inovasi.index', ['area' => 'masyarakat']);
                    return redirect($route)->with('success', 'Data Inovasi berhasil di-submit dan masuk ke tahap <b>Proses</b> ! Harap menunggu pengumuman lebih lanjut. Terima kasih');
                }
            }
        }
        $max_kata = 10;
        $rancang_bangun = $request->rancang_bangun;  
        $string = strip_tags($rancang_bangun);
        $words = explode(' ', strip_tags($rancang_bangun));
        $return = trim(implode(' ', array_slice($words, 0, 10)));
        $kata = count($words);
        if($kata < $max_kata){
            return redirect()->back()->with('error', 'Minimal Data Rancang Bangun 300 kata');
        }
        $data->nama = $request->nama;
        $data->tahapan_id = $request->tahapan_id;
        $data->kategori_id = $request->kategori_id;
        $data->inisiator_id = $request->inisiator_id;
        $data->jenis_id = $request->jenis_id;
        $data->bentuk_id = $request->bentuk_id;
        $data->covid = $request->covid;
        $data->rancang_bangun = $request->rancang_bangun;
        $data->tujuan = $request->tujuan;
        $data->manfaat = $request->manfaat;
        $data->hasil = $request->hasil;
        $data->status = $request->status;
        $data->label = $request->label;
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
        if ($request->hasFile('file_rancang_bangun')) {
            $nama_file = Helper::save_file($request->file('file_rancang_bangun'), uniqid(), 'file_rancang_bangun', $data->file_rancang_bangun);
            $data->file_rancang_bangun = $nama_file;
		    $data->save();
        }
        if ($request->hasFile('profil_bisnis')) {
            $nama_file = Helper::save_file($request->file('profil_bisnis'), uniqid(), 'file_profil_bisnis', $data->profil_bisnis);
            $data->profil_bisnis = $nama_file;
		    $data->save();
        }
        $route = $request->label == 1 ? route('inovasi.index', ['area' => 'pemda']) : route('inovasi.index', ['area' => 'masyarakat']);
        return redirect($route)->with('success', Config::get('save_success').'. Mohon melengkapi data-data indikator agar Inovasi dapat diproses !');
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
        if (count($request->input()) == 2 && isset($request->id)) {
            $inovasi = Inovasi::findOrFail($request->id);
            $data = [];
            if ($inovasi->indikator()->count() == 0) {
                $indikator = Indikator::where('label', 0)->get();
                foreach ($indikator as $item) {
                    $inovasi->indikator()->attach($item->id);
                }
            }
            $data = $inovasi->indikator()->get();
            return view('inovasi.indikator', compact('data', 'inovasi'));
        } else {
            return redirect()->back();
        }
    }

    public function index_upload(Request $request)
    {  
        if (count($request->input()) == 3 && isset($request->id) && isset($request->indikator)) {
            $data = Upload::where('inovasi_id', $request->id)->where('indikator_id', $request->indikator)->get();
            $inovasi = Inovasi::findOrFail($request->id);
            $indikator = Indikator::findOrFail($request->indikator);
            $kolom = Helper::generateKolomUpload($indikator);
            return view('inovasi.upload', compact('data', 'kolom', 'inovasi'));
        } else {
            return redirect()->back();
        }
    }

    public function export(Request $request, $type)
    {
        $inovasi = Inovasi::findOrFail($request->id);
        $kolom = Tahapan::where('tampilkan_kolom', 1)->get();
        if ($type == 'excel') {
            return Excel::download(new InovasiExport($inovasi, $kolom), 'inovasi-'.$inovasi->kode.'.xlsx');
        } elseif ($type == 'pdf') {
           
            $pdf = PDF::loadview('export.inovasi-pdf',['inovasi' => $inovasi, 'kolom' => $kolom]);
            // return $pdf->stream();
    	    return $pdf->download('inovasi-'.$inovasi->kode.'.pdf');
        }
    }
}