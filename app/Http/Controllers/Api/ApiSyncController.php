<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inovasi;
use Exception;
use Illuminate\Http\Request;

class ApiSyncController extends Controller
{
    
    public function kab_hit_data(Request $request)
    {
        $client = new \GuzzleHttp\Client(); 
        try{
            $arr_data = array();
            $inovasis = Inovasi::where('hit_data',1)->get();
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
                array_push($arr_data,$data);
            }
            $response = $client->request('POST', 'http://jatim-berdasi.prototypeyim.com/api/insert_inovasi', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'arr_data' => $arr_data
                ]
            ]);
            dd($response);
            $respon = json_decode($response->getBody()->getContents(), true);
            return response()->json([
                'status' => true,
                'message' => "All Data Inovasi!",
                'data' => $arr_data
            ], 200);
        }catch(Exception $error) {
            return response()->json([
                'status' => true,
                'message' => $error
            ], 500);
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