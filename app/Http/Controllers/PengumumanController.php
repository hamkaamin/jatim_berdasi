<?php

namespace App\Http\Controllers;

use Config;
use Helper;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            try {
                DB::beginTransaction();
            
                $data->judul = $request->judul;
                $data->deskripsi = $request->deskripsi;
                $data->is_aktif = $request->is_aktif;
                $data->save();
            
                if ($request->hasFile('file')) {
                    $nama_file = Helper::save_file(
                        $request->file('file'),
                        uniqid(),
                        'file_pengumuman',
                        $data->file,
                        ['pdf', 'jpg', 'jpeg', 'png']
                    );
            
                    if ($nama_file['valid'] == false) {
                        DB::rollBack();
                        return redirect()->back()->with('error', $nama_file['message']);
                    } else {
                        $data->file = $nama_file['file_name'];
                        $data->save();
                    }
                }
            
                DB::commit();
                return redirect()->back()->with('success', Config::get('save_success'));
            
            } catch (\Throwable $th) {
                DB::rollBack();
                // Log error kalau perlu
                // Log::error($th->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
    }

    public function delete(Request $request)
    {
        $data = Pengumuman::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}