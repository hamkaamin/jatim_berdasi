<?php

namespace App\Http\Controllers;

use App\Exports\PenilaianKovablikExport;
use App\Helper\Helper;
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
        $data = $proposal->penilaian()->wherePivot('user_id', Auth::id())->wherePivot('juri_tahap', $proposal->juri_tahap)->get()->sortBy('id')->values();
        $tree = Helper::buildAspekTree($data);
        $leafIds = Helper::aspekLeafIds($data);
        $grandTotal = collect($tree)->sum(fn ($n) => optional($n->pivot)->nilai);

        $penilaian_map = PenilaianKovablikMap::where('proposal_id', $id)->where('juri_id', $juri->id)->where('juri_tahap', $proposal->juri_tahap)->first();
        return view('penilaian-kovablik.edit', compact('data', 'tree', 'leafIds', 'grandTotal', 'proposal', 'juri', 'penilaian_map', 'juri_tahap'));
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
        $is_next = filter_var($request->input('is_next'), FILTER_VALIDATE_BOOLEAN);

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

                // Tandai nilai tahap saat ini sebagai boleh ditampilkan (sebelum increment)
                $kovablik->nilai_juri_tahap_show = $kovablik->juri_tahap;

                if ($is_next) {
                    $kovablik->juri_tahap = $kovablik->juri_tahap + 1;
                }

                $kovablik->save();
            }
            DB::commit();

            $message = $is_next
                ? 'Proposal Kovablik Berhasil Masuk ke Tahap ' . $kovablik->juri_tahap . ' dan Nilai Tahap Sebelumnya Dibagikan'
                : 'Nilai Tahap ' . $kovablik->nilai_juri_tahap_show . ' Berhasil Dibagikan';

            return response()->json(['status' => true, 'message' => $message], 200);
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
        // Tanda tangan wajib (selalu baru) setiap menyimpan.
        if (!$request->filled('signature_data')) {
            return redirect()->back()
                ->withErrors(['signature_data' => 'Tanda tangan wajib diisi sebelum menyimpan penilaian.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $proposal = ProposalKovablik::findOrFail($request->proposal_id);

            // 1. Pohon rubrik otoritatif dari master (bukan dari request).
            $flat = KategoriNilaiKovablik::where('tahapan_id', $proposal->juri_tahap)->get()->sortBy('id')->values();
            $tree = Helper::buildAspekTree($flat);
            $leafIds = Helper::aspekLeafIds($flat);

            // 2. Kumpulkan input leaf + catatan.
            $rawByLeafId = [];
            $noteById = [];
            foreach ($leafIds as $lid) {
                if ($request->has("nilai_$lid")) {
                    $rawByLeafId[$lid] = $request->input("nilai_$lid");
                }
                if ($request->has("keterangan_$lid")) {
                    $noteById[$lid] = $request->input("keterangan_$lid");
                }
            }

            // 3. Nilai tersimpan (berbobot) bottom-up untuk SEMUA node.
            $storedById = Helper::rollupAspek($tree, $rawByLeafId);

            // 4. Persist tiap node (updateOrInsert agar node rubrik baru tetap dapat baris).
            foreach ($storedById as $rid => $stored) {
                $key = [
                    'proposal_id' => $proposal->id,
                    'penilaian_id' => $rid,
                    'user_id' => Auth::id(),
                    'juri_tahap' => $proposal->juri_tahap,
                ];
                $values = ['nilai' => is_numeric($stored) ? $stored : 0];
                if (in_array($rid, $leafIds)) {
                    $values['catatan_saran'] = $noteById[$rid] ?? null;
                }
                DB::table('penilaian_kovabliks')->updateOrInsert($key, $values);
            }

            // 5. Total = Σ node root saja.
            $total_nilai = collect($tree)->sum(fn ($n) => $storedById[$n->id] ?? 0);

            // 6. Simpan tanda tangan juri.
            $signatureData = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->input('signature_data'));
            $signatureImage = base64_decode($signatureData);
            $signatureName = 'signature_' . time() . '.png';
            $signaturePath = public_path('uploads/signatures/');

            if (!File::exists($signaturePath)) {
                File::makeDirectory($signaturePath, 0755, true);
            }

            file_put_contents($signaturePath . $signatureName, $signatureImage);

            $penilaian_map = $request->filled('penilaian_map')
                ? PenilaianKovablikMap::find($request->penilaian_map)
                : new PenilaianKovablikMap();
            if (!$penilaian_map) {
                $penilaian_map = new PenilaianKovablikMap();
            }

            $penilaian_map->proposal_id = $proposal->id;
            $penilaian_map->juri_id = $request->juri_id;
            $penilaian_map->total_nilai = $total_nilai;
            $penilaian_map->juri_tahap = $proposal->juri_tahap;
            $penilaian_map->signature_path = 'uploads/signatures/' . $signatureName;
            $penilaian_map->save();

            DB::commit();
            return redirect()->back()->with('success', 'Data penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
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
