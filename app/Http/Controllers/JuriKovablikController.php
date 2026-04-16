<?php

namespace App\Http\Controllers;

use App\Models\JuriKovablik;
use App\Models\KelompokKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class JuriKovablikController extends Controller
{
    public function index()
    {
        $juri = JuriKovablik::get();
        $data_kelompok = KelompokKovablik::orderBy('id', 'asc')->get();
        return view('master.juri_kovablik', compact('juri', 'data_kelompok'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new JuriKovablik();
        } else {
            $data = JuriKovablik::findOrFail($request->id);
        }

        $data->user_id = $request->user_id;
        $data->kelompok_id = $request->kelompok_id;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = JuriKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
