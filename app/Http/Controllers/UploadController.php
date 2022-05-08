<?php

namespace App\Http\Controllers;

use Helper;
use App\Models\Indikator;
use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function add(Request $request)
    {
        $data = ($request->upload_id == 0) ? null : Upload::findOrFail($request->upload_id);
        $inovasi_id = $request->inovasi_id;
        $indikator_id = $request->indikator_id;
        $indikator = Indikator::findOrFail($request->indikator_id);
        $kolom = Helper::generateKolomUpload($indikator);
        return response()->json(array(
            'msg' => view('modal.form-upload', compact('inovasi_id', 'indikator_id', 'kolom', 'data'))->render()
        ), 200);
    }

    public function save(Request $request)
    {
        # code...
    }
}
