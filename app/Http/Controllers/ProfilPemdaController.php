<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use Helper;
use App\Models\Indikator;
use Illuminate\Http\Request;

class ProfilPemdaController extends Controller
{
    public function index()
    {
        return view('profil-pemda.index');
    }

    public function index_detail()
    {
        $provinsi = Auth::user()->provinsi;
        $data = [];
        if ($provinsi->indikator()->count() == 0) {
            $indikator = Indikator::where('label', 1)->get();
            foreach ($indikator as $item) {
                $provinsi->indikator()->attach($item->id);
            }
        }
        $data = $provinsi->indikator()->get();
        return view('profil-pemda.detail', compact('data'));
    }

    public function upload_pakta(Request $request)
    {
        $nama_file = Helper::save_file($request->file('pakta_integritas'), uniqid(), 'pakta_integritas', Auth::user()->pakta_integritas);
        Auth::user()->pakta_integritas = $nama_file;
        Auth::user()->save();
        return redirect()->back()->with('success', 'Pakta integritas berhasil di-upload !');
    }
}
