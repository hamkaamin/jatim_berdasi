<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inovasi;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class ApiSyncController extends Controller
{

    public function kab_hit_data(Request $request)
    {
        $client = new Client();
        try {
            $arr_data = array();
            $inovasis = Inovasi::where('hit_data', 1)->get();
            $users = User::where('name', 'ilike', '%' . env('APP_KABKOTA_NAME') . '%')->first();

            foreach ($inovasis as $inovasi) { 
                $indikator_inovasi = $inovasi->indikator()->get();
                $tahapan_inovasi = $inovasi->tahapan()->get();
                $urusan_inovasi = $inovasi->urusan()->get();
                $upload_inovasi = $inovasi->upload()->get();

                $data = [
                    'inovasi' => $inovasi,
                    'indikator_inovasi' => $indikator_inovasi,
                    'tahapan_inovasi' => $tahapan_inovasi,
                    'urusan_inovasi' => $urusan_inovasi,
                    'upload_inovasi' => $upload_inovasi,
                ];

                array_push($arr_data, $data);
            }
            
            // Convert the array to JSON
            $arr_data = json_encode($arr_data);
            $response = $client->request('POST', env('APP_PROV_URL', '') . '/api/insert_inovasi2', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'arr_data' => $arr_data,
                    'kabkota_kode' => $users->id,
                    'url'=>env('APP_URL')
                ], // Use 'body' instead of 'form_params'
                'verify' => false, // Disable SSL verification
            ]);
            $respon = json_decode($response->getBody()->getContents(), true); 
            if ($respon['status'] == true) {
                $inovasis = Inovasi::where('hit_data', 1)->update(
                    [
                        'hit_data' => 2,
                        'status' => 1
                    ]
                );
            }

            return response()->json([
                'status' => true,
                'message' => "Success Integrated with Provinsi!",
                'data' => $respon
            ], 200);
        } catch (RequestException $e) {
            throw $e;
            echo 'Error: ' . $e->getMessage();
        }
    } 
    public function kab_read_data(Request $request)
    {
        date_default_timezone_set('Asia/Makassar');

        $client = new Client();
        try {
            $response = $client->request('POST', env('APP_PROV_URL', '') . '/api/kab_status_data', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [  
                    'key'=>encrypt(date('Y-m-d')),
                    'url'=>encrypt(env('APP_URL')), 
                ], // Use 'body' instead of 'form_params'
                'verify' => false, // Disable SSL verification
            ]);
            $respon = json_decode($response->getBody()->getContents(), true);  
            foreach($respon as $d)
            {
                $inovasi_id = $d['kab_inovasis_id'];
                $inovasi = Inovasi::find($inovasi_id);
                dd($inovasi);
            }

            return response()->json([
                'status' => true,
                'message' => "Data provinsi",
                'data' => $respon
            ], 200);
        } catch (RequestException $e) {
            throw $e;
            echo 'Error: ' . $e->getMessage();
        }
    } 

    public function kab_status_data(Request $request)
    {
        date_default_timezone_set('Asia/Makassar');

        try { 
            $key = decrypt($request->key);
            $url = decrypt($request->url);
            if($key == date('Y-m-d')){
                $inovasi = Inovasi::whereHas('integration', function ($query) use ($url) {
                    $query->where('url', $url);
                })->get();
                return response()->json($inovasi);
            } else {
                return response()->json(false, 401);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 401);
            throw $th;
        }
    }
    
}
