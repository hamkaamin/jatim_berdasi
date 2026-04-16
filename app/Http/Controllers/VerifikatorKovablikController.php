<?php

namespace App\Http\Controllers;

use App\Models\KelompokKovablik;
use App\Models\VerifikatorKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class VerifikatorKovablikController extends Controller
{
    public function index()
    {
        $verifikator = VerifikatorKovablik::get();
        $data_kelompok = KelompokKovablik::orderBy('id', 'asc')->get();
        return view('master.verifikator_kovablik', compact('verifikator', 'data_kelompok'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new VerifikatorKovablik();
        } else {
            $data = VerifikatorKovablik::findOrFail($request->id);
        }

        $data->user_id = $request->user_id;
        $data->kelompok_id = $request->kelompok_id;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = VerifikatorKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
