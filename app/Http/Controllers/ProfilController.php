<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('profil');
    }

    public function change_pass(Request $request)
    {
        if ($request->new_password == $request->confirm_password) {
            Auth::user()->password = Hash::make($request->confirm_password);
            Auth::user()->save();
            return redirect()->back()->with('success', 'Password berhasil diubah !');
        }
        return redirect()->back()->with('error', 'Password belum sesuai dengan konfirmasinya !');
    }
}
