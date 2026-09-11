<?php

namespace Tests\Feature;

use App\Models\Inovasi;
use App\Models\Juri;
use App\Models\KategoriInovasi;
use App\Models\Penilaian;
use App\Models\PenilaianMap;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PenilaianRollupSaveTest extends TestCase
{
    use DatabaseTransactions;

    // PNG 1x1 valid.
    private const SIGNATURE = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    private KategoriInovasi $kategori;
    private User $juriUser;
    private Juri $juri;
    private Inovasi $inovasi;
    /** @var array<string,Penilaian> */
    private array $node = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->kategori = KategoriInovasi::where('id', '!=', 1)->first();
        $this->assertNotNull($this->kategori, 'Tabel kategori_inovasis kosong');

        $this->juriUser = User::factory()->create([
            'role' => 7,
            'tahun' => 2026,
            'province_id' => null,
            'regency_id' => null,
            'opd_id' => null,
        ]);

        $this->juri = Juri::forceCreate([
            'user_id' => $this->juriUser->id,
            'kategori_id' => $this->kategori->id,
        ]);

        $tahapan = Tahapan::first();
        $this->assertNotNull($tahapan, 'Tabel tahapans kosong');

        $this->inovasi = Inovasi::forceCreate([
            'user_id' => $this->juriUser->id,
            'kode' => uniqid('inv'),
            'nama' => 'Inovasi Rollup Test',
            'label' => 1,
            'tahun' => 2026,
            'status' => 2,
            'kategori_id' => $this->kategori->id,
            'tahapan_id' => $tahapan->id,
            'juri_tahap' => 1,
        ]);

        // Pohon: R(100) -> B1(50) -> L1a(50), L1b(50)
        //               -> B2(50) -> L2a(100)
        $this->node['R'] = $this->penilaian('Root', 100, null);
        $this->node['B1'] = $this->penilaian('Cabang 1', 50, $this->node['R']->id);
        $this->node['B2'] = $this->penilaian('Cabang 2', 50, $this->node['R']->id);
        $this->node['L1a'] = $this->penilaian('Leaf 1a', 50, $this->node['B1']->id);
        $this->node['L1b'] = $this->penilaian('Leaf 1b', 50, $this->node['B1']->id);
        $this->node['L2a'] = $this->penilaian('Leaf 2a', 100, $this->node['B2']->id);
    }

    private function penilaian(string $bagian, int $bobot, ?int $parentId): Penilaian
    {
        return Penilaian::forceCreate([
            'parent_id' => $parentId,
            'bagian' => $bagian,
            'indikator' => null,
            'kategori_id' => $this->kategori->id,
            'nilai_min' => 0,
            'nilai_max' => 100,
            'bobot_nilai' => $bobot,
        ]);
    }

    private function saveBody(array $overrides = []): array
    {
        return array_merge([
            'juri_id' => $this->juri->id,
            'signature_data' => self::SIGNATURE,
            'nilai_' . $this->node['L1a']->id => 80,
            'nilai_' . $this->node['L1b']->id => 60,
            'nilai_' . $this->node['L2a']->id => 90,
            'keterangan_' . $this->node['L1a']->id => 'catatan a',
        ], $overrides);
    }

    private function submit(array $body = null)
    {
        return $this->actingAs($this->juriUser)->post(
            route('penilaian.save', ['inovasi_id' => $this->inovasi->id]),
            $body ?? $this->saveBody()
        );
    }

    private function pivotNilai(string $key): float
    {
        return (float) DB::table('penilaian_inovasi')
            ->where('inovasi_id', $this->inovasi->id)
            ->where('penilaian_id', $this->node[$key]->id)
            ->where('user_id', $this->juriUser->id)
            ->where('juri_tahap', 1)
            ->value('nilai');
    }

    public function test_leaf_disimpan_berbobot()
    {
        $this->submit()->assertRedirect();

        $this->assertEqualsWithDelta(40.0, $this->pivotNilai('L1a'), 0.001); // 80 * 50/100
        $this->assertEqualsWithDelta(30.0, $this->pivotNilai('L1b'), 0.001); // 60 * 50/100
        $this->assertEqualsWithDelta(90.0, $this->pivotNilai('L2a'), 0.001); // 90 * 100/100
    }

    public function test_induk_terisi_rollup_dari_anak()
    {
        $this->submit();

        $this->assertEqualsWithDelta(35.0, $this->pivotNilai('B1'), 0.001); // (40+30) * 50/100
        $this->assertEqualsWithDelta(45.0, $this->pivotNilai('B2'), 0.001); // 90 * 50/100
        $this->assertEqualsWithDelta(80.0, $this->pivotNilai('R'), 0.001);  // (35+45) * 100/100
    }

    public function test_total_nilai_pada_map_adalah_jumlah_root()
    {
        $this->submit()->assertSessionHas('success');

        $map = PenilaianMap::where('inovasi_id', $this->inovasi->id)
            ->where('juri_id', $this->juri->id)
            ->where('juri_tahap', 1)
            ->first();

        $this->assertNotNull($map);
        $this->assertEqualsWithDelta(80.0, (float) $map->total_nilai, 0.001);
        $this->assertNotEmpty($map->signature_path);
    }

    public function test_catatan_saran_hanya_pada_leaf()
    {
        $this->submit();

        $noteLeaf = DB::table('penilaian_inovasi')
            ->where('inovasi_id', $this->inovasi->id)
            ->where('penilaian_id', $this->node['L1a']->id)
            ->value('catatan_saran');
        $noteBranch = DB::table('penilaian_inovasi')
            ->where('inovasi_id', $this->inovasi->id)
            ->where('penilaian_id', $this->node['B1']->id)
            ->value('catatan_saran');

        $this->assertSame('catatan a', $noteLeaf);
        $this->assertNull($noteBranch);
    }

    public function test_tanpa_tanda_tangan_ditolak_dan_tidak_menulis_apa_pun()
    {
        $response = $this->submit($this->saveBody(['signature_data' => '']));

        $response->assertRedirect();
        $response->assertSessionHasErrors('signature_data');

        $this->assertSame(0, DB::table('penilaian_inovasi')
            ->where('inovasi_id', $this->inovasi->id)
            ->where('user_id', $this->juriUser->id)
            ->count());
        $this->assertSame(0, PenilaianMap::where('inovasi_id', $this->inovasi->id)->count());
    }

    public function test_simpan_ulang_dengan_tanda_tangan_baru_memperbarui_total()
    {
        $this->submit()->assertRedirect();
        $mapId = PenilaianMap::where('inovasi_id', $this->inovasi->id)->value('id');

        // Ubah satu leaf lalu simpan ulang dengan tanda tangan baru.
        $this->actingAs($this->juriUser)->post(
            route('penilaian.save', ['inovasi_id' => $this->inovasi->id, 'penilaian_map' => $mapId]),
            $this->saveBody(['nilai_' . $this->node['L2a']->id => 40])
        )->assertRedirect();

        // L2a: 40 * 100/100 = 40 ; B2: 40 * 50/100 = 20 ; R: (35 + 20) * 100/100 = 55
        $this->assertEqualsWithDelta(55.0, $this->pivotNilai('R'), 0.001);

        $map = PenilaianMap::where('inovasi_id', $this->inovasi->id)
            ->where('juri_tahap', 1)->first();
        $this->assertEqualsWithDelta(55.0, (float) $map->total_nilai, 0.001);
        $this->assertSame(1, PenilaianMap::where('inovasi_id', $this->inovasi->id)->count());
    }
}
