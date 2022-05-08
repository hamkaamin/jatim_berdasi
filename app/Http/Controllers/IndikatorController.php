<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Indikator;
use App\Models\Inovasi;
use App\Models\Parameter;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index()
    {
        $data = Indikator::all();
        return view('master.indikator', compact('data'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new Indikator;
        } else {
            $data = Indikator::findOrFail($request->id);
        }
        $data->nama = $request->nama;
        $data->keterangan = $request->keterangan;
        $data->data_pendukung = $request->data_pendukung;
        $data->tipe_file = $request->tipe_file;
        $data->wajib = $request->wajib;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = Indikator::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }

    public function chooseParam(Request $request)
    {
        $inovasi_id = $request->inovasi_id;
        $indikator_id = $request->indikator_id;
        $indikator = Indikator::findOrFail($request->indikator_id);
        $param = $indikator->param()->get();
        return response()->json(array(
            'msg' => view('modal.form-param', compact('inovasi_id', 'indikator_id', 'param'))->render()
        ), 200);
    }

    public function saveParam(Request $request)
    {
        $inovasi = Inovasi::findOrFail($request->inovasi_id);
        $param = Parameter::findOrFail($request->param);
        $inovasi->indikator()->updateExistingPivot($request->indikator_id, [
            'param_awal' => $param->nama,
            'bobot_awal' => $param->bobot
        ]);
        return redirect()->back()->with('success', Config::get('save_success'));
    }
}
