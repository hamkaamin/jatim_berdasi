<?php

namespace App\Http\Controllers;

use Config;
use Helper;
use App\Models\Indikator;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function add(Request $request)
    {
        $data = ($request->upload_id == 0) ? null : Upload::findOrFail($request->upload_id);
        $id = $request->type == 1 ? $request->provinsi_id : $request->inovasi_id;
        $indikator_id = $request->indikator_id;
        $indikator = Indikator::findOrFail($request->indikator_id);
        $kolom = Helper::generateKolomUpload($indikator);
        $type = ($request->upload_id == 0) ? $request->type : $data->label;
        return response()->json(array(
            'msg' => view('modal.form-upload', compact('id', 'indikator_id', 'kolom', 'data', 'type'))->render()
        ), 200);
    }

    public function save(Request $request)
    {
        $indikator = Indikator::findOrFail($request->indikator_id);
        $kolom = Helper::generateKolomUpload($indikator);
        if ($request->id == 0) {
            $data = new Upload;
            $data->indikator_id = $request->indikator_id;
            if ($request->type == 1) {
                $data->provinsi_id = $request->provinsi_id;
            } else {
                $data->inovasi_id = $request->inovasi_id;
            }

        } else {
            $data = Upload::findOrFail($request->id);
        }
        foreach ($kolom as $col) {
            if ($col[2] == "file") {
                $validator = Validator::make($request->all(), [ 
                    'file' => 'max:4096', 
                ]);
                if ($validator->fails()) {
                    $msg = "";
                    foreach ($validator->messages()->all() as $message) {
                        $msg .= $message . ". ";
                    }
                    return redirect()->back()->with('error','Maximal 2MB');
                } else {
                    if($request->file($col[1])){

                        if ($request->file($col[1])) {
                            $nama_file = Helper::save_file(
                                $request->file('file'),
                                uniqid(),
                                'indikator_uploads',
                                $data->{$col[1]},
                                ['pdf', 'jpg', 'jpeg', 'png']
                            );
                    
                            if ($nama_file['valid'] == false) {
                                return redirect()->back()->with('error', $nama_file['message']);
                            } else {
                                $data->{$col[1]} = $nama_file['file_name'];
                                $data->save();
                            }
                        }
                    }
                }


                
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