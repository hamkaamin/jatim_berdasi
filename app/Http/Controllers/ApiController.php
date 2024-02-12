<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function all_opd()
    {
        try{
        $opd = Opd::all();

        return response()->json([
            'status' => true,
            'message' => "All OPD!",
            'opd' => $opd
        ], 200);
    }
        catch (Exception $error) {
            return response()->json([
                'status' => true,
                'message' => $error
            ], 500);
        }
        
    }
}