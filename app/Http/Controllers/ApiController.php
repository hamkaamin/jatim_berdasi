<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function all_opd()
    {

        $opd = Opd::all();

        return response()->json([
            'status' => true,
            'message' => "All OPD!",
            'opd' => $opd
        ], 200);
        
    }
}