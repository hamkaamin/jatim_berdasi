<?php

namespace App\Http\Controllers;

use App\Models\DefinisiOperasional;
use App\Models\Indikator;
use App\Models\KategoriInovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DefinisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DefinisiOperasional::all();
        return view('master.definisi_operasional', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new DefinisiOperasional();
        } else {
            $data = DefinisiOperasional::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->kategori_id = $request->kategori_id;
        $data->indikator_id = $request->indikator_id;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = DefinisiOperasional::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }

    public function show_indikator(Request $request)
    {
        $data = Indikator::where('kategori_id',$request->kategori_id)->get();
        $str='';
        $str .= '<option value=""> -- Tampilkan Semua --  </option>';
        foreach($data as $item){
           $str .= '<option value="'.$item->id.'"> '.$item->nama.''.'</option>';
        }
        return $str;
        // return view('inovasi.show_tahapan',compact($data));
    }
}