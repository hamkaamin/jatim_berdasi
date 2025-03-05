<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\KategoriInovasi;
use App\Models\Parameter;
use Illuminate\Http\Request;

class InovasiController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','refresh','logout']]);
    }
    public function indikator_parameter(Request $request)
    {
        //try catch all exceptions
        try {   
            $indikator = Indikator::orderBy('id','asc')->get();
            $parameter = Parameter::orderBy('id','asc')->get();
            $kategori = KategoriInovasi::orderBy('id','asc')->get();
            
            return response()->json([
                'kategori' => $kategori,
                'indikator' => $indikator,
                'parameter' => $parameter
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
               'message' => $e->getMessage()
            ], 500);
        }



    }
}