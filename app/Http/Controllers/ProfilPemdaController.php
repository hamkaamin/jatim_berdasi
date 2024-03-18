<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Excel;
use Helper;
use PDF;
use App\Models\Indikator;
use App\Models\Provinsi;
use App\Models\Upload;
use App\Exports\ProfilPemdaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilPemdaController extends Controller
{
    public function index()
    {
        // $provinsi = Provinsi::all();
        $provinsi = Provinsi::where('name', 'ilike', '%jawa timur%')->get();
        return view('profil-pemda.index', compact('provinsi'));
    }

    public function index_detail(Request $request)
    {
        $provinsi = Auth::user()->role == 2 ? Provinsi::findOrFail($request->id) : Auth::user()->provinsi;
        $data = [];
        if ($provinsi->indikator()->count() == 0) {
            $indikator = Indikator::where('label', 1)->get();
            foreach ($indikator as $item) {
                $provinsi->indikator()->attach($item->id);
            }
        }
        $data = $provinsi->indikator()->get();
        return view('profil-pemda.detail', compact('data', 'provinsi'));
    }
    public function index_detail_kota_kab(Request $request)
    {
        $kota_kab = Auth::user()->role == 3 ? Kota::findOrFail($request->id) : Auth::user()->kota_kab;
        $data = [];
        if ($kota_kab->indikator()->count() == 0) {
            $indikator = Indikator::where('label', 1)->get();
            foreach ($indikator as $item) {
                $kota_kab->indikator()->attach($item->id);
            }
        }
        $data = $provinsi->indikator()->get();
        return view('profil-pemda.detail', compact('data', 'provinsi'));
    }

    public function index_upload(Request $request)
    {
        if (count($request->input()) == 3 && isset($request->id) && isset($request->indikator)) {
            $data = Upload::where('provinsi_id', $request->id)->where('indikator_id', $request->indikator)->get();
            $indikator = Indikator::findOrFail($request->indikator);
            $kolom = Helper::generateKolomUpload($indikator);
            return view('profil-pemda.upload', compact('data', 'kolom', 'indikator'));
        } else {
            return redirect()->back();
        }
    }

    public function upload_pakta(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'pakta_integritas' => 'mimes:pdf,docx,doc,jpg,jpeg,png,xlsx|max:2048', 
        ], [  
            'pakta_integritas.mimes' => 'File harus pdf / doc / jpg / jpeg / png / xlsx',
            'pakta_integritas.max' => 'File maksimal berukuran 2MB', 
        ]);
        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->all() as $message) {
                $msg .= $message . ". ";
            }
            return redirect()->back()->with('error', $msg)->withInput($request->input());

        } else {
            $nama_file = Helper::save_file($request->file('pakta_integritas'), uniqid(), 'pakta_integritas', Auth::user()->pakta_integritas);
            Auth::user()->pakta_integritas = $nama_file;
            Auth::user()->save();
            return redirect()->back()->with('success', 'Pakta integritas berhasil di-upload !');
        }
    }

    public function saveParam(Request $request)
    {
        $provinsi = Provinsi::findOrFail($request->provinsi_id);
        $provinsi->indikator()->updateExistingPivot($request->indikator_id, [
            'bobot_akhir' => $request->bobot_akhir
        ]);

        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function export(Request $request, $type)
    {
        if ($type == 'excel') {
            return Excel::download(new ProfilPemdaExport(Auth::user()->provinsi), 'profil-provinsi-'.Auth::user()->province_id.'-'.uniqid().'.xlsx');
        } elseif ($type == 'pdf') {
            $pdf = PDF::loadview('export.profil-pemda-pdf',['provinsi' => Auth::user()->provinsi]);
            // return $pdf->stream();
    	    return $pdf->download('profil-pemda-'.Auth::user()->province_id.'.pdf');
        }
    }
}