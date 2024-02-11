<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use App\Models\Indikator;
use App\Models\Inovasi;
use App\Models\KategoriInvoasi;
use App\Models\Parameter;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikator_inovasi = Indikator::where('label', 0)->get();
        $indikator_provinsi = Indikator::where('label', 1)->get();
        $data_kategori = KategoriInvoasi::all();
        return view('master.indikator', compact('indikator_inovasi', 'indikator_provinsi','data_kategori'));
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
        $data->label = $request->label;
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
        $indikator = Indikator::findOrFail($request->indikator_id);
        $param = $indikator->param()->get();
        $data_id = isset($request->provinsi_id) ? $request->provinsi_id : $request->inovasi_id;
        $type = isset($request->provinsi_id) ? 'provinsi' : 'inovasi';
        return response()->json(array(
            'msg' => view('modal.form-param', compact('data_id', 'indikator', 'param', 'type'))->render()
        ), 200);
    }

    public function saveParam(Request $request)
    {
        $inovasi = Inovasi::findOrFail($request->inovasi_id);
        $param = Parameter::findOrFail($request->param);
        if (Auth::user()->role == 2) {
            $inovasi->indikator()->updateExistingPivot($request->indikator_id, [
                'param_akhir' => $param->nama,
                'bobot_akhir' => $param->bobot,
                'catatan' => $request->catatan,
            ]);
        } else {
            $inovasi->indikator()->updateExistingPivot($request->indikator_id, [
                'param_awal' => $param->nama,
                'bobot_awal' => $param->bobot
            ]);
        }

        return redirect()->back()->with('success', Config::get('save_success'));
    }
}