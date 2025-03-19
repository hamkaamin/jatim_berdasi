<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\KategoriKovablik;
use App\Models\KategoriNilaiKovablik;
use App\Models\PenilaianKovablikMap;
use App\Models\ProposalKovablik;
use App\Models\TahapanKovablik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PenilaianKovablikController extends Controller
{
    public function index()
    {
        $proposal = ProposalKovablik::where('status', 2)->get();
        $tahapan = TahapanKovablik::all();

        return view('penilaian-kovablik.index', compact('proposal', 'tahapan'));
    }

    public function edit(Request $request)
    {
        $id = decrypt($request->id);
        $proposal = ProposalKovablik::findOrFail($id);
        $juri = Juri::where('user_id', Auth::user()->id)->first();
        $data = [];
        if ($proposal->penilaian()->wherePivot('user_id', Auth::id())->count() == 0) {
            $penilaians = KategoriNilaiKovablik::all();
            foreach ($penilaians as $penilaian) {
                $proposal->penilaian()->attach($penilaian->id, [
                    'user_id' => Auth::id()
                ]);
            }
        }
        $data = $proposal->penilaian()->wherePivot('user_id', Auth::id())->get();
        $penilaian_map = PenilaianKovablikMap::where('proposal_id', $id)->where('juri_id', $juri->id)->where('tahapan_id', $proposal->tahapan_id)->first();
        return view('penilaian-kovablik.edit', compact('data', 'proposal', 'juri', 'penilaian_map'));
    }

    public function show(Request $request)
    {
        $jenis = $request->jenis;
        $id = decrypt($request->id);
        $inovasi = Inovasi::findOrFail($id);
        $kategori_juri = Juri::where('kategori_id', $inovasi->kategori_id)->pluck('user_id');
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->get();
        $data = $inovasi->penilaian()
            ->whereIn('user_id', $kategori_juri) // Filter berdasarkan kategori juri
            ->get();
        return view('penilaian.show', compact('kategori_juri', 'inovasi', 'data', 'jenis', 'penilaian_map'));
    }

    public function print($id)
    {
        $id = decrypt($id);
        $inovasi = Inovasi::findOrFail($id);
        $penilaian_map = PenilaianMap::where('inovasi_id', $id)->get();
        $kategori_juri = Juri::where('kategori_id', $inovasi->kategori_id)->pluck('user_id');

        $data = $inovasi->penilaian()->whereIn('user_id', $kategori_juri)->get();  // Filter berdasarkan kategori juri 
        $pdf = PDF::loadview('penilaian.print', compact('kategori_juri', 'inovasi', 'data'));

        $customPaper = array(0, 0, 595.35, 935.55);
        $pdf->setPaper($customPaper);
        $pdf->output();

        return $pdf->stream('penilaian-' . $inovasi->nama . '-' . $inovasi->kode . '.pdf');
    }

    public function pass(Request $request)
    {
        $proposalId = $request->input('is_pass');
        foreach ($proposalId as $id) {
            $proposal = ProposalKovablik::find($id);
            $proposal->tahapan_id = 2;
            $proposal->save();
        }
        return back()->with('success', 'Proposal diloloskan ke tahap selanjutnya.');
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {
            $proposal = ProposalKovablik::findOrFail($request->proposal_id);
            $total_nilai = 0;

            foreach ($request->except('_token', 'proposal_id') as $key => $value) {
                if (strpos($key, 'keterangan_') === 0) {
                    $penilaianId = str_replace('keterangan_', '', $key);
                    $catatanSaran = $value;
                    $nilai = $request->input("nilai_$penilaianId");
                    $bobot = $request->input("bobot_nilai_$penilaianId");
                    $nilai = $nilai * $bobot / 100;

                    if (is_numeric($nilai)) {
                        $pivot = $proposal->penilaian()
                            ->wherePivot('user_id', Auth::id())
                            ->wherePivot('penilaian_id', $penilaianId)
                            ->first();

                        if ($pivot) {
                            $proposal->penilaian()->updateExistingPivot($penilaianId, [
                                'catatan_saran' => $catatanSaran,
                                'nilai' => $nilai,
                            ]);
                            $total_nilai += $nilai;
                        }
                    }
                }
            }

            // Proses tanda tangan
            if ($request->has('signature_data')) {
                $signatureData = $request->input('signature_data');
                $signatureName = 'signature_' . time() . '.png';
                $signaturePath = public_path('uploads/signatures/');

                // Buat folder jika belum ada
                if (!File::exists($signaturePath)) {
                    File::makeDirectory($signaturePath, 0755, true);
                }

                $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
                $signatureData = str_replace(' ', '+', $signatureData);
                $signatureImage = base64_decode($signatureData);
                file_put_contents($signaturePath . $signatureName, $signatureImage);
                if ($request->penilaian_map != null || !empty($request->penilaian_map)) {
                    $penilaian_map = PenilaianKovablikMap::find($request->penilaian_map);
                } else {
                    $penilaian_map = new PenilaianKovablikMap();
                }
                $penilaian_map->proposal_id = $proposal->id;
                $penilaian_map->tahapan_id = $proposal->tahapan_id;
                $penilaian_map->juri_id = $request->juri_id;
                $penilaian_map->total_nilai = $total_nilai;
                $penilaian_map->signature_path = 'uploads/signatures/' . $signatureName;
                $penilaian_map->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }

        return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui!');
    }
}
