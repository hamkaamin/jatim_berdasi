<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function add(Request $request)
    {
        $param = null;
        return response()->json(array(
            'msg' => view('components.field-parameter', compact('param'))->render()
        ), 200);
    }

    public function save(Request $request)
    {
        foreach ($request->parameter_id as $key => $value) {
            if ($value == 0) {
                $data = new Parameter;
            } else {
                $data = Parameter::findOrFail($value);
            }
            $data->nama = $request->nama[$key];
            $data->bobot = $request->bobot[$key];
            $data->indikator_id = $request->indikator_id;
            $data->save();
        }
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Parameter::findOrFail($request->id);
        $data->delete();
    }
}
