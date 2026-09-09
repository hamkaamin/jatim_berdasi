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
        $perPage = 15;

        $data_kategori = KategoriInovasi::where('is_aktif', 1)->where('is_kovablik', 0)
            ->orderBy('id', 'asc')->get();

        $penilaianPerKategori = [];
        foreach ($data_kategori as $kat) {
            $penilaianPerKategori[$kat->id] = Penilaian::where('kategori_id', $kat->id)
                ->when($q !== '', function ($x) use ($q) {
                    $x->where(function ($w) use ($q) {
                        $w->where('bagian', 'ilike', "%{$q}%")
                          ->orWhere('indikator', 'ilike', "%{$q}%");
                    });
                })
                ->orderBy('bagian', 'asc')->orderBy('id', 'asc')
                ->paginate($perPage, ['*'], 'page_' . $kat->id)
                ->withQueryString();
        }

        return view('master.penilaian', compact('data_kategori', 'penilaianPerKategori', 'q'));
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

        $bobot_dipakai = Penilaian::where('kategori_id', $request->kategori_id)
            ->when($request->id != 0, function ($q) use ($request) {
                return $q->where('id', '!=', $request->id);
            })
            ->sum('bobot_nilai');
        if ($bobot_dipakai + (int) $request->bobot_nilai > 100) {
            return redirect()->back()->with('error', 'Total bobot nilai untuk kategori ini melebihi 100%. Sisa kuota: ' . (100 - $bobot_dipakai) . '%');
        }

        $data->bagian = $request->bagian;
        $data->indikator = $request->indikator;
        $data->nilai_min = $request->nilai_min;
        $data->nilai_max = $request->nilai_max;
        $data->bobot_nilai = $request->bobot_nilai ?: 100;
        $data->kategori_id = $request->kategori_id;
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