<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use App\Models\Juri;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianInovasiController extends Controller
{
    public function index($jenis)
    {
        $inovasi = Inovasi::with('kategori')->where('label',1)->where('status',2)->get();
        if($jenis == 'iga'){
            if(Auth::user()->role == 7){
                $inovasi = Inovasi::where('label',0)->where('status',2)->whereIn('kategori_id', function ($query) {
                    $query->select('kategori_id')
                          ->from('juris')
                          ->where('user_id', Auth::user()->id);
                })->get();
            }
        }else if($jenis == 'inotek'){
            $inovasi = Inovasi::where('label',1)->where('status',2)->whereIn('kategori_id', function ($query) {
                $query->select('kategori_id')
                      ->from('juris')
                      ->where('user_id', Auth::user()->id);
            })->get();
        }

        return view('penilaian.index', compact('inovasi'));
    }

    public function edit(Request $request)
    {
        $id = decrypt($request->id);
        $inovasi = Inovasi::findOrFail($id);
            $data = [];
            if ($inovasi->penilaian()->wherePivot('user_id', Auth::id())->count() == 0) {
                $penilaians = Penilaian::where('kategori_id', $inovasi->kategori_id)->get();
                foreach ($penilaians as $penilaian) {
                    $inovasi->penilaian()->attach($penilaian->id, [
                        'user_id' => Auth::id()
                    ]);
                }
            }
            $data = $inovasi->penilaian()->wherePivot('user_id', Auth::id())->get();
        return view('penilaian.edit', compact('data','inovasi'));
    }

    public function show(Request $request)
    {
        $id =decrypt($request->id);
        $inovasi = Inovasi::findOrFail($id);
        $kategori_juri = Juri::where('kategori_id', $inovasi->kategori_id)->pluck('user_id');

        $data = $inovasi->penilaian()
                ->whereIn('user_id', $kategori_juri) // Filter berdasarkan kategori juri
                ->get();
        return view('penilaian.show', compact('kategori_juri','inovasi','data'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'inovasi_id' => 'required|integer|exists:inovasis,id',
        ]);
        
        $inovasi = Inovasi::findOrFail($request->inovasi_id);
        
        foreach ($request->except('_token', 'inovasi_id') as $key => $value) {
            if (strpos($key, 'keterangan_') === 0) {
                $penilaianId = str_replace('keterangan_', '', $key);
                $catatanSaran = $value;
                $nilai = $request->input("nilai_$penilaianId");
        
                $pivot = $inovasi->penilaian()->wherePivot('user_id', Auth::id())->wherePivot('penilaian_id', $penilaianId);
        
                if ($pivot->exists()) {
                    $pivot->updateExistingPivot($penilaianId, [
                        'catatan_saran' => $catatanSaran,
                        'nilai' => $nilai,
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui!');
        
    }
}