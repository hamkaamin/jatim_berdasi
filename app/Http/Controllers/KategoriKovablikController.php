<?php

namespace App\Http\Controllers;

use App\Models\KategoriKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class KategoriKovablikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KategoriKovablik::all();
        return view('master.kategori_kovablik', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriKovablik;
        } else {
            $data = KategoriKovablik::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
