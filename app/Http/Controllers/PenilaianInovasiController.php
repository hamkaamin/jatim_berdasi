<?php

namespace App\Http\Controllers;

use App\Exports\PenilaianExport;
use App\Helper\Helper;
use App\Models\Inovasi;
use App\Models\Juri;
use App\Models\KategoriInovasi;
use App\Models\KelompokKovablik;
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
        $data_kategori = KategoriInovasi::where('is_aktif', 1)->orderBy('id','asc')->get();
        if(Auth::user()->role == 7){
            $data_kategori = KategoriInovasi::where('is_aktif', 1)->whereIn('id', function ($query) {
                $query->select('kategori_id')
                      ->from('juris')
                      ->where('user_id', Auth::user()->id);
            })->get();
        }

        if($jenis == 'iga'){
            $data_kategori = KategoriInovasi::where('is_aktif', 1)->where('id',1)->get();
                return view('penilaian.index_ranking', compact('jenis','data_kategori'));
        }else if($jenis == 'inotek'){
            return view('penilaian.index_ranking', compact('jenis','data_kategori'));
        }

        return view('penilaian.index', compact('inovasi','jenis','data_kategori'));
    }

    public function edit(Request $request)
    {
        $juri_tahap = $request->tahap;
        $jenis = $request->jenis;
        $id = decrypt($request->id);
        $inovasi = Inovasi::findOrFail($id);
        $juri = Juri::where('user_id',Auth::user()->id)->where('kategori_id', $inovasi->kategori_id)->first();
        $penilaians = Penilaian::where('kategori_id', $inovasi->kategori_id)->get();
        foreach ($penilaians as $penilaian) {
            $exists = DB::table('penilaian_inovasi')
                ->where('inovasi_id', $inovasi->id)
                ->where('penilaian_id', $penilaian->id)
                ->where('user_id', Auth::id())
                ->where('juri_tahap', $inovasi->juri_tahap)
                ->exists();
            if (!$exists) {
                $inovasi->penilaian()->attach($penilaian->id, [
                    'user_id' => Auth::id(),
                    'juri_tahap' => $inovasi->juri_tahap,
                ]);
            }
        }
        $data = $inovasi->penilaian()->wherePivot('user_id', Auth::id())->wherePivot('juri_tahap', $inovasi->juri_tahap)->get()->sortBy('id')->values();
        $tree = Helper::buildAspekTree($data);
        $leafIds = Helper::aspekLeafIds($data);
        $grandTotal = collect($tree)->sum(fn ($n) => optional($n->pivot)->nilai);
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->where('juri_id',$juri->id)->where('juri_tahap',$inovasi->juri_tahap)->first();

        return view('penilaian.edit', compact('data','tree','leafIds','grandTotal','inovasi','jenis','juri','penilaian_map','juri_tahap'));
    }

    public function show(Request $request)
    {
        $jenis = $request->jenis;
        $id =decrypt($request->id);
        $inovasi = Inovasi::findOrFail($id);
        $kategori_juri = Juri::where('kategori_id', $inovasi->kategori_id)->pluck('user_id');
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->where('juri_tahap',$inovasi->juri_tahap)->get();
        // $data = $inovasi->penilaian()
        //         ->whereIn('user_id', $kategori_juri) // Filter berdasarkan kategori juri
        //         ->where('juri_tahap',$inovasi->juri_tahap)
        //         ->get();
        $penilaian_per_juri = [];

        foreach ($kategori_juri as $user_id) {
            $penilaian_per_juri[$user_id] = $inovasi->penilaian()
                ->where('user_id', $user_id)
                ->get();
        }

        return view('penilaian.show', compact('kategori_juri','penilaian_per_juri','inovasi','jenis','penilaian_map'));
    }

    public function print($id,$juri_tahap)
    {
        $id =decrypt($id);
        $inovasi = Inovasi::findOrFail($id);
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->where('juri_tahap',$juri_tahap)->get();
        $kategori_juri = Juri::where('kategori_id', $inovasi->kategori_id)->pluck('user_id');

        $data = $inovasi->penilaian()->whereIn('user_id', $kategori_juri)->where('juri_tahap',$juri_tahap)->get();  // Filter berdasarkan kategori juri
        $pdf = PDF::loadview('penilaian.print', compact('kategori_juri','inovasi','data','juri_tahap'));

        $customPaper = array(0, 0, 595.35, 935.55);
        $pdf->setPaper($customPaper);
        $pdf->output();

        return $pdf->stream('penilaian-'.$inovasi->nama.'-'.$inovasi->kode.'.pdf');
    }

    public function save(Request $request)
    {
        // Tanda tangan wajib (selalu baru) setiap menyimpan.
        if (!$request->filled('signature_data')) {
            return redirect()->back()
                ->withErrors(['signature_data' => 'Tanda tangan wajib diisi sebelum menyimpan penilaian.'])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $inovasi = Inovasi::findOrFail($request->inovasi_id);

            // 1. Pohon rubrik otoritatif dari master (bukan dari request).
            $flat = Penilaian::where('kategori_id', $inovasi->kategori_id)->get()->sortBy('id')->values();
            $tree = Helper::buildAspekTree($flat);
            $leafIds = Helper::aspekLeafIds($flat);

            // 2. Kumpulkan input leaf + catatan.
            $rawByLeafId = [];
            $noteById = [];
            foreach ($leafIds as $lid) {
                if ($request->has("nilai_$lid")) {
                    $rawByLeafId[$lid] = $request->input("nilai_$lid");
                }
                if ($request->has("keterangan_$lid")) {
                    $noteById[$lid] = $request->input("keterangan_$lid");
                }
            }

            // 3. Nilai tersimpan (berbobot) bottom-up untuk SEMUA node.
            $storedById = Helper::rollupAspek($tree, $rawByLeafId);

            // 4. Persist tiap node (updateOrInsert agar node rubrik baru tetap dapat baris).
            foreach ($storedById as $rid => $stored) {
                $key = [
                    'inovasi_id' => $inovasi->id,
                    'penilaian_id' => $rid,
                    'user_id' => Auth::id(),
                    'juri_tahap' => $inovasi->juri_tahap,
                ];
                $values = ['nilai' => is_numeric($stored) ? $stored : 0];
                if (in_array($rid, $leafIds)) {
                    $values['catatan_saran'] = $noteById[$rid] ?? null;
                }
                DB::table('penilaian_inovasi')->updateOrInsert($key, $values);
            }

            // 5. Total = Σ node root saja.
            $total_nilai = collect($tree)->sum(fn ($n) => $storedById[$n->id] ?? 0);

            // 6. Simpan tanda tangan juri.
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
            if (!$penilaian_map) {
                $penilaian_map = new PenilaianMap();
            }

            $penilaian_map->inovasi_id = $inovasi->id;
            $penilaian_map->juri_id = $request->juri_id;
            $penilaian_map->total_nilai = $total_nilai;
            $penilaian_map->juri_tahap = $inovasi->juri_tahap;
            $penilaian_map->signature_path = 'uploads/signatures/' . $signatureName;
            $penilaian_map->save();

            DB::commit();
            return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }

    }

    public function ranking($jenis, Request $request)
    {
        if($request->tahap != 1 && $request->tahap != 2){
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        $juri_tahap = $request->tahap;
        $data_kategori = KategoriInovasi::where('is_aktif', 1)->orderBy('is_kovablik', 'desc')->orderBy('id','asc')->get();
        if(Auth::user()->role == 7){
            $data_kategori = KategoriInovasi::where('is_aktif', 1)->whereIn('id', function ($query) {
                $query->select('kategori_id')
                      ->from('juris')
                      ->where('user_id', Auth::user()->id);
            })->get();
        }

        // Merged from PenilaianKovablikController@ranking: load data_kelompok for is_kovablik categories
        $data_kelompok = KelompokKovablik::orderBy('id', 'asc')->get();
        if (Auth::user()->role == 7) {
            $data_kelompok = KelompokKovablik::all();
        }
        if (Auth::user()->role == 2) {
            $data_kelompok = KelompokKovablik::whereIn('id', function ($query) {
                $query->select('kelompok_id')
                    ->from('verifikator_kovabliks')
                    ->where('user_id', Auth::user()->id);
            })->get();
        }

        if($jenis == 'iga'){
            $data_kategori = KategoriInovasi::where('is_aktif', 1)->where('id',1)->get();
            if(Auth::user()->role == 2){
                $id_kategori = Helper::getKategoriRole(Auth::user()->role);
                $data_kategori = KategoriInovasi::where('is_aktif', 1)->whereIn('id',$id_kategori)->orderBy('id','asc')->get();
            }
            return view('penilaian.index_ranking', compact('jenis','data_kategori','juri_tahap','data_kelompok'));
        }else if($jenis == 'inotek'){
            if(Auth::user()->role == 2){
                $id_kategori = Helper::getKategoriRole(Auth::user()->role);
                $data_kategori = KategoriInovasi::where('is_aktif', 1)->whereIn('id',$id_kategori)->orderBy('is_kovablik', 'desc')->orderBy('id','asc')->get();
            }

            return view('penilaian.index_ranking', compact('jenis','data_kategori','juri_tahap','data_kelompok'));
        }
    }

    public function export($kategori_id,$jenis)
    {
        $kategori = KategoriInovasi::find($kategori_id);
        $nama_file = 'Export Penilaian Inovasi Kategori '.$kategori->nama_singkat.' '.Auth::user()->tahun.'_Tanggal_'.date('d-m-Y H-i-s').'.xlsx';
        return Excel::download(new PenilaianExport($jenis, $kategori_id),$nama_file);
        session()->put('status', 'Data Opd berhasil diunduh!');
    }


    public function move(Request $request){
        $is_next = filter_var($request->input('is_next'), FILTER_VALIDATE_BOOLEAN);
        try{
            DB::beginTransaction();
            $inovasi = Inovasi::find($request->id);
            if($inovasi->juri_tahap == 1){
                $juri = Juri::where('kategori_id', $inovasi->kategori_id)->get();
                $juri_ids = $juri->pluck('id');

                $jumlah_penilai = PenilaianMap::where('inovasi_id', $inovasi->id)
                    ->where('juri_tahap', 1)
                    ->whereIn('juri_id', $juri_ids)
                    ->count();

                if ($jumlah_penilai < $juri->count()) {
                    $sudah_menilai = PenilaianMap::where('inovasi_id', $inovasi->id)
                        ->where('juri_tahap', 1)
                        ->whereIn('juri_id', $juri_ids)
                        ->pluck('juri_id');

                    $belum_menilai = $juri->whereNotIn('id', $sudah_menilai)
                        ->map(fn($j) => $j->user ? $j->user->name : 'Juri #'.$j->id)
                        ->values()
                        ->toArray();

                    return response()->json([
                        'status' => false,
                        'message' => 'Juri yang belum menilai: ' . implode(', ', $belum_menilai),
                        'error' => 'Gagal',
                    ]);
                }
            }

            // Tandai nilai tahap saat ini sebagai boleh ditampilkan (sebelum increment)
            $inovasi->nilai_juri_tahap_show = $inovasi->juri_tahap;

            if ($is_next) {
                $inovasi->juri_tahap = $inovasi->juri_tahap + 1;
            }

            $inovasi->save();
            DB::commit();

            $message = $is_next
                ? 'Inovasi Berhasil Masuk ke Tahap ' . $inovasi->juri_tahap . ' dan Nilai Tahap Sebelumnya Dibagikan'
                : 'Nilai Tahap ' . $inovasi->nilai_juri_tahap_show . ' Berhasil Dibagikan';

            return response()->json(['status' => true, 'message' => $message], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' =>false,
                'message' => 'Failed to update status and keterangan.',
                'error' => $e->getMessage(),
            ],500);
        }
    }
}
