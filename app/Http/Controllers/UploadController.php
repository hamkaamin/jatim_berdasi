<?php

namespace App\Http\Controllers;

use Config;
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
        $indikator = Indikator::findOrFail($request->indikator_id);
        $kolom = Helper::generateKolomUpload($indikator);
        if ($request->id == 0) {
            $data = new Upload;
            $data->indikator_id = $request->indikator_id;
            $data->inovasi_id = $request->inovasi_id;
        } else {
            $data = Upload::findOrFail($request->id);
        }
        foreach ($kolom as $col) {
            if ($col[2] == "file" && $request->hasFile($col[1])) {
                $nama_file = Helper::save_file($request->file($col[1]), uniqid(), 'indikator_uploads', $data->{$col[1]});
                $data->{$col[1]} = $nama_file;
            } else {
                $data->{$col[1]} = $request->{$col[1]};
            }
        }
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Upload::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
