<?php

namespace App\Http\Controllers;

use App\Models\TahapanKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TahapanKovablikController extends Controller
{
    public function index()
    {
        $data = TahapanKovablik::all();
        return view('master.tahapan_kovablik', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new TahapanKovablik();
        } else {
            $data = TahapanKovablik::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = TahapanKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
