<?php

namespace App\Http\Controllers;

use App\Models\KategoriInovasi;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->q);

        $data_kategori = KategoriInovasi::where('is_aktif', 1)->where('is_kovablik', 0)
            ->orderBy('id', 'asc')->get();

        $treePerKategori = [];
        foreach ($data_kategori as $kat) {
            $flat = Penilaian::where('kategori_id', $kat->id)->orderBy('id', 'asc')->get();
            $treePerKategori[$kat->id] = \Helper::buildAspekTree($flat, $q);
        }

        return view('master.penilaian', compact('data_kategori', 'treePerKategori', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    
    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Penilaian();
        } else {
            $data = Penilaian::findOrFail($request->id);
        }

        if($request->nilai_min > $request->nilai_max){
            return redirect()->back()->with('error', 'Nilai minimal harus lebih kecil atau sama dengan nilai maksimal');
        }

        // Induk hanya diambil dari request saat tambah anak; saat edit tetap mengikuti yang lama.
        $parentId = $request->id == 0 ? ($request->parent_id ?: null) : $data->parent_id;

        // Anak selalu mengikuti kategori induknya.
        $kategoriId = $parentId
            ? optional(Penilaian::find($parentId))->kategori_id
            : ($request->id == 0 ? $request->kategori_id : $data->kategori_id);

        $bobot_dipakai = Penilaian::when($parentId, function ($x) use ($parentId) {
                return $x->where('parent_id', $parentId);
            }, function ($x) use ($kategoriId) {
                return $x->whereNull('parent_id')->where('kategori_id', $kategoriId);
            })
            ->when($request->id != 0, function ($q) use ($request) {
                return $q->where('id', '!=', $request->id);
            })
            ->sum('bobot_nilai');
        if ($bobot_dipakai + (int) $request->bobot_nilai > 100) {
            return redirect()->back()->with('error', 'Total bobot untuk kelompok aspek ini melebihi 100%. Sisa kuota: ' . (100 - $bobot_dipakai) . '%');
        }

        $data->parent_id = $parentId;
        $data->bagian = $request->bagian;
        $data->nilai_min = $request->nilai_min;
        $data->nilai_max = $request->nilai_max;
        $data->bobot_nilai = $request->bobot_nilai ?: 100;
        $data->kategori_id = $kategoriId;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function delete(Request $request)
    {
        $data = Penilaian::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }

    public function deleteAll(Request $request)
    {
        $jumlah = Penilaian::where('kategori_id', $request->kategori_id)->count();
        Penilaian::where('kategori_id', $request->kategori_id)->delete();
        return redirect()->back()->with('success', $jumlah . ' aspek penilaian berhasil dihapus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}