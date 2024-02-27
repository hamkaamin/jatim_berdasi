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
        $param2 = Parameter::select('definisi_operasional')
                ->distinct('definisi_operasional')
                ->orderBy('definisi_operasional')
                ->get();
        $append_data = $request->appendCount;
        return response()->json(array(
            'msg' => view('components.field-parameter', compact('param','param2','append_data'))->render()
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
            $data->definisi_operasional = $request->div_definisi[$key];
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

    public function show(Request $request)
    {
        $data = Parameter::where('definisi_operasional',$request->definisi_operasional)
        ->get();
        // dd($lantai);
        $str='';
        $str .= '<option value="0"> -- Tampilkan Semua --  </option>';
        foreach($data as $item){
           $str .= '<option value="'.$item->id.'"> '.$item->nama.')'.'</option>';
        }
        echo $str;
    }
}