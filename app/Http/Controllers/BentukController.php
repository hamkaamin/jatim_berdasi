<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Bentuk;
use Illuminate\Http\Request;

class BentukController extends Controller
{
    public function index()
    {
        $data = Bentuk::all();
        return view('master.bentuk', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Bentuk;
        } else {
            $data = Bentuk::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Bentuk::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
