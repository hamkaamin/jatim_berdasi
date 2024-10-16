<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Inovasi;
use App\Models\Integration;
use App\Models\Opd;
use App\Models\Tahapan;
use App\Models\Upload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
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
            $inovasi->status = 1;
            $inovasi->label = $request->label;
            $inovasi->kota_id = $request->kota_id;
            $inovasi->user_id = $request->user_id;
            $inovasi->anggaran = $request->anggaran;
            $inovasi->file_rancang_bangun = $request->file_rancang_bangun;
            $inovasi->profil_bisnis = $request->profil_bisnis;
            $inovasi->keterangan = $request->keterangan;
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

    // public function insert_inovasi(Request $request)
    // {
    //     dd($request->all());
    //         try {
    //             $inovasi = new Inovasi();
    //             $inovasi->kode = $data_inovasi['kode'];
    //             $inovasi->nama = $data_inovasi['nama'];
    //             $inovasi->tahapan_id = $data_inovasi['tahapan_id'];
    //             $inovasi->kategori_id = $data_inovasi['kategori_id'];
    //             $inovasi->inisiator_id = $data_inovasi['inisiator_id'];
    //             $inovasi->jenis_id = $data_inovasi['jenis_id'];
    //             $inovasi->bentuk_id = $data_inovasi['bentuk_id'];
    //             $inovasi->covid = $data_inovasi['covid'];
    //             $inovasi->rancang_bangun = $data_inovasi['rancang_bangun'];
    //             $inovasi->tujuan = $data_inovasi['tujuan'];
    //             $inovasi->manfaat = $data_inovasi['manfaat'];
    //             $inovasi->hasil = $data_inovasi['hasil'];
    //             $inovasi->status = $data_inovasi['status'];
    //             $inovasi->label = $data_inovasi['label'];
    //             $inovasi->kota_id = $data_inovasi['kota_id'];
    //             $inovasi->user_id = $data_inovasi['user_id'];
    //             $inovasi->anggaran = $data_inovasi['anggaran'];
    //             $inovasi->file_rancang_bangun = $data_inovasi['file_rancang_bangun'];
    //             $inovasi->profil_bisnis = $data_inovasi['profil_bisnis'];

    //             // Save the changes
    //             $inovasi->save();
    //             $inovasi->urusan()->sync($inovasi->urusan_id);

    //             $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
    //             $tempArr = [];
    //             foreach ($tahapanKolom as $item) {
    //                 $tempArr[$item->id] = ['waktu' => $inovasi->{'waktu_tahapan_'.$item->id}];
    //             }
    //             $inovasi->tahapan()->sync($tempArr);
    //             // $indikator = Indikator::where('label', 0)->where('kategori_id',$inovasi->kategori_id)->get();
    //             // foreach ($indikator as $item) {
    //             //     $inovasi->indikator()->attach($item->id,['kategori_id'=>$item->kategori_id]);
    //             // }
    //             foreach($data_indikator_inovasi as $item)
    //             $inovasi_indikator= DB::table('indikator_inovasi')->insert([
    //                 'indikator_id'=>$item['pivot']['indikator_id'],
    //                 'inovasi_id'=>$item['pivot']['inovasi_id'],
    //                 'param_awal'=>$item['pivot']['param_awal'],
    //                 'param_akhir'=>$item['pivot']['param_akhir'],
    //                 'bobot_awal'=>$item['pivot']['bobot_awal'],
    //                 'bobot_akhir'=>$item['pivot']['bobot_akhir'],
    //                 'catatan'=>$item['pivot']['catatan'],
    //             ]);

    //             foreach($data_upload_inovasi as $item)
    //             $inovasi_uploads= DB::table('uploads')->insert([
    //                 'judul'=>$item['judul'],
    //                 'inovasi_id'=>$inovasi->id,
    //                 'no_dokumen'=>$item['no_dokumen'],
    //                 'tgl_dokumen'=>$item['tgl_dokumen'],
    //                 'tentang'=>$item['tentang'],
    //                 'url'=>$item['url'],
    //                 'cover'=>$item['cover'],
    //                 'file'=>$item['file'],
    //                 'created_at'=>$item['created_at'],
    //                 'updated_at'=>$item['updated_at'],
    //                 'indikator_id'=>$item['indikator_id'],
    //                 'provinsi_id'=>$item['provinsi_id'],
    //             ]);

              
    //         } catch (\Throwable $th) {
    //             echo $th;
    //         }
    // }  

    public function insert_inovasi2(Request $request)
    {
        DB::beginTransaction(); 
        $ipAddress = $request->ip();
        $arr_data = $request->arr_data;
        $kabkota_kode = $request->kabkota_kode;
        $url = $request->url;
        $n = new Integration(); 
        $n->ip = $ipAddress;
        $n->url = $url;
        $n->kabkota_kode = $kabkota_kode;
        $n->arr_data = $arr_data;
        $n->save();

        try {
            $arr_data = $request->arr_data;
            $arr_data = json_decode($arr_data, true);
    
            foreach ($arr_data as $item) {
                $data_inovasi = $item['inovasi'];
                $data_indikator_inovasi = $item['indikator_inovasi'];
                $data_upload_inovasi = $item['upload_inovasi'];
    
                $inovasi = new Inovasi(); 
                $inovasi->kab_integration_id = $n->id;
                $inovasi->kab_inovasis_id = $data_inovasi['id'];
                $inovasi->kode = $data_inovasi['kode'];
                $inovasi->nama = $data_inovasi['nama'];
                $inovasi->covid = $data_inovasi['covid'];
                $inovasi->rancang_bangun = $data_inovasi['rancang_bangun'];
                $inovasi->tujuan = $data_inovasi['tujuan'];
                $inovasi->manfaat = $data_inovasi['manfaat'];
                $inovasi->hasil = $data_inovasi['hasil'];
                $inovasi->anggaran = $data_inovasi['anggaran'];
                $inovasi->profil_bisnis = $data_inovasi['profil_bisnis'];
                $inovasi->status = $data_inovasi['status'];
                $inovasi->keterangan = $data_inovasi['keterangan'];
                // $inovasi->created_at = $data_inovasi['created_at'];
                // $inovasi->updated_at = $data_inovasi['updated_at'];
                // $inovasi->deleted_at = $data_inovasi['deleted_at'];
                $inovasi->tahapan_id = $data_inovasi['tahapan_id'];
                $inovasi->inisiator_id = $data_inovasi['inisiator_id'];
                $inovasi->jenis_id = $data_inovasi['jenis_id'];
                $inovasi->bentuk_id = $data_inovasi['bentuk_id'];
                $inovasi->label = $data_inovasi['label'];
                $inovasi->kota_id = $data_inovasi['kota_id'];
                $inovasi->kecamatan_id = $data_inovasi['kecamatan_id'];
                $inovasi->kelurahan_id = $data_inovasi['kelurahan_id'];
                $inovasi->provinsi_id = $data_inovasi['provinsi_id'];
                $inovasi->kategori_id = $data_inovasi['kategori_id'];
                $inovasi->file_rancang_bangun = $data_inovasi['file_rancang_bangun'];
                $inovasi->url = $data_inovasi['url'];
                $inovasi->hit_data = $data_inovasi['hit_data'];
                $inovasi->waktu_uji_coba = $data_inovasi['waktu_uji_coba'];
                $inovasi->waktu_penerapan = $data_inovasi['waktu_penerapan'];
                $inovasi->tematik_id = $data_inovasi['tematik_id'];
                $inovasi->nama_inisiator = $data_inovasi['nama_inisiator'];
                $inovasi->file_anggaran = $data_inovasi['file_anggaran'];
                $inovasi->file_dokumen_haki = $data_inovasi['file_dokumen_haki'];
                $inovasi->file_penghargaan = $data_inovasi['file_penghargaan'];
                $inovasi->detail_tematik_id = $data_inovasi['detail_tematik_id'];
                $inovasi->waktu_pengembangan = $data_inovasi['waktu_pengembangan'];
                $inovasi->is_pengembangan = $data_inovasi['is_pengembangan'];
                
                $inovasi->user_id = $request->kabkota_kode; 
                $inovasi->save();
    
                // Sync 'urusan' relationship = urusan_id dapet dari mana ?
                $inovasi->urusan()->sync($inovasi->urusan_id);
    
                // Sync 'tahapan' relationship
                $tempArr = [];
                // $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
                // foreach ($tahapanKolom as $tahapan) {
                //     $tempArr[$tahapan->id] = ['waktu' => $data_inovasi['waktu_tahapan_'.$tahapan->id]];
                // }
                // $inovasi->tahapan()->sync($tempArr);
    
                // Insert 'indikator_inovasi' records
                foreach ($data_indikator_inovasi as $dataindikator) {
                    DB::table('indikator_inovasi')->insert([
                        'kab_indikator_id' => $dataindikator['pivot']['indikator_id'],
                        'kab_inovasi_id' => $dataindikator['pivot']['inovasi_id'],

                        'inovasi_id' => $inovasi->id, // dari aplikasi terkait
                        'indikator_id' => $dataindikator['pivot']['indikator_id'],
                        'param_awal' => $dataindikator['pivot']['param_awal'],
                        // 'param_akhir' => $dataindikator['pivot']['param_akhir'],
                        'bobot_awal' => $dataindikator['pivot']['bobot_awal'],
                        // 'bobot_akhir' => $dataindikator['pivot']['bobot_akhir'], 
                        'catatan' => $dataindikator['pivot']['catatan'],
                    ]);
                }
    
                // Insert 'uploads' records
                foreach ($data_upload_inovasi as $upload) {
                    DB::table('uploads')->insert([
                        'kab_uploads_id' => $upload['id'],

                        'inovasi_id' => $inovasi->id, // dari aplikasi terkait
                        'judul' => $upload['judul'],
                        'no_dokumen' => $upload['no_dokumen'],
                        'tgl_dokumen' => $upload['tgl_dokumen'],
                        'tentang' => $upload['tentang'],
                        'url' => $upload['url'],
                        'cover' => $upload['cover'],
                        'file' => $upload['file'], 
                        'indikator_id' => $upload['indikator_id'],
                        'provinsi_id' => $upload['provinsi_id'],
                    ]);
                }
            }
    
            // Commit transaction
            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => "Integration Success!",
                'data' => $arr_data
            ], 200);
        } catch (\Exception $e) {
            // Rollback transaction on failure
            DB::rollback();
    
            return response()->json([
                'status' => false,
                'message' => "Failed to save data: " . $e->getMessage(),
            ], 500);
        }
        
        // $arr_data_decode = json_encode($arr_data,true);
        // return $request->all();
    }


    public function kab_status_data_update(Request $request)
    {
        // try {
            DB::beginTransaction();

            $inovasi = Inovasi::findOrFail($request->id);

            $inovasi->status = $request->status;
            $inovasi->keterangan = $request->keterangan ?? $inovasi->keterangan;
            $inovasi->save();

            // update indikator inovasi bobot awal and bobot akhir
            foreach ($request->indikator_data as $data) {
                return($data);
                DB::table('indikator_inovasi')
                    ->where('kab_inovasi_id', $request->id)
                    ->where('kab_indikator_id', $data['indikator_id'])  
                    ->update([
                        'bobot_akhir' => $data['bobot_akhir'],  
                        'param_akhir' => $data['param_akhir'],  
                    ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Status and keterangan updated successfully!',
            ], 200);
        // } catch (\Exception $e) {
        //     // Rollback transaction on error
        //     DB::rollBack();

        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Failed to update status and keterangan.',
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }
    }
    

}