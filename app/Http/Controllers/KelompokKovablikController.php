<?php

namespace App\Http\Controllers;

use App\Models\KelompokKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class KelompokKovablikController extends Controller
{
    public function index()
    {
        $data = KelompokKovablik::all();
        return view('master.kelompok_kovablik', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KelompokKovablik;
        } else {
            $data = KelompokKovablik::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KelompokKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
