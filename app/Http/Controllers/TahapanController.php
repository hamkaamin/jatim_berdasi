<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Tahapan;
use Illuminate\Http\Request;

class TahapanController extends Controller
{
    public function index()
    {
        $data = Tahapan::all();
        return view('master.tahapan', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Tahapan;
        } else {
            $data = Tahapan::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->urutan = $request->urutan;
        $data->tampilkan_kolom = $request->tampilkan_kolom;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Tahapan::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
