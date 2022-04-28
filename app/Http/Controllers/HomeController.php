<?php

namespace App\Http\Controllers;

use App\Models\Bentuk;
use App\Models\Faq;
use App\Models\Golongan;
use App\Models\Indikator;
use App\Models\Inisiator;
use App\Models\Jabatan;
use App\Models\Jenis;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Opd;
use App\Models\Parameter;
use App\Models\Provinsi;
use App\Models\Tahapan;
use App\Models\Urusan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
	{
		return view('welcome');
	}

	public function modal(Request $request)
	{
		switch ($request->type) {
            case "tahapan":
                $data = ($request->id == 0) ? null : Tahapan::findOrFail($request->id);
                return response()->json(array(
                    'msg' => view('modal.form-tahapan', compact('data'))->render()
                ), 200);
                break;
			case "inisiator":
                $data = ($request->id == 0) ? null : Inisiator::findOrFail($request->id);
                return response()->json(array(
                    'msg' => view('modal.form-inisiator', compact('data'))->render()
                ), 200);
                break;
			case "jenis":
				$data = ($request->id == 0) ? null : Jenis::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-jenis', compact('data'))->render()
				), 200);
				break;
			case "urusan":
				$data = ($request->id == 0) ? null : Urusan::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-urusan', compact('data'))->render()
				), 200);
				break;
			case "bentuk":
				$data = ($request->id == 0) ? null : Bentuk::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-bentuk', compact('data'))->render()
				), 200);
				break;
			case "jabatan":
				$data = ($request->id == 0) ? null : Jabatan::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-jabatan', compact('data'))->render()
				), 200);
				break;
			case "golongan":
				$data = ($request->id == 0) ? null : Golongan::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-golongan', compact('data'))->render()
				), 200);
				break;
			case "faq":
				$data = ($request->id == 0) ? null : Faq::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-faq', compact('data'))->render()
				), 200);
				break;
			case "indikator":
				$data = ($request->id == 0) ? null : Indikator::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-indikator', compact('data'))->render()
				), 200);
				break;
			case "parameter":
				$data = Parameter::where('indikator_id', $request->id)->get();
				$indi = Indikator::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-parameter', compact('data', 'indi'))->render()
				), 200);
				break;
			case "opd":
				$data = ($request->id == 0) ? null : Opd::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-opd', compact('data'))->render()
				), 200);
				break;
        }
	}

	public function change_area(Request $request)
	{
		if ($request->scopeNext == 'kota') {
			$data = Kota::where('province_id', $request->selfId)->get();
		} elseif ($request->scopeNext == 'kecamatan') {
			$data = Kecamatan::where('regency_id', $request->selfId)->get();
		} elseif ($request->scopeNext == 'kelurahan') {
			$data = Kelurahan::where('district_id', $request->selfId)->get();
		}
		$html = "<option disabled selected>-- Pilih Salah Satu --</option>";
		foreach ($data as $item) {
			$html .= "<option value='".$item->id."'>".$item->name."</option>";
		}
		return response()->json(array(
			'msg' => $html
		), 200);
	}
}
