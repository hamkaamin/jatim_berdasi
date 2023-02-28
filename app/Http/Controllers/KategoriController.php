<?php

namespace App\Http\Controllers;

use App\Models\KategoriInvoasi;
use Illuminate\Http\Request;
use Config;

class KategoriController extends Controller
{
    public function index()
    {
        $data = KategoriInvoasi::all();
        return view('master.kategori', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriInvoasi;
        } else {
            $data = KategoriInvoasi::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriInvoasi::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}