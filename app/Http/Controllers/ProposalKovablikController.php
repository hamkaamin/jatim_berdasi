<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Fase;
use App\Models\KategoriKovablik;
use App\Models\ProposalKovablik;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProposalKovablik  $proposalKovablik
     * @return \Illuminate\Http\Response
     */
    public function show(ProposalKovablik $proposalKovablik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProposalKovablik  $proposalKovablik
     * @return \Illuminate\Http\Response
     */
    public function edit(ProposalKovablik $proposalKovablik)
    {
        //
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
