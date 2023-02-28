<?php

namespace App\Http\Controllers;

use App\Models\MasterPanduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanduanController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $data = MasterPanduan::where('role',$role)->get();
        if($role == 1 || $role ==3){
            $data = MasterPanduan::all();
        }
        return view('panduan.index',compact('data'));
    }
}