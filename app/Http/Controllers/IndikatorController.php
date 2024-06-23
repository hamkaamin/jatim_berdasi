<?php

namespace App\Http\Controllers;

use App\Models\DefinisiOperasional;
use Auth;
use Config;
use App\Models\Indikator;
use App\Models\Inovasi;
use App\Models\KategoriInovasi;
use App\Models\Parameter;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikator_inovasi = Indikator::where('label', 0)->get();
        // dd($indikator_inovasi);
        $indikator_provinsi = Indikator::where('label', 1)->get();
        $data_kategori = KategoriInovasi::orderBy('id','asc')->get();
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
        $data->kategori_id = $request->kategori_id;
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
        $indikator_id = $indikator->id;
        $param = $indikator->param()->get();
        $definisi_operasional = 0;
        $definisi = NULL;
        foreach($param as $item){
            if($item->definisi_operasional != null){
                $definisi_operasional ++;
                $definisi = Parameter::select('definisi_operasional')
                ->distinct('definisi_operasional')
                ->orderBy('definisi_operasional')
                ->get();
            }
        }
        $data_id = isset($request->provinsi_id) ? $request->provinsi_id : $request->inovasi_id;
        $definisi_operasional_list = DefinisiOperasional::where('indikator_id', $request->indikator_id)->get();
        $type = isset($request->provinsi_id) ? 'provinsi' : 'inovasi';
        return response()->json(array(
            'msg' => view('modal.form-param', compact('data_id','definisi','definisi_operasional', 'indikator', 'param', 'type','definisi_operasional_list','indikator_id'))->render()
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