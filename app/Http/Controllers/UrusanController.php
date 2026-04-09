<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Urusan;
use Illuminate\Http\Request;

class UrusanController extends Controller
{
    public function index()
    {
        $data = Urusan::all();
        return view('master.urusan', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Urusan;
        } else {
            $data = Urusan::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Urusan::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
