<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\KategoriInovasi;
use App\Models\KategoriOpd;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;

class KategoriOPDController extends Controller
{
    public function index(Request $request)
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
        return view('master.kategori_opd', compact('data_kategori'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriOpd();
            $kategori = KategoriOpd::all();
            foreach($kategori as $item)
            if($request->kategori_id == $item->kategori_id && $request->opd_id == $item->opd_id ){
                $msg = 'Data Tidak Boleh Sama';
                return redirect()->back()->with('error',$msg);
            }
        } else {
            $data = KategoriOpd::findOrFail($request->id);
            $kategori = KategoriOpd::all();
            foreach($kategori as $item)
            if($request->kategori_id == $item->kategori_id && $request->opd_id == $item->opd_id ){
                $msg = 'Data Tidak Boleh Sama';
                return redirect()->back()->with('error',$msg);
            }
        }
        $data->kategori_id = $request->kategori_id;
        $data->opd_id = $request->opd_id;
		$data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function switch(Request $request)
    {
        $id = $request->id;
        $is_aktif = 1;
        $kategori_opd = KategoriOpd::find($id);
        if($kategori_opd->is_aktif == 1){
            $is_aktif = 0;
        }
        $kategori_opd->is_aktif = $is_aktif;
        $kategori_opd->save();
        return redirect()->back()->with('success', Config::get('save_success'));

    }

    public function delete(Request $request)
    {
        $data = KategoriOpd::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }

    public function show(Request $request)
    {
        $data_kategori = KategoriInovasi::with('opd')->orderBy('kode','asc')->get();
        return view('master.show_kategoriopd',compact('data_kategori'));
    }

    public function table(Request $request) {
        if ($request->ajax()) {
            $data = KategoriInovasi::with('opd')->orderBy('kode','asc')->get();

            dd(DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($query){
                //     $action = [
                //         [
                //             'title' => '<i class="fa fa-edit"></i> Edit',
                //             'route_name' => 'master_data.lokasi.edit',
                //             'url' => route('master_data.lokasi.edit', ['id' => $query->id]),
                //         ],
                //         [
                //             'title' => '<i class="fa fa-trash"></i> Delete',
                //             'is_delete' => true,
                //             'route_name' => 'master_data.lokasi.delete',
                //             'url' => route('master_data.lokasi.delete'),
                //             'data_id' => $query->id
                //         ]
                //     ];

                //     return view('global_components.action_menu_dt', [
                //         'q' => $query,
                //         'action' => $action
                //     ]);
                // })
                // ->editColumn('created_at', function($query) {
                //     return formatDate($query->created_at);
                // })
                // ->editColumn('updated_at', function($query) {
                //     return formatDate($query->updated_at);
                // })
                // ->rawColumns(['action'])
                ->make(true));
        }
    }

    
}