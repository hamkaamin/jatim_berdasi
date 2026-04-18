<?php

namespace App\Http\Controllers;

use App\Models\KategoriInovasi;
use Illuminate\Http\Request;
use Config;

class KategoriController extends Controller
{
    public function index()
    {
        $data = KategoriInovasi::orderBy('id', 'asc')->get();
        return view('master.kategori', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriInovasi;
        } else {
            $data = KategoriInovasi::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->is_aktif = $request->is_active;
        $data->is_kovablik = $request->is_kovablik;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriInovasi::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
