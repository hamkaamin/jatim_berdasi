<?php

namespace App\Http\Controllers;

use App\Models\Tematik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TematikController extends Controller
{
    public function index()
    {
        $data = Tematik::all();
        return view('master.tematik', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Tematik;
        } else {
            $data = Tematik::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Tematik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}