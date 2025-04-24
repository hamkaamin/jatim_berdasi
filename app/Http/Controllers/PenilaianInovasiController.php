<?php

namespace App\Http\Controllers;

use App\Exports\PenilaianExport;
use App\Helper\Helper;
use App\Models\Inovasi;
use App\Models\Juri;
use App\Models\KategoriInovasi;
use App\Models\Penilaian;
use App\Models\PenilaianMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianInovasiController extends Controller
{
    public function index($jenis)
    {
        // $inovasi = Inovasi::with('kategori')->where('label',1)->where('status',2)->get();
        // if($jenis == 'iga'){
        //     if(Auth::user()->role == 7){
        //         $inovasi = Inovasi::where('label',0)->where('status',2)->whereIn('kategori_id', function ($query) {
        //             $query->select('kategori_id')
        //                   ->from('juris')
        //                   ->where('user_id', Auth::user()->id);
        //         })->get();
        //     }
        // }else if($jenis == 'inotek'){
        //     $inovasi = Inovasi::where('label',1)->where('status',2)->whereIn('kategori_id', function ($query) {
        //         $query->select('kategori_id')
        //               ->from('juris')
        //               ->where('user_id', Auth::user()->id);
        //     })->get();
        // }
        $data_kategori = KategoriInovasi::orderBy('id','asc')->get();
        if(Auth::user()->role == 7){
            $data_kategori = KategoriInovasi::whereIn('id', function ($query) {
                $query->select('kategori_id')
                      ->from('juris')
                      ->where('user_id', Auth::user()->id);
            })->get();
        }
        // $inovasi = Inovasi::with(['kategori.juris', 'penilaian'])
        // ->where('label', 1)
        // ->where('status', 2)
        // ->where('tahun',Auth::user()->tahun)
        // ->get()
        // ->sortByDesc(function ($item) {
        //     $jurisCount = sizeof($item->kategori->juris);
        //     $totalNilai = $item->penilaian->sum('pivot.nilai');
        //     return $jurisCount > 0 ? $totalNilai / $jurisCount : 0;
        // });
        if($jenis == 'iga'){
            $data_kategori = KategoriInovasi::where('id',1)->get();
                return view('penilaian.index_ranking', compact('jenis','data_kategori'));
        }else if($jenis == 'inotek'){
            return view('penilaian.index_ranking', compact('jenis','data_kategori'));
        }

        return view('penilaian.index', compact('inovasi','jenis','data_kategori'));
    }

    public function edit(Request $request)
    {
        $jenis = $request->jenis;
        $id = decrypt($request->id);
        $inovasi = Inovasi::findOrFail($id);
        $juri = Juri::where('user_id',Auth::user()->id)->first();
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
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->where('juri_id',$juri->id)->first();
        return view('penilaian.edit', compact('data','inovasi','jenis','juri','penilaian_map'));
    }

    public function show(Request $request)
    {
        $jenis = $request->jenis;
        $id =decrypt($request->id);
        $inovasi = Inovasi::findOrFail($id);
        $kategori_juri = Juri::where('kategori_id', $inovasi->kategori_id)->pluck('user_id');
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->get();
        $data = $inovasi->penilaian()
                ->whereIn('user_id', $kategori_juri) // Filter berdasarkan kategori juri
                ->get();
        $penilaian_per_juri = [];

        foreach ($kategori_juri as $user_id) {
            $penilaian_per_juri[$user_id] = $inovasi->penilaian()
                ->where('user_id', $user_id)
                ->get();
        }

        return view('penilaian.show', compact('kategori_juri','penilaian_per_juri','inovasi','data','jenis','penilaian_map'));
    }

    public function print($id)
    { 
        $id =decrypt($id);
        $inovasi = Inovasi::findOrFail($id);  
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->get(); 
        $kategori_juri = Juri::where('kategori_id', $inovasi->kategori_id)->pluck('user_id');

        $data = $inovasi->penilaian()->whereIn('user_id', $kategori_juri)->get();  // Filter berdasarkan kategori juri 
        $pdf = PDF::loadview('penilaian.print', compact('kategori_juri','inovasi','data')); 

        $customPaper = array(0, 0, 595.35, 935.55);
        $pdf->setPaper($customPaper);
        $pdf->output(); 

        return $pdf->stream('penilaian-'.$inovasi->nama.'-'.$inovasi->kode.'.pdf'); 
    }

    public function save(Request $request)
    {
        DB::beginTransaction();

        try {
            $inovasi = Inovasi::findOrFail($request->inovasi_id);
            $total_nilai = 0;
    
            foreach ($request->except('_token', 'inovasi_id', 'signature_data', 'penilaian_map', 'juri_id') as $key => $value) {
                if (strpos($key, 'keterangan_') === 0) {
                    $penilaianId = str_replace('keterangan_', '', $key);
                    $catatanSaran = $value;
                    $nilaiKey = "nilai_$penilaianId";
                    $nilai = $request->input($nilaiKey);
    
                    if (is_numeric($nilai)) {
                        $updated = DB::table('penilaian_inovasi')
                            ->where('inovasi_id', $inovasi->id)
                            ->where('penilaian_id', $penilaianId)
                            ->where('user_id', Auth::id())
                            ->update([
                                'catatan_saran' => $catatanSaran,
                                'nilai' => $nilai,
                            ]);
    
                        if ($updated) {
                            $total_nilai += $nilai;
                        }
                    }
                }
            }
    
            // Simpan tanda tangan juri
            if ($request->has('signature_data') && $request->filled('signature_data')) {
                $signatureData = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->input('signature_data'));
                $signatureImage = base64_decode($signatureData);
                $signatureName = 'signature_' . time() . '.png';
                $signaturePath = public_path('uploads/signatures/');
    
                if (!File::exists($signaturePath)) {
                    File::makeDirectory($signaturePath, 0755, true);
                }
    
                file_put_contents($signaturePath . $signatureName, $signatureImage);
    
                $penilaian_map = $request->filled('penilaian_map') 
                    ? PenilaianMap::find($request->penilaian_map) 
                    : new PenilaianMap();
    
                $penilaian_map->inovasi_id = $inovasi->id;
                $penilaian_map->juri_id = $request->juri_id;
                $penilaian_map->total_nilai = $total_nilai;
                $penilaian_map->signature_path = 'uploads/signatures/' . $signatureName;
                $penilaian_map->save();
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
        
    }

    public function ranking($jenis)
    {
        $data_kategori = KategoriInovasi::orderBy('id','asc')->get();
        if(Auth::user()->role == 7){
            $data_kategori = KategoriInovasi::whereIn('id', function ($query) {
                $query->select('kategori_id')
                      ->from('juris')
                      ->where('user_id', Auth::user()->id);
            })->get();
        } 
        
        if($jenis == 'iga'){
            $data_kategori = KategoriInovasi::where('id',1)->get();
    
            if(Auth::user()->role == 2){
                $id_kategori = Helper::getKategoriRole(Auth::user()->role);
                $data_kategori = KategoriInovasi::whereIn('id',$id_kategori)->orderBy('id','asc')->get();
            }
            return view('penilaian.index_ranking', compact('jenis','data_kategori'));
        }else if($jenis == 'inotek'){

            if(Auth::user()->role == 2){
                $id_kategori = Helper::getKategoriRole(Auth::user()->role);
                $data_kategori = KategoriInovasi::whereIn('id',$id_kategori)->orderBy('id','asc')->get();
            }
            return view('penilaian.index_ranking', compact('jenis','data_kategori'));
        }
    }

    public function export($kategori_id,$jenis)
    {
        $kategori = KategoriInovasi::find($kategori_id);
        $nama_file = 'Export Penilaian Inovasi Kategori '.$kategori->nama_singkat.' '.Auth::user()->tahun.'_Tanggal_'.date('d-m-Y H-i-s').'.xlsx'; 
        return Excel::download(new PenilaianExport($jenis, $kategori_id),$nama_file);  
        session()->put('status', 'Data Opd berhasil diunduh!');
    }
}