<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $data = Jabatan::all();
        return view('master.jabatan', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Jabatan;
        } else {
            $data = Jabatan::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Jabatan::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
