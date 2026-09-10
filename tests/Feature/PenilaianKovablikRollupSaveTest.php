<?php

namespace Tests\Feature;

use App\Models\KategoriNilaiKovablik;
use App\Models\PenilaianKovablikMap;
use App\Models\ProposalKovablik;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PenilaianKovablikRollupSaveTest extends TestCase
{
    use DatabaseTransactions;

    private const SIGNATURE = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    private User $juriUser;
    private ProposalKovablik $proposal;
    private int $juriId = 999001; // penilaian_kovablik_maps.juri_id bebas; hanya butuh nilai.
    private int $tahap;
    /** @var array<string,KategoriNilaiKovablik> */
    private array $node = [];

    private function bootScenario(int $tahap): void
    {
        $this->tahap = $tahap;

        $this->juriUser = User::factory()->create([
            'role' => 7,
            'tahun' => 2026,
            'province_id' => null,
            'regency_id' => null,
            'opd_id' => null,
        ]);

        $this->proposal = ProposalKovablik::forceCreate([
            'user_id' => $this->juriUser->id,
            'kode' => uniqid('kov'),
            'judul' => 'Proposal Rollup Test',
            'status' => 2,
            'tahun' => 2026,
            'juri_tahap' => $tahap,
        ]);

        // R(100) -> B1(50) -> L1a(50), L1b(50) ; R -> B2(50) -> L2a(100)
        $this->node['R'] = $this->kriteria('Root', 100, null);
        $this->node['B1'] = $this->kriteria('Cabang 1', 50, $this->node['R']->id);
        $this->node['B2'] = $this->kriteria('Cabang 2', 50, $this->node['R']->id);
        $this->node['L1a'] = $this->kriteria('Leaf 1a', 50, $this->node['B1']->id);
        $this->node['L1b'] = $this->kriteria('Leaf 1b', 50, $this->node['B1']->id);
        $this->node['L2a'] = $this->kriteria('Leaf 2a', 100, $this->node['B2']->id);
    }

    private function kriteria(string $bagian, int $bobot, ?int $parentId): KategoriNilaiKovablik
    {
        return KategoriNilaiKovablik::forceCreate([
            'parent_id' => $parentId,
            'bagian' => $bagian,
            'indikator' => null,
            'nilai_min' => 0,
            'nilai_max' => 100,
            'bobot_nilai' => $bobot,
            'tahapan_id' => $this->tahap,
        ]);
    }

    private function saveBody(array $overrides = []): array
    {
        return array_merge([
            'juri_id' => $this->juriId,
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
            route('penilaian-kovablik.save', ['proposal_id' => $this->proposal->id]),
            $body ?? $this->saveBody()
        );
    }

    private function pivotNilai(string $key): float
    {
        return (float) DB::table('penilaian_kovabliks')
            ->where('proposal_id', $this->proposal->id)
            ->where('penilaian_id', $this->node[$key]->id)
            ->where('user_id', $this->juriUser->id)
            ->where('juri_tahap', $this->tahap)
            ->value('nilai');
    }

    public function test_rollup_dan_total_tahap_1()
    {
        $this->bootScenario(1);
        $this->submit()->assertRedirect()->assertSessionHas('success');

        $this->assertEqualsWithDelta(40.0, $this->pivotNilai('L1a'), 0.001);
        $this->assertEqualsWithDelta(30.0, $this->pivotNilai('L1b'), 0.001);
        $this->assertEqualsWithDelta(35.0, $this->pivotNilai('B1'), 0.001);
        $this->assertEqualsWithDelta(45.0, $this->pivotNilai('B2'), 0.001);
        $this->assertEqualsWithDelta(80.0, $this->pivotNilai('R'), 0.001);

        $map = PenilaianKovablikMap::where('proposal_id', $this->proposal->id)
            ->where('juri_tahap', 1)->first();
        $this->assertNotNull($map);
        $this->assertEqualsWithDelta(80.0, (float) $map->total_nilai, 0.001);
        $this->assertNotEmpty($map->signature_path);
    }

    public function test_rollup_dengan_pohon_tahap_2()
    {
        $this->bootScenario(2);
        $this->submit()->assertRedirect();

        $this->assertEqualsWithDelta(35.0, $this->pivotNilai('B1'), 0.001);
        $this->assertEqualsWithDelta(80.0, $this->pivotNilai('R'), 0.001);

        $map = PenilaianKovablikMap::where('proposal_id', $this->proposal->id)
            ->where('juri_tahap', 2)->first();
        $this->assertEqualsWithDelta(80.0, (float) $map->total_nilai, 0.001);
    }

    public function test_tanpa_tanda_tangan_ditolak()
    {
        $this->bootScenario(1);
        $response = $this->submit($this->saveBody(['signature_data' => '']));

        $response->assertRedirect();
        $response->assertSessionHasErrors('signature_data');

        $this->assertSame(0, DB::table('penilaian_kovabliks')
            ->where('proposal_id', $this->proposal->id)
            ->where('user_id', $this->juriUser->id)
            ->count());
        $this->assertSame(0, PenilaianKovablikMap::where('proposal_id', $this->proposal->id)->count());
    }
}
