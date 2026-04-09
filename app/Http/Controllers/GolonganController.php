<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    public function index()
    {
        $data = Golongan::all();
        return view('master.golongan', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Golongan;
        } else {
            $data = Golongan::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Golongan::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}