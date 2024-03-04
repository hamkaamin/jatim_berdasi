<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inovasi;
use Illuminate\Http\Request;

class ApiSyncController extends Controller
{
    
    public function kab_hit_data(Request $request)
    {
        $inovasi = Inovasi::where('id',58)->first();
        $indikator_inovasi = $inovasi->indikator()->get();
        $tahapan_inovasi = $inovasi->tahapan()->get();
        $urusan_inovasi = $inovasi->urusan()->get();
        $upload_inovasi = $inovasi->upload()->get();
        $data = [
            'inovasi'=>$inovasi,
            'indikator_inovasi'=>$indikator_inovasi,
            'tahapan_inovasi'=>$tahapan_inovasi,
            'urusan_inovasi'=>$urusan_inovasi,
            'upload_inovasi'=>$upload_inovasi,
        ];
            
        $client = new \GuzzleHttp\Client(); 
        $penghuni = Penghuni_rusuns::select('ktp')->distinct()->whereIn('is_mbr',[0])->get(); 
        foreach($penghuni as $p)
        {
            try {
                $response = $client->request('POST', 'https://sikeluargamiskin.surabaya.go.id/api/ciptakarya/cek_gakin', [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Access-Key' => '11,W85KVGsuMpk1i0g52OR8Gp3wQlqZWVIuct5zRMJ3',
                        'Access-Id' => '11,6P6C1ocgxbufQ5cEaizOIxh03TY1ZYR1XaUj2a9m'
                    ],
                    'form_params' => [
                        'nik' => $p->ktp
                    ]
                ]);
                $respon = json_decode($response->getBody()->getContents(), true);
                if($respon['status'] == 1)
                {
                    $upd = Penghuni_rusuns::where('ktp', $p->ktp)->update(['is_mbr'=>1]); 
                    echo $p->ktp . '<br>';
                } else { 
                    $upd = Penghuni_rusuns::where('ktp', $p->ktp)->update(['is_mbr'=>3]); 
                }
            } catch (\Throwable $th) {
                $upd = Penghuni_rusuns::where('ktp', $p->ktp)->update(['is_mbr'=>2]); 
                echo $p->ktp . '  ' . $th->getMessage() . '<br>';
            }
        }  
    }
}