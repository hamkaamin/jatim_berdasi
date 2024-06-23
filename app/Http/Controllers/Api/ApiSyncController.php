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
        try{
            $arr_data = array();
            $inovasis = Inovasi::where('hit_data',1)->get();
            $users = User::where('name', 'ilike', '%'.env('APP_KABKOTA_NAME').'%')->first();

            foreach($inovasis as $inovasi){
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
                
                array_push($arr_data, $data);
            }
            // Convert the array to JSON
            $arr_data = json_encode($arr_data);
            $response = $client->request('POST', 'http://jatimberdasi.brida.jatimprov.go.id/api/insert_inovasi2', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' =>[
                    'arr_data'=>$arr_data,
                    'kabkota_kode'=>$users->id
                ], // Use 'body' instead of 'form_params'
                'verify' => false, // Disable SSL verification
            ]);
            $respon = json_decode($response->getBody()->getContents(), true);
            if($respon['status'] == true){
                $inovasis = Inovasi::where('hit_data',1)->update(
                    [
                        'hit_data' =>2
                    ]);
            }
            
            return response()->json([
                'status' => true,
                'message' => "All Data Inovasi!",
                'data' => $respon
            ], 200);
        }catch(RequestException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // public function hit_data_test(Request $request)
    // {
    //     $inovasi = Inovasi::where('hit_data', 1)->get();

    //     // Initialize arrays to hold data
    //     $indikator_inovasi = [];
    //     $tahapan_inovasi = [];
    //     $urusan_inovasi = [];
    //     $upload_inovasi = [];

    //     foreach ($inovasi as $item) {
    //         // Get related data for each inovasi
    //         $indikator_inovasi[] = $item->indikator()->get();
    //         $tahapan_inovasi[] = $item->tahapan()->get();
    //         $urusan_inovasi[] = $item->urusan()->get();
    //         $upload_inovasi[] = $item->upload()->get();
    //     }

    //     // Construct the data array
    //     $data = [
    //         'inovasi' => $inovasi,
    //         'indikator_inovasi' => $indikator_inovasi,
    //         'tahapan_inovasi' => $tahapan_inovasi,
    //         'urusan_inovasi' => $urusan_inovasi,
    //         'upload_inovasi' => $upload_inovasi,
    //     ];

    //     // Convert the data array to JSON
    //     $jsonData = json_encode($data);

    //     // Set appropriate headers for JSON response
    //     // header('Content-Type: application/json');

    //     // Return the JSON response
    //     dd($data['indikator_inovasi'][0]['nama']);
    // }
}