<?php

namespace App\Http\Controllers;

use App\Exports\PenilaianKovablikExport;
use App\Models\Juri;
use App\Models\JuriKovablik;
use App\Models\KategoriInovasi;
use App\Models\KategoriKovablik;
use App\Models\KategoriNilaiKovablik;
use App\Models\KelompokKovablik;
use App\Models\PenilaianKovablikMap;
use App\Models\ProposalKovablik;
use App\Models\Tahapan;
use App\Models\TahapanKovablik;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianKovablikController extends Controller
{
    public function index()
    {
        $kelompok = KelompokKovablik::whereIn('id', function ($query) {
            $query->select('kelompok_id')
                ->from('juri_kovabliks')
                ->where('user_id', Auth::user()->id);
        })
            ->with([
                'hasManyKovablik' => function ($query) {
                    $query->where('status', 2);
                },
                'tahapan' => function ($query) {
                    $query->with(['proposals' => function ($query) {
                        $query->where('status', 2)
                            ->whereIn('kelompok_id', function ($subquery) {
                                $subquery->select('kelompok_id')
                                    ->from('juri_kovabliks')
                                    ->where('user_id', Auth::user()->id);
                            });
                    }]);
                }
            ])
            ->get();
        return view('penilaian-kovablik.index', compact('kelompok'));
    }

    public function edit(Request $request)
    {
        $id = decrypt($request->id);
        $juri_tahap = $request->tahap;
        $proposal = ProposalKovablik::findOrFail($id);
        $kategori = KategoriInovasi::where('is_kovablik', 1)->first();
        $juri = Juri::where('user_id', Auth::user()->id)->where('kategori_id', $kategori->id)->first();
        $penilaians = KategoriNilaiKovablik::where('tahapan_id', $proposal->juri_tahap)->get();
        foreach ($penilaians as $penilaian) {
            $exists = DB::table('penilaian_kovabliks')
                ->where('proposal_id', $proposal->id)
                ->where('penilaian_id', $penilaian->id)
                ->where('user_id', Auth::id())
                ->where('juri_tahap', $proposal->juri_tahap)
                ->exists();
            if (!$exists) {
                $proposal->penilaian()->attach($penilaian->id, [
                    'user_id' => Auth::id(),
                    'juri_tahap' => $proposal->juri_tahap,
                ]);
            }
        }
        $data = $proposal->penilaian()->wherePivot('user_id', Auth::id())->wherePivot('juri_tahap', $proposal->juri_tahap)->get();

        $penilaian_map = PenilaianKovablikMap::where('proposal_id', $id)->where('juri_id', $juri->id)->where('juri_tahap', $proposal->juri_tahap)->first();
        return view('penilaian-kovablik.edit', compact('data', 'proposal', 'juri', 'penilaian_map', 'juri_tahap'));
    }

    public function show(Request $request)
    {
        $jenis = $request->jenis;
        $id = decrypt($request->id);
        $proposal = ProposalKovablik::findOrFail($id);
        $kelompok_juri = JuriKovablik::where('kelompok_id', $proposal->kelompok_id)->pluck('user_id');
        $penilaian_map = PenilaianKovablikMap::where('proposal_id', $id)->where('juri_tahap', $proposal->juri_tahap)->get();

        $penilaian_per_juri = [];

        foreach ($kelompok_juri as $user_id) {
            $penilaian_per_juri[$user_id] = $proposal->penilaian()
                ->where('user_id', $user_id)
                ->get();
        }

        return view('penilaian-kovablik.show', compact('kelompok_juri', 'penilaian_per_juri', 'proposal', 'jenis', 'penilaian_map'));
    }

    public function move(Request $request)
    {
        $ids = $request->input('id');
        try {
            DB::beginTransaction();
            foreach ($ids as $id) {
                $kovablik = ProposalKovablik::find($id);
                if ($kovablik->juri_tahap == 1) {
                    $kategori = KategoriInovasi::where('is_kovablik', 1)->first();
                    $juri = Juri::where('kategori_id', $kategori->id)->get();
                    $juri_ids = $juri->pluck('id');

                    $jumlah_penilai = PenilaianKovablikMap::where('proposal_id', $kovablik->id)
                        ->where('juri_tahap', 1)
                        ->whereIn('juri_id', $juri_ids)
                        ->count();
                    if ($jumlah_penilai < $juri->count()) {
                        $sudah_menilai = PenilaianKovablikMap::where('proposal_id', $kovablik->id)
                            ->where('juri_tahap', 1)
                            ->whereIn('juri_id', $juri_ids)
                            ->pluck('juri_id');

                        $belum_menilai = $juri->whereNotIn('id', $sudah_menilai)
                            ->map(fn($j) => $j->user ? $j->user->name : 'Juri #'.$j->id)
                            ->values()
                            ->toArray();

                        return response()->json([
                            'status' => false,
                            'message' => 'Juri yang belum menilai: ' . implode(', ', $belum_menilai),
                            'error' => 'Gagal',
                        ]);
                    }
                }
                $kovablik->juri_tahap = $kovablik->juri_tahap + 1;
                $kovablik->save();
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Proposal Kovablik Berhasil Masuk ke Tahap ' . $kovablik->juri_tahap,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Failed to update status and keterangan.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
                        $updated = DB::table('penilaian_kovabliks')
                            ->where('proposal_id', $proposal->id)
                            ->where('penilaian_id', $penilaianId)
                            ->where('user_id', Auth::id())
                            ->where('juri_tahap', $proposal->juri_tahap)
                            ->update([
                                'catatan_saran' => $catatanSaran,
                                'nilai' => $nilai,
                            ]);
                        if ($updated) {
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
                $penilaian_map->juri_id = $request->juri_id;
                $penilaian_map->total_nilai = $total_nilai;
                $penilaian_map->juri_tahap = $proposal->juri_tahap;
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

    public function ranking(Request $request)
    {
        if ($request->tahap != 1 && $request->tahap != 2) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        $juri_tahap = $request->tahap;
        $data_kelompok = KelompokKovablik::orderBy('id', 'asc')->get();
        if (Auth::user()->role == 7) {
            $data_kelompok = KelompokKovablik::whereIn('id', function ($query) {
                $query->select('kelompok_id')
                    ->from('juri_kovabliks')
                    ->where('user_id', Auth::user()->id);
            })->get();
        }
        if (Auth::user()->role == 2) {
            $data_kelompok = KelompokKovablik::whereIn('id', function ($query) {
                $query->select('kelompok_id')
                    ->from('verifikator_kovabliks')
                    ->where('user_id', Auth::user()->id);
            })
                ->get();
        }

        return view('penilaian.index_ranking_kovablik', compact('data_kelompok', 'juri_tahap'));
    }

    public function export($juri_tahap, $kelompok_id)
    {
        $kategori = KelompokKovablik::find($kelompok_id);
        $nama_file = 'Export Penilaian Inovasi Kategori ' . $kategori->nama_singkat . ' ' . Auth::user()->tahun . '_Tanggal_' . date('d-m-Y H-i-s') . '.xlsx';
        return Excel::download(new PenilaianKovablikExport($kelompok_id, $juri_tahap), $nama_file);
        session()->put('status', 'Data Opd berhasil diunduh!');
    }

    public function print($id, $juri_tahap)
    {
        $id = decrypt($id);
        $proposal = ProposalKovablik::findOrFail($id);
        $penilaian_map = PenilaianKovablikMap::where('proposal_id', $id)->where('juri_tahap', $juri_tahap)->get();
        $kelompok_juri = JuriKovablik::where('kelompok_id', $proposal->kelompok_id)->pluck('user_id');

        $data = $proposal->penilaian()->whereIn('user_id', $kelompok_juri)->where('juri_tahap', $juri_tahap)->get();  // Filter berdasarkan kategori juri 
        $pdf = PDF::loadview('penilaian-kovablik.print', compact('kelompok_juri', 'proposal', 'data', 'juri_tahap'));

        $customPaper = array(0, 0, 595.35, 935.55);
        $pdf->setPaper($customPaper);
        $pdf->output();

        return $pdf->stream('penilaian-' . $proposal->judul . '-' . $proposal->kode . '.pdf');
    }
}
