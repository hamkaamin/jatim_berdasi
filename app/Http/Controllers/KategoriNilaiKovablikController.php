<?php

namespace App\Http\Controllers;

use App\Models\KategoriNilaiKovablik;
use App\Models\TahapanKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class KategoriNilaiKovablikController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->q);

        $data_tahapan = TahapanKovablik::orderBy('id', 'asc')->get();

        $nilaiPerTahapan = [];
        foreach ($data_tahapan as $th) {
            $nilaiPerTahapan[$th->id] = KategoriNilaiKovablik::where('tahapan_id', $th->id)
                ->when($q !== '', function ($x) use ($q) {
                    $x->where(function ($w) use ($q) {
                        $w->where('bagian', 'ilike', "%{$q}%")
                          ->orWhere('indikator', 'ilike', "%{$q}%");
                    });
                })
                ->orderBy('bagian', 'asc')->orderBy('id', 'asc')
                ->paginate(15, ['*'], 'page_' . $th->id)
                ->withQueryString();
        }

        return view('master.kategori_nilai_kovablik', compact('data_tahapan', 'nilaiPerTahapan', 'q'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriNilaiKovablik();
        } else {
            $data = KategoriNilaiKovablik::findOrFail($request->id);
        }

        $bobot_dipakai = KategoriNilaiKovablik::where('tahapan_id', $request->tahapan_id)
            ->when($request->id != 0, function ($q) use ($request) {
                return $q->where('id', '!=', $request->id);
            })
            ->sum('bobot_nilai');
        if ($bobot_dipakai + (int) $request->bobot_nilai > 100) {
            return redirect()->back()->with('error', 'Total bobot nilai untuk tahapan ini melebihi 100%. Sisa kuota: ' . (100 - $bobot_dipakai) . '%');
        }

        $data->bagian = $request->bagian;
        $data->indikator = $_POST['indikator'];
        $data->nilai_min = $request->nilai_min;
        $data->nilai_max = $request->nilai_max;
        $data->bobot_nilai = $request->bobot_nilai;
        $data->tahapan_id = $request->tahapan_id;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriNilaiKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }
}
