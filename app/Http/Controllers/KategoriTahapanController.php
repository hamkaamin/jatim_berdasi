<?php

namespace App\Http\Controllers;

use App\Models\KategoriInovasi;
use App\Models\KategoriTahapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class KategoriTahapanController extends Controller
{
    public function index()
    {
        $data_kategori = KategoriInovasi::with('tahapan')->orderBy('kode','asc')->get();
        return view('master.kategori_tahapan', compact('data_kategori'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriTahapan();
            $kategori = KategoriTahapan::all();
            foreach($kategori as $item)
            if($request->kategori_id == $item->kategori_id && $request->tahapan_id == $item->tahapan_id ){
                $msg = 'Data Tidak Boleh Sama';
                return redirect()->back()->with('error',$msg);
            }
        } else {
            $data = KategoriTahapan::findOrFail($request->id);
            $kategori = KategoriTahapan::all();
            foreach($kategori as $item)
            if($request->kategori_id == $item->kategori_id && $request->tahapan_id == $item->tahapan_id ){
                $msg = 'Data Tidak Boleh Sama';
                return redirect()->back()->with('error',$msg);
            }
        }
        $data->kategori_id = $request->kategori_id;
        $data->tahapan_id = $request->tahapan_id;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriTahapan::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}