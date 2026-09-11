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

        $treePerTahapan = [];
        foreach ($data_tahapan as $th) {
            $flat = KategoriNilaiKovablik::where('tahapan_id', $th->id)->orderBy('id', 'asc')->get();
            $treePerTahapan[$th->id] = \Helper::buildAspekTree($flat, $q);
        }

        return view('master.kategori_nilai_kovablik', compact('data_tahapan', 'treePerTahapan', 'q'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $data = new KategoriNilaiKovablik();
        } else {
            $data = KategoriNilaiKovablik::findOrFail($request->id);
        }

        if ($request->nilai_min > $request->nilai_max) {
            return redirect()->back()->with('error', 'Nilai minimal harus lebih kecil atau sama dengan nilai maksimal');
        }

        // Induk hanya diambil dari request saat tambah anak; saat edit tetap mengikuti yang lama.
        $parentId = $request->id == 0 ? ($request->parent_id ?: null) : $data->parent_id;

        // Anak selalu mengikuti tahapan induknya.
        $tahapanId = $parentId
            ? optional(KategoriNilaiKovablik::find($parentId))->tahapan_id
            : ($request->id == 0 ? $request->tahapan_id : $data->tahapan_id);

        $bobot_dipakai = KategoriNilaiKovablik::when($parentId, function ($x) use ($parentId) {
                return $x->where('parent_id', $parentId);
            }, function ($x) use ($tahapanId) {
                return $x->whereNull('parent_id')->where('tahapan_id', $tahapanId);
            })
            ->when($request->id != 0, function ($q) use ($request) {
                return $q->where('id', '!=', $request->id);
            })
            ->sum('bobot_nilai');
        if ($bobot_dipakai + (int) $request->bobot_nilai > 100) {
            return redirect()->back()->with('error', 'Total bobot untuk kelompok aspek ini melebihi 100%. Sisa kuota: ' . (100 - $bobot_dipakai) . '%');
        }

        $data->parent_id = $parentId;
        $data->bagian = $request->bagian;
        $data->nilai_min = $request->nilai_min;
        $data->nilai_max = $request->nilai_max;
        $data->bobot_nilai = $request->bobot_nilai ?: 100;
        $data->tahapan_id = $tahapanId;
        $data->save();
        return redirect()->back()->with('success', Config::get('save_success'));
    }

    public function delete(Request $request)
    {
        $data = KategoriNilaiKovablik::findOrFail($request->id);
        $data->delete();
        return redirect()->back()->with('success', Config::get('delete_success'));
    }

    public function deleteAll(Request $request)
    {
        $jumlah = KategoriNilaiKovablik::where('tahapan_id', $request->tahapan_id)->count();
        KategoriNilaiKovablik::where('tahapan_id', $request->tahapan_id)->delete();
        return redirect()->back()->with('success', $jumlah . ' aspek penilaian berhasil dihapus');
    }
}
