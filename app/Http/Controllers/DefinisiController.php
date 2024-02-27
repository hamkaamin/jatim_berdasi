<?php

namespace App\Http\Controllers;

use App\Models\DefinisiOperasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DefinisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DefinisiOperasional::all();
        return view('master.definisi_operasional', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new DefinisiOperasional();
        } else {
            $data = DefinisiOperasional::findOrFail($request->id);
        }
        $data->nama = $request->nama;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = DefinisiOperasional::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}