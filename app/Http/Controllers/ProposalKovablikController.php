<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Fase;
use App\Models\KategoriKovablik;
use App\Models\KelompokKovablik;
use App\Models\ProposalKovablik;
use App\Models\Setting;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;

class ProposalKovablikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $area)
    {
        $proposal = ProposalKovablik::where('deleted_at', 0);
        $label = "";
        if ($area == 'daerah') {
            $proposal = ProposalKovablik::where('label', 0)->where('status', 0);
            $label = "IGA";
        } elseif ($area == 'masyarakat') {
            $proposal = ProposalKovablik::where('label', 1);
            $label = "Awards";
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        } elseif ($area == 'pemda') {
            $proposal = ProposalKovablik::where('label', 1);
            $label = "Pemda";
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        } elseif ($area == 'kota') {
            $label = "Kota / Kab";
            $proposal = ProposalKovablik::where('label', 1);
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        } elseif ($area == 'provinsi') {
            $proposal = ProposalKovablik::where('label', 0)->where('kategori_id', 1);
            $label = "Provinsi";
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        }
        if (Auth::user()->role == 4 || Auth::user()->role == 5) {
            $proposal = $proposal->where('user_id', Auth::user()->id);
        }
        if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
            $proposal = $proposal->where('provinsi_id', Auth::user()->province_id);
        } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
            // $proposal = $proposal->where('provinsi_id', Auth::user()->opd->provinsi_id);
        } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
            $proposal = $proposal->where('kota_id', Auth::user()->regency_id);
        } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
            // $proposal = $proposal->where('kota_id', Auth::user()->opd->kabkota_id);
        } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
            $proposal = $proposal->where('kecamatan_id', Auth::user()->opd->kecamatan_id);
        } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
            $proposal = $proposal->where('kelurahan_id', Auth::user()->opd->kelurahan_id);
        }
        $proposal = $proposal->where('tahun', Auth::user()->tahun)->get();
        // dd($proposal);
        // dd($proposal);
        // dd($proposal,$label,Auth::user()->tahun,Auth::user()->id);
        $kategori = KategoriKovablik::get();
        $setting = Setting::where('kode', 'tambah_inovasi')->first();
        $fase = Fase::where('active', 1)->first();
        return view('kovablik.index', compact('proposal', 'label', 'area', 'kategori', 'setting', 'fase'));
    }

    public function show_kovablik(Request $request)
    {
        $area = $request->area;
        // no area
        $label = "";
        if ($area == 'daerah') {
            $proposal = ProposalKovablik::where('label', 0)->where('status', '<>', 0);
            $label = "IGA";
        } elseif ($area == 'masyarakat') {
            $proposal = ProposalKovablik::where('label', 2);
            $label = "Awards";
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        } elseif ($area == 'pemda') {
            $proposal = ProposalKovablik::where('label', 1);
            $label = "Pemda";
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        } elseif ($area == 'kota') {
            $label = "Awards";
            $proposal = ProposalKovablik::where('label', 1);
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        } elseif ($area == 'provinsi') {
            $proposal = ProposalKovablik::where('label', 0)->where('kategori_id', 1);
            $label = "Provinsi";
            if (Auth::user()->role == 2) {
                $proposal = $proposal->where('status', '<>', 0);
            }
        }
        if (Auth::user()->role == 4 || Auth::user()->role == 5) {
            $proposal = $proposal->where('user_id', Auth::user()->id);
        }
        if (Auth::user()->role == 3 || Helper::checkUserUmum('provinsi', Auth::user())) {
            $proposal = $proposal->where('provinsi_id', Auth::user()->province_id);
        } elseif (Helper::checkOpd('provinsi', Auth::user()) || Helper::checkUserUmum('opd-provinsi', Auth::user())) {
            // $proposal = $proposal->where('provinsi_id', Auth::user()->opd->provinsi_id);
        } elseif (Auth::user()->role == 4 || Helper::checkUserUmum('kota', Auth::user())) {
            $proposal = $proposal->where('kota_id', Auth::user()->regency_id);
        } elseif (Helper::checkOpd('kota', Auth::user()) || Helper::checkUserUmum('opd-kota', Auth::user())) {
            // $proposal = $proposal->where('kota_id', Auth::user()->opd->kabkota_id);
        } elseif (Helper::checkOpd('kecamatan', Auth::user()) || Helper::checkUserUmum('opd-kecamatan', Auth::user())) {
            $proposal = $proposal->where('kecamatan_id', Auth::user()->opd->kecamatan_id);
        } elseif (Helper::checkOpd('kelurahan', Auth::user()) || Helper::checkUserUmum('opd-kelurahan', Auth::user())) {
            $proposal = $proposal->where('kelurahan_id', Auth::user()->opd->kelurahan_id);
        }
        $proposal = $proposal->where('tahun', Auth::user()->tahun)->get();
        // dd($proposal);
        // dd($proposal,$label,Auth::user()->tahun,Auth::user()->id);
        $kategori = KategoriKovablik::orderBy('id', 'asc')->get();
        $kelompok = KelompokKovablik::orderBy('id', 'asc')->get();
        $setting = Setting::where('kode', 'tambah_inovasi')->first();
        $fase = Fase::where('active', 1)->first();

        return view('kovablik.show_kovablik', compact('proposal', 'label', 'kategori', 'kelompok', 'fase'));
    }

    public function detail(Request $request)
    {
        $kategori = KategoriKovablik::all();
        $view = 'kovablik.detail-kovablik';
        $label = 0;

        if ($request->id != 0) {
            $id = decrypt($request->id);
            $data = ProposalKovablik::findOrFail($id);
            $label = $data->label;
        }

        if (isset($request->label)) {
            $label = $request->label;
        }
        // dd($data->kelompok->nama);
        return view($view, compact('data', 'kategori', 'label'));
    }

    public function save(Request $request)
    {
        $tempArr = [];
        $data = new ProposalKovablik;
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

        $max_kata = 10;
        $request->validate([
            'ringkasan' => 'required|string|max:200',
            'latar_belakang' => 'required|string|max:300',
            'nilai_tambah' => 'required|string|max:600',
            'implementasi' => 'required|string|max:200',
            'signifikansi' => 'required|string|max:600',
            'adaptabilitas' => 'required|string|max:300',
            'sumber_daya' => 'required|string|max:200',
            'strategi_keberlanjutan' => 'required|string|max:500',
        ]);

        $data->label = $request->label;
        $data->judul = $request->judul;
        $data->kelompok_id = $request->kelompok_id;
        $data->link_standart = $request->link_standart;
        $data->link_maklumat = $request->link_maklumat;
        $data->link_sk_pengaduan = $request->link_sk_pengaduan;
        $data->instansi = $request->instansi;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->nama_inovator = $request->nama_inovator;
        $data->no_telpon_inovator = $request->no_telpon_inovator;
        $data->email_inovator = $request->email_inovator;
        $data->kategori_id = $request->kategori_id;
        $data->ringkasan = $request->ringkasan;
        $data->latar_belakang = $request->latar_belakang;
        $data->nilai_tambah = $request->nilai_tambah;
        $data->implementasi = $request->implementasi;
        $data->signifikansi = $request->signifikansi;
        $data->adaptabilitas = $request->adaptabilitas;
        $data->sumber_daya = $request->sumber_daya;
        $data->strategi_keberlanjutan = $request->strategi_keberlanjutan;
        $data->tahun = Auth::user()->tahun;
        $data->status = 1;
        $data->save();

        $route = $request->label == 1 ? route('kovablik.index', ['area' => 'masyarakat']) : route('kovablik.index', ['area' => 'kota']);
        return redirect($route)->with('success', 'Data Inovasi berhasil di-submit dan masuk ke tahap <b>Proses</b> ! Harap menunggu pengumuman lebih lanjut. Terima kasih');
    }


    public function show(ProposalKovablik $proposalKovablik)
    {
        //
    }

    public function edit(Request $request)
    {
        $fase = Fase::where('active', 1)->first();
        $nama_fase = $fase->nama;

        if ($nama_fase == 'inotek') {
            $cek_label = 1;
            $nama_fase = 'INOTEK';
        } else if ($nama_fase == 'iga') {
            $cek_label = 0;
            $nama_fase = 'IGA';
        } else if ($nama_fase == 'kovablik') {
            $cek_label = 2;
            $nama_fase = 'KOVABLIK';
        }

        if ($cek_label != $request->label) {
            return redirect()->route('kovablik.index')->with('error', 'Fase ' . $nama_fase . ' Sedang Ditutup');
        }
        if (count($request->input()) <= 3 && isset($request->id)) {
            $data = null;
            $kelompok = KelompokKovablik::all();
            $kategori = KategoriKovablik::orderBy('id', 'asc')->get();
            if (Auth::user()->role == 4 || Auth::user()->role == 5 || Auth::user()->role == 7) {
                $kategori = KategoriKovablik::orderBy('id', 'asc')->get();
            } else {
                if ($request->id != 0) {
                    $proposal = ProposalKovablik::find(decrypt($request->id));
                    $kategori = KategoriKovablik::orderBy('id', 'asc')->get();
                }
            }
            $label = 0;

            // $kategori = $kategori->get();
            if ($request->id != 0) {
                $id = decrypt($request->id);
                $data = ProposalKovablik::findOrFail($id);
                if ($data->user_id != Auth::user()->id) {
                    return redirect()->back()->with('error', 'Forbidden Authentication !')->withInput($request->input());
                }
                $label = $data->label;
            }

            if (isset($request->label)) {
                $label = $request->label;
            }
            if ($label == 0) {
                $kategori = KategoriKovablik::where('id', 1)->orderBy('id', 'asc')->get();
            }
            $fase = Fase::where('active', 1)->first();

            return view('kovablik.form-kovablik', compact('data', 'kelompok', 'kategori', 'label', 'fase'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProposalKovablik  $proposalKovablik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProposalKovablik $proposalKovablik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProposalKovablik  $proposalKovablik
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProposalKovablik $proposalKovablik)
    {
        //
    }
}
