<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $data = Jenis::all();
        return view('master.jenis', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Jenis;
        } else {
            $data = Jenis::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Jenis::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
