<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Inovasi;
use App\Models\Opd;
use App\Models\Tahapan;
use App\Models\Upload;
use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function all_opd()
    {
        try{
            $opd = Opd::all();

        return response()->json([
            'status' => true,
            'message' => "All OPD!",
            'opd' => $opd
        ], 200);
        }
        catch (Exception $error) {
            return response()->json([
                'status' => true,
                'message' => $error
            ], 500);
        }
        
    }

    public function insert_inovasi_test(Request $request)
    {
        try{
            $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();

            $inovasi = new Inovasi();
            $inovasi->kode = uniqid();
            $inovasi->nama = $request->nama;
            $inovasi->tahapan_id = $request->tahapan_id;
            $inovasi->kategori_id = $request->kategori_id;
            $inovasi->inisiator_id = $request->inisiator_id;
            $inovasi->jenis_id = $request->jenis_id;
            $inovasi->bentuk_id = $request->bentuk_id;
            $inovasi->covid = $request->covid;
            $inovasi->rancang_bangun = $request->rancang_bangun;
            $inovasi->tujuan = $request->tujuan;
            $inovasi->manfaat = $request->manfaat;
            $inovasi->hasil = $request->hasil;
            $inovasi->status = $request->status;
            $inovasi->label = $request->label;
            $inovasi->kota_id = $request->kota_id;
            $inovasi->user_id = $request->user_id;
            $inovasi->anggaran = $request->anggaran;
            $inovasi->file_rancang_bangun = $request->file_rancang_bangun;
            $inovasi->profil_bisnis = $request->profil_bisnis;
            $inovasi->save();
            $inovasi->urusan()->sync($request->urusan_id);
            foreach ($tahapanKolom as $item) {
                $tempArr[$item->id] = ['waktu' => $request->{'waktu_tahapan_'.$item->id}];
            }
            $inovasi->tahapan()->sync($tempArr);
            $data = [];
            if ($inovasi->indikator()->count() == 0) {
                $indikator = Indikator::where('label', 0)->where('kategori_id',$inovasi->kategori_id)->get();
                foreach ($indikator as $item) {
                    $inovasi->indikator()->attach($item->id,['kategori_id'=>$item->kategori_id]);
                }
            }
            $data = $inovasi->indikator()->get();
            $data_upload = [];
            foreach ($data as $item) {
                $uploads = Upload::where('inovasi_id', $inovasi->id)
                                ->where('indikator_id', $item->pivot->indikator_id)
                                ->get();
                $data_upload = array_merge($data_upload, $uploads->toArray());
            }
            return response()->json([
                'status' => true,
                'message' => "All OPD!",
                'data' => $data
            ], 200);
        }
        catch (Exception $error) {
            return response()->json([
                'status' => true,
                'message' => $error
            ], 500);
        }
    }

    public function insert_inovasi(Request $request)
    {
        $client = new \GuzzleHttp\Client(); 
            try {
                $response = $client->request('GET', 'http://localhost:8000/api/kab_hit_data', [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ]
                ]);
                $respon = json_decode($response->getBody()->getContents(), true);
                dd($respon);
              
            } catch (\Throwable $th) {
                echo $th;
            }
        }  

}