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
        $validator = Validator::make($request->all(), [ 
            'file_rancang_bangun' => 'mimes:pdf,docx,doc,jpg,jpeg,png,xlsx|max:2048', 
            'profil_bisnis' => 'mimes:pdf,doc,jpg,jpeg,png,xlsx|max:2048', 
            'anggaran' => 'mimes:pdf,doc,jpg,jpeg,png,xlsx|max:2048', 
        ], [  
            'file_rancang_bangun.mimes' => 'File harus pdf / doc / jpg / jpeg / png / xlsx',
            'file_rancang_bangun.max' => 'File maksimal berukuran 2MB', 
            'profil_bisnis.mimes' => 'File harus pdf / doc / jpg / jpeg / png / xlsx',
            'profil_bisnis.max' => 'File maksimal berukuran 2MB', 
            'anggaran.mimes' => 'File harus pdf / doc / jpg / jpeg / png / xlsx',
            'anggaran.max' => 'File maksimal berukuran 2MB', 
        ]);
        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->all() as $message) {
                $msg .= $message . ". ";
            }
            return redirect()->back()->with('error', $msg)->withInput($request->input());

        } else {
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
    }

    public function delete(Request $request)
    {
        $data = Pengumuman::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}