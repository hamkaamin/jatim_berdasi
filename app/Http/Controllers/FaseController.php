<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class FaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Fase::get();
        return view('master.fase', compact('data'));
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
        $nama = $request->nama;
        $keterangan = $request->keterangan;
        $fase = Fase::orderBy('id', 'desc')->first();
        $lastid = (@$fase->id ?? 0) + 2;
        $active = $request->active;

        if ($request->id == 0) {
            $data = new Fase();
        } else {
            $data = Fase::findOrFail($request->id);
        }
        // $data = [
        //     'nama' => $nama,
        //     'keterangan' => $keterangan,
        //     'tahun' => $request->tahun,
        //     'tgl_berakhir' => $request->tgl_berakhir,
        //     'kode' => $lastid . date('His'),
        //     'active' => $active,
        // ];

        // Jika active bernilai 1, ubah semua record lain menjadi active = 0
        if ($active == 1) {
            Fase::where('active', 1)->update(['active' => 0,'timer'=>0]);
        }

        $data->nama = $request->nama;
        $data->keterangan = $request->keterangan;
        $data->tahun = $request->tahun;
        $data->tgl_berakhir = $request->tgl_berakhir;
        $data->kode = $request->kode;
        $data->active = $active;
        $data->timer = $active;
        // dd($data);
        $data->save();

        $stat = 'status';
        $msg = "Data Berhasil Disimpan"; 
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