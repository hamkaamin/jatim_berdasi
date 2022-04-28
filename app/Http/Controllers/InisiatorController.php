<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Inisiator;
use Illuminate\Http\Request;

class InisiatorController extends Controller
{
    public function index()
    {
        $data = Inisiator::all();
        return view('master.inisiator', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Inisiator;
        } else {
            $data = Inisiator::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Inisiator::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
