<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use Helper;
use App\Models\Bentuk;
use App\Models\Faq;
use App\Models\Golongan;
use App\Models\Indikator;
use App\Models\Inisiator;
use App\Models\Inovasi;
use App\Models\Jabatan;
use App\Models\Jenis;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Opd;
use App\Models\Parameter;
use App\Models\Pengumuman;
use App\Models\Provinsi;
use App\Models\Tahapan;
use App\Models\Upload;
use App\Models\Urusan;
use App\Models\User;
use App\Exports\CompileInovasiExport;
use App\Models\KategoriInovasi;
use App\Models\KategoriOpd;
use App\Models\KategoriTahapan;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.index');
    }
    public function home()
	{ 
        $rata_isi = 0;
        $rata_isi_kota = 0;
        $rata_isi_kab = 0;
        $isp = 0;

        $jml_inovasi_kota = 0;
        $jml_inovasi_kab = 0;
        $inovasi = Inovasi::where('status', 2)->get();
        foreach ($inovasi as $item) {
            $rata_isi += $item->indikator->sum('pivot.bobot_akhir');
            if(strpos(" " . @$item->kota->name,"KOTA") == 1) {
                $jml_inovasi_kota ++;
                $rata_isi_kota += $item->indikator->sum('pivot.bobot_akhir');
            }
            if(strpos(" " . @$item->kota->name,"KABUPATEN") == 1) {
                $jml_inovasi_kab ++;
                $rata_isi_kab += $item->indikator->sum('pivot.bobot_akhir');
            } 
        }  
        if(sizeof($inovasi) > 0){
            $rata_isi = $rata_isi / sizeof($inovasi); 
        } 
        if($jml_inovasi_kota > 0){ 
            $rata_isi_kota = $rata_isi_kota / $jml_inovasi_kota; 
        } 
        if($jml_inovasi_kab > 0){ 
            $rata_isi_kab = $rata_isi_kab / $jml_inovasi_kab; 
        }  

        $indikator_provinsi = Indikator::where('label', 1)->get();
        foreach ($indikator_provinsi as $item) {
            $isp += $item->param->sum('bobot'); 
        } 

        $skor_total = $isp + $rata_isi;
        $rata_total = ($skor_total / 250) * 100;

        $skor_kota = $isp + $rata_isi_kota;
        $rata_kota = ($skor_kota / 250) * 100;

        $skor_kab = $isp + $rata_isi_kab;
        $rata_kab = ($skor_kab / 250) * 100;

        $total_opd_melapor = Inovasi::join('users as u', 'u.id', '=', 'inovasis.user_id')
                        ->select('u.opd_id')
                        ->distinct()
                        ->count(); 
        
        if (Auth::user()->role == 3) {
            $tahapan = Tahapan::all();
            $pengumuman = Pengumuman::orderBy('created_at', 'desc')->get();
            $iid = [];
            $data_daerah = [];
            $total_inovasi = 0;
            $isp = Auth::user()->provinsi->indikator->sum('pivot.bobot_akhir');
            $max = ['nama' => '', 'skor' => 0];
            $min = ['nama' => '', 'skor' => 0];
            $counter = 0;
            foreach (Auth::user()->provinsi->kota as $kota) {
                $total_inovasi += $kota->inovasi()->where('status', '<>', 0)->count();

                $isi = 0;
                $inovasi = Inovasi::where('kota_id', $kota->id)->where('status', 2)->get();
                if (count($inovasi) > 0) {
                    $total_kematangan = 0.0;
                    foreach ($inovasi as $item) {
                        $total_kematangan += $item->indikator->sum('pivot.bobot_akhir');
                    }
                    $isi = $total_kematangan / count($inovasi);
                }
                $skor_total = $isi + $isp;
                $skor_iid = ($skor_total / 250) * 100;
                $iid[$kota->id] = ['nama' => $kota->name,'iid' => $skor_iid];
                if ($skor_iid > $max['skor']) {
                    $max['skor'] = $skor_iid;
                    $max['nama'] = $kota->name;
                }
                if ($counter == 0) {
                    $min['skor'] = $skor_iid;
                    $min['nama'] = $kota->name;
                } else {
                    if ($skor_iid < $min['skor']) {
                        $min['skor'] = $skor_iid;
                        $min['nama'] = $kota->name;
                    }
                }

                $video = 0;
                $all_inovasi = Inovasi::where('kota_id', $kota->id)->where('status', '<>', 0)->get();
                foreach ($all_inovasi as $item) {
                    $indikator_video = $item->indikator()->where('tipe_file', 'mp4')->get();
                    foreach ($indikator_video as $indikator) {
                        $video += $indikator->upload()->where('inovasi_id', $item->id)->count();
                    }
                }
                $data_daerah[$kota->id] = ['nama' => $kota->name, 'inovasi' => count($all_inovasi), 'video' => $video];
                $counter++;
            } 

            return view('welcome', compact('total_opd_melapor', 'rata_isi', 'rata_total', 'rata_kab', 'rata_kota', 'tahapan', 'iid', 'data_daerah', 'total_inovasi', 'max', 'min', 'pengumuman'));
        } elseif (Auth::user()->role == 1) {
            $count_opd = Opd::count();
            $count_user = User::count();
            return view('welcome', compact('total_opd_melapor', 'rata_isi', 'rata_total', 'rata_kab', 'rata_kota', 'count_opd', 'count_user'));
        } else {
            $arrayCount = [];
            for ($i=0; $i <= 1 ; $i++) {
                for ($j=1; $j <= 4 ; $j++) {
                    $arrayCount[$i][$j] = Inovasi::where('status', $j)->where('label', $i)->count();
                }
            }
            return view('welcome', compact('total_opd_melapor', 'rata_isi', 'rata_total', 'rata_kab', 'rata_kota', 'arrayCount'));
        }

	}

    public function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
    
        array_multisort($sort_col, $dir, $arr);
    }

	public function modal(Request $request)
	{
		switch ($request->type) {
            case "tahapan":
                $data = ($request->id == 0) ? null : Tahapan::findOrFail($request->id);
				$urutan = Tahapan::max('urutan');
				$urutan++;
                return response()->json(array(
                    'msg' => view('modal.form-tahapan', compact('data', 'urutan'))->render()
                ), 200);
                break;
            case "kategori_tahapan":
                $data = ($request->id == 0) ? null : KategoriTahapan::findOrFail($request->id);
                $kategori = KategoriInovasi::all();
                $tahapan = Tahapan::all();
                return response()->json(array(
                    'msg' => view('modal.form-kategori_tahapan', compact('data', 'kategori','tahapan'))->render()
                ), 200);
                break;
            case "kategori_opd":
                $data = ($request->id == 0) ? null : KategoriOpd::findOrFail($request->id);
                $kategori = KategoriInovasi::all();
                $opd = Opd::all();
                return response()->json(array(
                    'msg' => view('modal.form-kategori_opd', compact('data', 'kategori','opd'))->render()
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
			case "pengguna":
				$data = ($request->id == 0) ? null : User::findOrFail($request->id);
				$jabatan = Jabatan::all();
				$golongan = Golongan::all();
				return response()->json(array(
					'msg' => view('modal.form-pengguna', compact('data', 'jabatan', 'golongan'))->render()
				), 200);
				break;
			case "inovasi_status":
				$data = Inovasi::findOrFail($request->id);
				return response()->json(array(
					'msg' => view('modal.form-status-inovasi', compact('data'))->render()
				), 200);
				break;
			case "upload":
				$data = Upload::findOrFail($request->id);
				$id = $data->inovasi_id != null ? $data->inovasi_id : $data->provinsi_id;
				$indikator_id = $data->indikator_id;
				$indikator = Indikator::findOrFail($indikator_id);
				$kolom = Helper::generateKolomUpload($indikator);
                $type = $data->label;
				return response()->json(array(
					'msg' => view('modal.form-upload', compact('id', 'indikator_id', 'kolom', 'data', 'type'))->render()
				), 200);
				break;
            case "pengumuman":
                $data = ($request->id == 0) ? null : Pengumuman::findOrFail($request->id);
                return response()->json(array(
                    'msg' => view('modal.form-pengumuman', compact('data'))->render()
                ), 200);
                break;
            case "pengumuman-preview":
                $data = Pengumuman::findOrFail($request->id);
                return response()->json(array(
                    'msg' => view('modal.pengumuman-preview', compact('data'))->render()
                ), 200);
                break;
            case "bobot-provinsi":
                $data = Pengumuman::findOrFail($request->id);
                return response()->json(array(
                    'msg' => view('modal.pengumuman-preview', compact('data'))->render()
                ), 200);
                break;
            case "kategori":
				$data = ($request->id == 0) ? null : KategoriInovasi::findOrFail($request->id);
                return response()->json(array(
					'msg' => view('modal.form-kategori', compact('data'))->render()
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

    public function export(Request $request, $type)
    {
        $kolom = Tahapan::where('tampilkan_kolom', 1)->get();
        if ($type == 0) {
            $data = Auth::user()->provinsi->inovasi()->get();
            return Excel::download(new CompileInovasiExport($data, $kolom), 'inovasi-provinsi-'.Auth::user()->province_id.'-'.uniqid().'.xlsx');
        } else {
            $data = Kota::findOrFail($type)->inovasi()->get();
            return Excel::download(new CompileInovasiExport($data, $kolom), 'inovasi-kota-kabupaten-'.$type.'-'.uniqid().'.xlsx');
        }
    }
    
    public function get_all_opd(Request $request)
    {
        $client = new Client();
        $username = 'superadmin';
        $password = 'superadmin';
        // Authenticate against the login endpoint
        $response = $client->post('http://jatim-inovasi.prototypetim.com/api/login', [
            'json' => [
                'username' => $username,
                'password' => $password
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        // Extract the token from the response
        $token = $data['authorisation']['token'];


 
        $respon = $client->get('http://jatim-inovasi.prototypetim.com/api/all_opd', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);
    
        $respon_opd = json_decode($respon->getBody(), true);
    
        return response()->json($respon_opd);
    }

    public function get_opd_client()
    {
        $client = new \GuzzleHttp\Client(); 
    try {
        $response = $client->request('POST', 'http://jatim-inovasi.prototypetim.com/api/login', [
            'headers' => [
                'Content-Type' => 'application/json'
            ], 
            'body' => json_encode([
                'username' => 'superadmin',
                'password' => 'superadmin',
            ])
        ]);
        
        $respon = json_decode($response->getBody()->getContents(), true);
        return $respon;
        } catch (RequestException $e) {
            // Handle specific request exceptions
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                echo $response->getStatusCode(); // HTTP status code
                echo $response->getBody();       // Response body
            } else {
                echo $e->getMessage(); // No response received
            }
        } catch (\Throwable $th) {
            // Catch any other exceptions
            return $th;
        }
    }

    public function insert_user_opd($kota){
        if($kota == 'bangkalan'){
            $opd = Opd::where('kabkota_id',3526)->get();
            foreach($opd as $r){
                if($r->kode_opd != NULL || !empty($r->kode_opd)){
                    $users = User::where('username',$r->kode_opd)->first();
                    if($users == NULL){
                        $user = new User();
                        $user->name = $r->nama;
                        $user->username = $r->kode_opd;
                        $user->opd_id = $r->id;
                        $user->role = 5;
                        $user->regency_id = 3526;
                        $user->password = bcrypt($r->kode_opd);
                        $user->save();
                    }
                }
                // dd($user);
                }
        }
    }

    public function insert_all_opd_kategori()
    {
        $kategori = KategoriInovasi::all();
        $opd = Opd::all();
        foreach($kategori as $item)
        {
            foreach($opd as $data)
            {
                $kategori_opd = new KategoriOpd();
                $kategori_opd->opd_id = $data->id;
                $kategori_opd->kategori_id = $item->id;
                $kategori_opd->save();
            }
        }
    }

    
}