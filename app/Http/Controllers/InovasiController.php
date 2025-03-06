<?php

namespace App\Http\Controllers;

use Config;
use Excel;
use Helper;
use PDF;
use App\Models\Bentuk;
use App\Models\Indikator;
use App\Models\Inisiator;
use App\Models\Inovasi;
use App\Models\Jenis;
use App\Models\Tahapan;
use App\Models\Upload;
use App\Models\Urusan;
use App\Exports\InovasiExport;
use App\Models\DetailTematik;
use App\Models\Fase;
use App\Models\KategoriInovasi;
use App\Models\KategoriOpd;
use App\Models\KategoriTahapan;
use App\Models\Setting;
use App\Models\Tematik;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class InovasiController extends Controller
{
    public function index(Request $request, $area)
    {
        $tahapan = Tahapan::all();
        $inovasi = Inovasi::where('deleted_at', 0);
        $label = "";
        $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
        if ($area == 'daerah') {
            $inovasi = Inovasi::where('label', 0)->where('status', 0);
            $label = "IGA";
        } elseif ($area == 'masyarakat') {
            $inovasi = Inovasi::where('label', 1);
            $label = "Awards";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            } 
        } elseif ($area == 'pemda') {
            $inovasi = Inovasi::where('label', 1);
            $label = "Pemda";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            }
        } elseif($area == 'kota'){
            $label = "Kota / Kab";
            $tahapan = Tahapan::where('id','<>',6)->get();
            $inovasi = Inovasi::where('label', 1);
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            }
        }
        elseif($area == 'provinsi'){
            $inovasi = Inovasi::where('label', 0)->where('kategori_id',1);
            $tahapan = Tahapan::where('id','<>',6)->get();
            $label = "Provinsi";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            }
        }
        if (Auth::user()->role == 4 || Auth::user()->role == 5) {
            $inovasi = $inovasi->where('user_id', Auth::user()->id);
        }
        if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
            $inovasi = $inovasi->where('provinsi_id', Auth::user()->province_id);
        } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
            // $inovasi = $inovasi->where('provinsi_id', Auth::user()->opd->provinsi_id);
        } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
            $inovasi = $inovasi->where('kota_id', Auth::user()->regency_id);
        } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
            // $inovasi = $inovasi->where('kota_id', Auth::user()->opd->kabkota_id);
        } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
            $inovasi = $inovasi->where('kecamatan_id', Auth::user()->opd->kecamatan_id);
        } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
            $inovasi = $inovasi->where('kelurahan_id', Auth::user()->opd->kelurahan_id);
        }
        $inovasi = $inovasi->where('tahun',Auth::user()->tahun)->get();
        // dd($inovasi);
        // dd($inovasi);
        // dd($inovasi,$label,Auth::user()->tahun,Auth::user()->id);
        $kategori = KategoriInovasi::get();
        $setting = Setting::where('kode','tambah_inovasi')->first();
        $fase = Fase::where('active', 1)->first();
        // dd($tahapan, $tahapanKolom);
        return view('inovasi.index', compact('tahapan', 'tahapanKolom', 'inovasi', 'label','area','kategori','setting','fase'));
    }

    public function show_tahapan(Request $request)
    {
        $data = KategoriTahapan::where('kategori_id',$request->kategori_id)->get();
        $str='';
        $str .= '<option value=""> -- Tampilkan Semua --  </option>';
        foreach($data as $item){
           $str .= '<option value="'.$item->tahapan->id.'"> '.$item->tahapan->nama.''.'</option>';
        }
        return $str;
        // return view('inovasi.show_tahapan',compact($data));
    }

    public function show_inovasi(Request $request){
        $area = $request->area;
        $tahapan = Tahapan::all();
        $inovasi = Inovasi::where('deleted_at', 0);
        $label = "";
        $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
        if ($area == 'daerah') {
            $inovasi = Inovasi::where('label', 0)->where('status','<>' ,0);
            $label = "IGA";
        } elseif ($area == 'masyarakat') {
            $inovasi = Inovasi::where('label', 1);
            $label = "Awards";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            } 
        } elseif ($area == 'pemda') {
            $inovasi = Inovasi::where('label', 1);
            $label = "Pemda";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            }
        } elseif($area == 'kota'){
            $label = "Awards";
            $tahapan = Tahapan::where('id','<>',6)->get();
            $inovasi = Inovasi::where('label', 1);
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            }
        }
        elseif($area == 'provinsi'){
            $inovasi = Inovasi::where('label', 0)->where('kategori_id',1);
            $tahapan = Tahapan::where('id','<>',6)->get();
            $label = "Provinsi";
            if (Auth::user()->role == 2) {
                $inovasi = $inovasi->where('status', '<>', 0);
            }
        }
        if (Auth::user()->role == 4 || Auth::user()->role == 5) {
            $inovasi = $inovasi->where('user_id', Auth::user()->id);
        }
        if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
            $inovasi = $inovasi->where('provinsi_id', Auth::user()->province_id);
        } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
            // $inovasi = $inovasi->where('provinsi_id', Auth::user()->opd->provinsi_id);
        } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
            $inovasi = $inovasi->where('kota_id', Auth::user()->regency_id);
        } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
            // $inovasi = $inovasi->where('kota_id', Auth::user()->opd->kabkota_id);
        } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
            $inovasi = $inovasi->where('kecamatan_id', Auth::user()->opd->kecamatan_id);
        } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
            $inovasi = $inovasi->where('kelurahan_id', Auth::user()->opd->kelurahan_id);
        }
        $inovasi = $inovasi->where('tahun',Auth::user()->tahun)->get();
        // dd($inovasi);
        // dd($inovasi);
        // dd($inovasi,$label,Auth::user()->tahun,Auth::user()->id);
        $kategori = KategoriInovasi::orderBy('id','asc')->get();
        $setting = Setting::where('kode','tambah_inovasi')->first();
        $fase = Fase::where('active', 1)->first();
        return view('inovasi.show_inovasi', compact('tahapan', 'tahapanKolom', 'inovasi', 'label','kategori','fase'));
    }

    public function bank_data(Request $request,$area)
    {
        $inovasi = Inovasi::with('kategori')->where('status',2)->where('tahun',Auth::user()->tahun)->get();
        return view('inovasi.bank_data', compact('inovasi','area'));
    }

    public function edit(Request $request)
    { 
        $fase = Fase::where('active',1)->first();
        $nama_fase = $fase->nama;
        if($nama_fase == 'inotek'){
            $cek_label = 1;
            $nama_fase = 'INOTEK';
        }else if($nama_fase == 'iga'){
            $cek_label = 0;
            $nama_fase = 'IGA';
        }
        if($cek_label != $request->label){
            return redirect()->route('inovasi.index')->with('error','Fase '.$nama_fase.' Sedang Ditutup');
        }
        if (count($request->input()) <= 3 && isset($request->id)) {
            $data = null;
            $tahapan = Tahapan::all();
            $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
            $inisiator = Inisiator::all();
            $jenis = Jenis::all();
            $bentuk = Bentuk::all();
            $urusan = Urusan::all();
            $tematik = Tematik::all();
            $kategori = KategoriInovasi::orderBy('id','asc')->get();
            if(Auth::user()->role == 4 || Auth::user()->role == 5 || Auth::user()->role == 7 ){
                $kategori = KategoriInovasi::orderBy('id','asc')->get();
            }else{
                if ($request->id != 0) {
                    $inovasi = Inovasi::find(decrypt($request->id));
                    $kategori = KategoriInovasi::orderBy('id','asc')->get();

                }
            }
            $label = 0;
            
            // $kategori = $kategori->get();
            if ($request->id != 0) {
                $id = decrypt($request->id);
                $data = Inovasi::findOrFail($id);
                if($data->user_id != Auth::user()->id){
                    return redirect()->back()->with('error', 'Forbidden Authentication !')->withInput($request->input());
                }
                $label = $data->label;
            }

            if (isset($request->label)) {
                $label = $request->label;
            }
            if($label == 0){
                $kategori =KategoriInovasi::where('id',1)->orderBy('id','asc')->get();
            }
            $fase = Fase::where('active', 1)->first();

            return view('inovasi.form-inovasi', compact('data','kategori', 'tahapan', 'inisiator', 'jenis', 'bentuk', 'urusan', 'tahapanKolom', 'label','tematik','fase'));
        } else { 
            return redirect()->back();
        }
    }

    public function detail(Request $request)
    {
        $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
            $inisiator = Inisiator::all();
            $jenis = Jenis::all();
            $bentuk = Bentuk::all();
            $urusan = Urusan::all();
            $tematik = Tematik::all();
            $kategori = KategoriInovasi::all();
            $view = 'inovasi.detail-inovasi';
            if(Auth::user()->role == 4 || Auth::user()->role == 5 || Auth::user()->role == 7 ){
                $kategori = KategoriOpd::where('opd_id',Auth::user()->opd_id)->where('is_aktif',1);
            }else{
                if ($request->id != 0) {
                    $inovasi = Inovasi::find(decrypt($request->id));
                    $kategori = KategoriOpd::where('opd_id',$inovasi->user->opd_id)->where('is_aktif',1);
                }
            }
            $label = 0;
            
            $kategori = $kategori->get();
            if ($request->id != 0) {
                $id = decrypt($request->id);
                $data = Inovasi::findOrFail($id);
                $label = $data->label;
                if($data->kategori_id == 5){
                    $view = 'inovasi.detail-inovasi-kategori-5';
                }
            }

            if (isset($request->label)) {
                $label = $request->label;
            }
            if($label == 0){
                $kategori = $kategori->where('kategori_id',1);
            }
            return view($view, compact('data','kategori', 'inisiator', 'jenis', 'bentuk', 'urusan', 'tahapanKolom', 'label','tematik'));
    }

    public function limit_words($string, $word_limit) {
        $string = strip_tags($string);
        $words = explode(' ', strip_tags($string));
        $return = trim(implode(' ', array_slice($words, 0, $word_limit)));
        if(strlen($return) < strlen($string)){
            $return = 'Maximal 300 kata';
        }
        return $return;
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'file_rancang_bangun' => 'mimes:pdf,docx,doc,jpg,jpeg,png,xlsx|max:2048', 
            'profil_bisnis' => 'mimes:pdf,doc,jpg,jpeg,png,xlsx|max:2048', 
            'anggaran' => 'mimes:pdf,doc,jpg,jpeg,png,xlsx|max:2048', 
        ], [  
            'file_rancang_bangun.mimes' => 'File harus pdf / doc / jpg / jpeg / png / xlsx',
            'file_rancang_bangun.max' => 'File maksimal berukuran 2MB', 
            'profil_bisnis.mimes' => 'File harus pdf / doc / jpg / jpeg / png / xlsx',
            'profil_bisnis.max' => 'File maksimal berukuran 2MB', 
            'anggaran.mimes' => 'File harus pdf / doc / jpg / jpeg / png / xlsx',
            'anggaran.max' => 'File maksimal berukuran 2MB', 
        ]);
        if ($validator->fails()) {
            $msg = "";
            foreach ($validator->messages()->all() as $message) {
                $msg .= $message . ". ";
            }
            return redirect()->back()->with('error', $msg)->withInput($request->input());

        } else {
            $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
            $tempArr = [];
            if ($request->id == 0) {
                $data = new Inovasi;
                $data->user_id = Auth::user()->id;
                $data->kode = uniqid();
                if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
                    $data->provinsi_id = Auth::user()->province_id;
                } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
                    $data->provinsi_id = Auth::user()->opd->provinsi_id;
                } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
                    $data->provinsi_id = Auth::user()->kota->provinsi->id;
                    $data->kota_id = Auth::user()->regency_id;
                } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
                    $data->provinsi_id = Auth::user()->opd->kota->provinsi->id;
                    $data->kota_id = Auth::user()->opd->kabkota_id;
                } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
                    $data->provinsi_id = Auth::user()->opd->kecamatan->kota->provinsi->id;
                    $data->kota_id = Auth::user()->opd->kecamatan->kota->id;
                    $data->kecamatan_id = Auth::user()->opd->kecamatan_id;
                } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
                    $data->provinsi_id = Auth::user()->opd->kelurahan->kecamatan->kota->provinsi->id;
                    $data->kota_id = Auth::user()->opd->kelurahan->kecamatan->kota->id;
                    $data->kecamatan_id = Auth::user()->opd->kelurahan->kecamatan->id;
                    $data->kelurahan_id = Auth::user()->opd->kelurahan_id;
                }
            } else {
                $data = Inovasi::findOrFail($request->id);
                $temp = [];
                if ($request->status == 1) {
                    if ($data->nama == null) {
                        $temp[] = "Lengkapi data Nama Inovasi terlebih dahulu !";
                    }
                    if ($data->bentuk_id == null) {
                        $temp[] = "Lengkapi data Bentuk Inovasi terlebih dahulu !";
                    }
                    if ($data->indikator()->count() <= 0 || $data->indikator()->where('wajib', 1)->wherePivot('bobot_awal', null)->count() > 0) {
                        $temp[] = "Lengkapi data parameter dan bobot tiap INDIKATOR terlebih dahulu !";
                    } else {
                        foreach ($data->indikator()->where('wajib', 1)->get() as $indikator) {
                            $upload = Upload::where('indikator_id', $indikator->id)->where('inovasi_id', $data->id)->count();
                            if ($upload <= 0) {
                                $temp[] = "Upload file pendukung untuk Indikator ".$indikator->nama." terlebih dahulu !";
                            }
                        }
                    }
                    if (count($temp) > 0) {
                        $msg = "<ul>";
                        foreach ($temp as $item) {
                            $msg .= "<li>".$item."</li>";
                        }
                        $msg .= "</ul>";
                        return redirect()->back()->with('error', $msg);
                    } else {
                        $data->status = $request->status;
                        $data->save();
                        $route = $request->label == 1 ? route('inovasi.index', ['area' => 'masyarakat']) : route('inovasi.index', ['area' => 'kota']);
                        return redirect($route)->with('success', 'Data Inovasi berhasil di-submit dan masuk ke tahap <b>Proses</b> ! Harap menunggu pengumuman lebih lanjut. Terima kasih');
                    }
                }
            }
            $max_kata = 10;
            $rancang_bangun = $request->rancang_bangun;  
            $string = strip_tags($rancang_bangun);
            $words = explode(' ', strip_tags($rancang_bangun));
            $return = trim(implode(' ', array_slice($words, 0, 10)));
            $kata = count($words);
            if($kata < $max_kata){
                return redirect()->back()->with('error', 'Minimal Data Rancang Bangun 300 kata');
            }

            $data->nama = $request->nama;
            $data->tahapan_id = $request->kategori_id == 5 ? 6 : $request->tahapan_id;
            $data->kategori_id = $request->kategori_id;
            $data->inisiator_id = $request->inisiator_id;
            $data->jenis_id = $request->jenis_id;
            $data->bentuk_id = $request->bentuk_id;
            $data->tematik_id = $request->tematik_id;
            $data->detail_tematik_id = $request->detail_tematik_id;
            $data->nama_inisiator = $request->nama_inisiator;
            $data->covid = $request->covid;
            $data->rancang_bangun = $request->rancang_bangun;
            $data->tujuan = $request->tujuan;
            $data->manfaat = $request->manfaat;
            $data->hasil = $request->hasil;
            $data->status = $request->status;
            $data->label = $request->label;
            $data->waktu_uji_coba = $request->waktu_uji_coba;
            $data->waktu_penerapan = $request->waktu_penerapan;
            $data->waktu_pengembangan = $request->waktu_pengembangan;
            $data->visi = @$request->visi;
            $data->misi = @$request->misi;
            $data->tahun = Auth::user()->tahun;
            $data->url = env('APP_URL');
            $data->save();
            $data->urusan()->sync($request->urusan_id);
            foreach ($tahapanKolom as $item) {
                $tempArr[$item->id] = ['waktu' => $request->{'waktu_tahapan_'.$item->id}];
            }
            $data->tahapan()->sync($tempArr);
            if ($request->hasFile('anggaran')) {
                $nama_file = Helper::save_file($request->file('anggaran'), uniqid(), 'file_anggaran', $data->anggaran);
                $data->anggaran = $nama_file;
                $data->save();
            }
            if ($request->hasFile('file_rancang_bangun')) {
                $nama_file = Helper::save_file($request->file('file_rancang_bangun'), uniqid(), 'file_rancang_bangun', $data->file_rancang_bangun);
                $data->file_rancang_bangun = $nama_file;
                $data->save();
            } 

            if ($request->hasFile('file_anggaran')) {
                $nama_file = Helper::save_file($request->file('file_anggaran'), uniqid(), 'file_perlu_anggaran', $data->file_anggaran);
                $data->file_anggaran = $nama_file;
                $data->save();
            }
            
            if ($request->hasFile('file_dokumen_haki')) {
                $nama_file = Helper::save_file($request->file('file_dokumen_haki'), uniqid(), 'file_dokumen_haki', $data->file_dokumen_haki);
                $data->file_dokumen_haki = $nama_file;
                $data->save();
            }
            
            if ($request->hasFile('file_penghargaan')) {
                $nama_file = Helper::save_file($request->file('file_penghargaan'), uniqid(), 'file_penghargaan', $data->file_penghargaan);
                $data->file_penghargaan = $nama_file;
                $data->save();
            }

            if ($request->hasFile('profil_bisnis')) {
                $nama_file = Helper::save_file($request->file('profil_bisnis'), uniqid(), 'file_profil_bisnis', $data->profil_bisnis);
                $data->profil_bisnis = $nama_file;
                $data->save();
            }

            if ($request->hasFile('file_hasil_inovasi')) {
                $nama_file = Helper::save_file($request->file('file_hasil_inovasi'), uniqid(), 'file_hasil_inovasi', $data->file_hasil_inovasi);
                $data->file_hasil_inovasi = $nama_file;
                $data->save();
            }

            if ($request->hasFile('file_kajian')) {
                $nama_file = Helper::save_file($request->file('file_kajian'), uniqid(), 'file_kajian', $data->file_kajian);
                $data->file_kajian = $nama_file;
                $data->save();
            }

            if ($request->hasFile('file_struktur_oragnisasi')) {
                $nama_file = Helper::save_file($request->file('file_struktur_oragnisasi'), uniqid(), 'file_struktur_oragnisasi', $data->file_struktur_oragnisasi);
                $data->file_struktur_oragnisasi = $nama_file;
                $data->save();
            }
            $route = $request->label == 1 ? route('inovasi.index', ['area' => 'masyarakat']) : route('inovasi.index', ['area' => 'kota']);
            return redirect($route)->with('success', Config::get('save_success').'. Mohon melengkapi data-data indikator agar Inovasi dapat diproses !');
        }
    }

    public function update(Request $request)
    {
        
        $client = new Client([
            'verify' => false, // Disable SSL verification
        ]);
        $inovasi = Inovasi::findOrFail($request->id);
        $inovasi->status = $request->status;
        $inovasi->keterangan = $request->keterangan;
        $inovasi->save();
        if($inovasi->kab_integration_id != null || !empty($inovasi->kab_integration_id)){
            // try {
                $indikatorData = [];

                // Loop through each indikator and collect the necessary data
                $indikator_inovasi = DB::table('indikator_inovasi')->where('inovasi_id', $inovasi->id)->get();
                foreach ($indikator_inovasi as $data) {
                    $indikatorData[] = [
                        'indikator_id' => $data->indikator_id,
                        'bobot_akhir' => $data->bobot_akhir ?? NULL,  
                        'param_akhir' => $data->param_akhir ?? NULL,  
                    ];
                }

                $response = $client->request('POST', $inovasi->integration->url.'api/kab_status_data_update', [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'form_params' => [  
                        'id' => $inovasi->kab_inovasis_id,
                        'status' => $request->status,
                        'keterangan' => $request->keterangan,
                        'indikator_data' => $indikatorData,
                    ], 
                    'verify' => false,
                ]);

                $responseData = json_decode($response->getBody()->getContents(), true);

                if ($responseData['status']) {
                    // Handle success
                    echo $responseData['message'];
                } else {
                    // Handle failure
                    echo 'Failed: ' . $responseData['message'];
                }
            // } catch (\Exception $e) {
            //     echo 'Error: ' . $e->getMessage();
            // }
        }
        return redirect()->back()->with('success', Config::get('save_success').'. Status Inovasi berhasil diperbarui !');
    }

    public function delete(Request $request)
    {
        $data = Inovasi::findOrFail($request->id);
        foreach ($data->upload()->get() as $item) {
            $item->delete();
        }
        if ($data->anggaran != null && file_exists(public_path('/file_anggaran/'.$data->anggaran))) {
            unlink(public_path('/file_anggaran/'.$data->anggaran));
        }
        if ($data->profil_bisnis != null && file_exists(public_path('/file_profil_bisnis/'.$data->profil_bisnis))) {
            unlink(public_path('/file_profil_bisnis/'.$data->profil_bisnis));
        }
        $data->delete();
        // return redirect()->back()->with('success', Config::get('delete_success'));
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function index_indikator(Request $request)
    {
        $area_label = $request->area;
        // if (count($request->input()) == 2 && isset($request->id)) {
            $inovasi = Inovasi::findOrFail($request->id);
            $data = [];
            if ($inovasi->indikator()->count() == 0) {
                $indikator = Indikator::where('label', 0)->where('kategori_id',$inovasi->kategori_id)->get();
                foreach ($indikator as $item) {
                    $inovasi->indikator()->attach($item->id,['kategori_id'=>$item->kategori_id]);
                }
            }
            $data = $inovasi->indikator()->get();
            $fase = Fase::where('active', 1)->first();

            return view('inovasi.indikator', compact('data', 'inovasi','area_label','fase'));
        // } else {
        //     return redirect()->back();
        // }
    }

    public function index_upload(Request $request)
    {  
        if (isset($request->indikator)) {
            $data = Upload::where('inovasi_id', $request->id)->where('indikator_id', $request->indikator)->get();
            $inovasi = Inovasi::findOrFail($request->id);
            $indikator = Indikator::findOrFail($request->indikator);
            $kolom = Helper::generateKolomUpload($indikator);
            return view('inovasi.upload', compact('data', 'kolom', 'inovasi'));
        } else {
            return redirect()->back();
        }
    }

    public function export(Request $request, $type)
    {
        $inovasi = Inovasi::findOrFail($request->id);
        $kolom = Tahapan::where('tampilkan_kolom', 1)->get();
        if ($type == 'excel') {
            return Excel::download(new InovasiExport($inovasi, $kolom), 'inovasi-'.$inovasi->kode.'.xlsx');
        } elseif ($type == 'pdf') {
           
            $pdf = PDF::loadview('export.inovasi-pdf',['inovasi' => $inovasi, 'kolom' => $kolom]);
            // return $pdf->stream();
    	    return $pdf->stream('inovasi-'.$inovasi->kode.'.pdf');
        }
    }

    public function sent(Request $request) {
        // Process the request, perform actions based on the data received
        // Example:
        $is_sent = $request->is_sent;
        if($is_sent == null){
            return redirect()->back()->with('error', 'Harap Pilih salah 1 Data yang disetujui');
        }
        foreach($is_sent as $id){
            $hit_data = 0;
            $data = Inovasi::find($id);
            $data->hit_data = 1;
            $data->status = 5;
            $data->save();
        }
        return redirect()->back()->with('success', 'Data Berhasil Dikirim ke Jatim Berdasi');
    }
        // Return a response
        // return response()->json(['message' => 'Data received successfully']);

    public function detail_tematik(Request $request)
    {
        $tematik_id = $request->tematik_id;
        $inovasi_id = $request->inovasi_id;
        # detail tematik using tematik_id
        $data = Inovasi::find($inovasi_id);
        $detail_tematik = DetailTematik::where('tematik_id', $tematik_id)->get();
        if($detail_tematik == NULL || empty($detail_tematik) || $detail_tematik->count() == 0){
            return 'failed';
        }
        # move data to the <select>
        return view('inovasi.detail_tematik', compact('detail_tematik','data'));
    }

    public function kategori_inovasi(Request $request)
    {
        $inovasi_id = $request->inovasi_id;
        $kategori_id = $request->kategori_id;
            $data = null;
            $tahapan = Tahapan::all();
            $tahapanKolom = Tahapan::where('tampilkan_kolom', 1)->get();
            $inisiator = Inisiator::all();
            $jenis = Jenis::all();
            $bentuk = $kategori_id == 1 ? Bentuk::all() : Bentuk::where('id',2)->get();
            $urusan = Urusan::all();
            $tematik = Tematik::all();
            $kategori = KategoriInovasi::all();
            if(Auth::user()->role == 4 || Auth::user()->role == 5 || Auth::user()->role == 7 ){
                $kategori = KategoriOpd::where('opd_id',Auth::user()->opd_id)->where('is_aktif',1);
            }else{
                if ($inovasi_id != 0) {
                    $inovasi = Inovasi::find(decrypt($inovasi_id));
                    $kategori = KategoriOpd::where('opd_id',$inovasi->user->opd_id)->where('is_aktif',1);
                }
            }
            $label = 0;
            
            $kategori = $kategori->get();
            if ($inovasi_id != 0) {
                $id = $inovasi_id;
                $data = Inovasi::findOrFail($id);
                if($data->user_id != Auth::user()->id){
                    return redirect()->back()->with('error', 'Forbidden Authentication !')->withInput($request->input());
                }
                $label = $data->label;
            }

            if (isset($request->label)) {
                $label = $request->label;
            }
            if($label == 0){
                $kategori = $kategori->where('kategori_id',1);
            }
            $fase = Fase::where('active', 1)->first();
            $view = 'inovasi.ajax_inovasi';
            if($kategori_id == 5){
                $view= 'inovasi.form.kategori_5';
            }

            return view($view, compact('data','kategori', 'tahapan', 'inisiator', 'jenis', 'bentuk', 'urusan', 'tahapanKolom', 'label','tematik','fase'));
        
    }
}