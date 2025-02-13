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
    public function index()
    {
        $penilaian = Penilaian::get();
        $data_kategori = KategoriInovasi::orderBy('id','asc')->get();
        return view('master.penilaian', compact('penilaian','data_kategori'));
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
        
        $data->bagian = $request->bagian;
        $data->indikator = $request->indikator;
        $data->nilai_min = $request->nilai_min;
        $data->nilai_max = $request->nilai_max;
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