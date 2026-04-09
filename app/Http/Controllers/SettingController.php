<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    public function index()
    {
        // Load the setting data from the database or any other source
        $setting = [
            'title' => 'Master Urusan Inovasi',
            'description' => 'Daftar Urusan untuk Data Inovasi',
            'delete_confirm' => 'Apakah anda yakin ingin menghapus data ini?',
        ];

        $data = Setting::get();

        // Load the setting view
        return view('setting.index',compact('data','setting'));
    }

    public function update(Request $request,$id)
    {
        $id = decrypt($id);
        $data = Setting::find($id);
        $data->is_aktif = $request->is_aktif;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }
}