<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\KategoriInovasi;
use App\Models\KategoriOpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KategoriOPDAjaxController extends Controller
{
    public function index(Request $request,$kategori_id)
    {
        $data = [];
        if (isset($request->scope) && $request->scope != null && $request->{$request->scope.'_id'} != null) {
            $data = Helper::getOpd($request->scope, $request->{$request->scope.'_id'}, $data);
            return view('master.kategori_opd', compact('data'));
        }
        if (Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 6) {
            $data_kategori = KategoriInovasi::with('opd')->orderBy('kode','asc')->get();
            // $data = Opd::all();
        } elseif (Auth::user()->role == 3) {
            $data = Helper::getOpd('provinsi', Auth::user()->province_id, $data);
        } elseif (Auth::user()->role == 4) {
            $data = Helper::getOpd('kota', Auth::user()->regency_id, $data);
        } elseif (Helper::checkOpd('provinsi', Auth::user())) {
            $data = Helper::getOpd('provinsi', Auth::user()->opd->provinsi_id, $data);
        } elseif (Helper::checkOpd('kota', Auth::user())) {
            $data = Helper::getOpd('kota', Auth::user()->opd->kabkota_id, $data);
        } elseif (Helper::checkOpd('kecamatan', Auth::user())) {
            $data = Helper::getOpd('kecamatan', Auth::user()->opd->kecamatan_id, $data);
        } elseif (Helper::checkOpd('kelurahan', Auth::user())) {
            $data = Helper::getOpd('kelurahan', Auth::user()->opd->kelurahan_id, $data);
        }
        // dd($data_kategori);
        return view('master.kategori_opd_ajax', compact('data_kategori','kategori_id'));
    }

    public function table(Request $request,$kategori_id) {
        if ($request->ajax()) {
            $query = KategoriOpd::with('kategori', 'opd')
            ->where('kategori_id', $kategori_id)
            ->whereIn('opd_id', function ($query) {
                $query->select('id')->from('opds');
            });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('id', function($query) {
                    return $query->id; // Assuming 'lokasiDepartemen' is your relationship
                })
                ->addColumn('nama', function($query) {
                    return $query->kategori->nama; // Assuming 'lokasiDepartemen' is your relationship
                })
                ->addColumn('wilayah', function($query) {
                    return @$query->opd->nama; // Assuming 'lokasiDepartemen' is your relationship
                })
                ->addColumn('aktif', function($query) {
                    $button = $query->is_aktif == 1
                ? '<button class="btn m-1 btn-block btn-sm btn-success" type="submit" onclick="if(!confirm(\'Apakah anda ingin mengubah data ini menjadi No?\')){return false;}">Yes</button>'
                : '<button class="btn m-1 btn-block btn-sm btn-danger" type="submit" onclick="if(!confirm(\'Apakah anda ingin mengubah data ini menjadi Yes?\')){return false;}">No</button>';
            return $button;
                })
                ->addColumn('action', function($query){
                    return view('master.action_form_kategori', [
                        'q' => $query
                    ]);
                })
                ->rawColumns(['aktif', 'action']) // Specify columns containing HTML content
                ->make(true);
        }
    }
}