<?php

namespace App\Http\Controllers;

use App\Models\Bentuk;
use App\Models\Inisiator;
use App\Models\Jenis;
use App\Models\Urusan;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index($type)
    {
        $data = [];
        if ($type == 'jenis') {
            $data = Jenis::all();
        } elseif ($type == 'bentuk') {
            $data = Bentuk::all();
        } elseif ($type == 'inisiator') {
            $data = Inisiator::all();
        } elseif ($type == 'urusan') {
            $data = Urusan::all();
        }
        return view('rekap', compact('data', 'type'));
    }
}
