<?php

namespace App\Http\Controllers;

use App\Models\KategoriNilaiKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class KategoriNilaiKovablikController extends Controller
{
    public function index()
    {
        $data = KategoriNilaiKovablik::all();
        return view('master.kategori_nilai_kovablik', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriNilaiKovablik();
        } else {
            $data = KategoriNilaiKovablik::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriNilaiKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
