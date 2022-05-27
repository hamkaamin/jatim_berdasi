<?php

namespace App\Http\Controllers;

use Config;
use Helper;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $data = Pengumuman::orderBy('created_at', 'desc')->get();
        return view('pengumuman', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Pengumuman;
        } else {
            $data = Pengumuman::findOrFail($request->id);
        }
        $data->judul = $request->judul;
        $data->deskripsi = $request->deskripsi;
        $data->save();
        if ($request->hasFile('file')) {
            $nama_file = Helper::save_file($request->file('file'), uniqid(), 'file_pengumuman', $data->file);
            $data->file = $nama_file;
		    $data->save();
        }
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Pengumuman::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
