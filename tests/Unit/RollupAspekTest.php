<?php

namespace Tests\Unit;

use App\Helper\Helper;
use PHPUnit\Framework\TestCase;

class RollupAspekTest extends TestCase
{
    /**
     * Bikin node pohon sederhana untuk rollupAspek/flattenAspek.
     * $children = array node anak (atau [] untuk leaf).
     */
    private function node($id, $bobot, $parentId = null, array $children = [])
    {
        $n = new \stdClass();
        $n->id = $id;
        $n->bobot_nilai = $bobot;
        $n->parent_id = $parentId;
        $n->children = collect($children);
        return $n;
    }

    public function test_flat_legacy_semua_root_bobot_100()
    {
        $tree = collect([
            $this->node(1, 100),
            $this->node(2, 100),
            $this->node(3, 100),
        ]);

        $stored = Helper::rollupAspek($tree, [1 => 80, 2 => 60, 3 => 90]);

        $this->assertEquals(80.0, $stored[1]);
        $this->assertEquals(60.0, $stored[2]);
        $this->assertEquals(90.0, $stored[3]);

        $total = $tree->sum(fn ($n) => $stored[$n->id]);
        $this->assertEquals(230.0, $total);
    }

    public function test_flat_bobot_25()
    {
        $tree = collect([$this->node(1, 25)]);

        $stored = Helper::rollupAspek($tree, [1 => 80]);

        $this->assertEquals(20.0, $stored[1]);
    }

    public function test_dua_level_rollup_ke_induk()
    {
        // root(100) -> leaf A(50) raw 80, leaf B(50) raw 60
        $tree = collect([
            $this->node(1, 100, null, [
                $this->node(2, 50, 1),
                $this->node(3, 50, 1),
            ]),
        ]);

        $stored = Helper::rollupAspek($tree, [2 => 80, 3 => 60]);

        $this->assertEquals(40.0, $stored[2]);           // 80 * 50 / 100
        $this->assertEquals(30.0, $stored[3]);           // 60 * 50 / 100
        $this->assertEquals(70.0, $stored[1]);           // (40 + 30) * 100 / 100

        $total = $tree->sum(fn ($n) => $stored[$n->id]); // hanya root
        $this->assertEquals(70.0, $total);
    }

    public function test_tiga_level_bersarang()
    {
        // root(100) -> cabang(100) -> leaf X(50) raw 100, leaf Y(50) raw 40
        $tree = collect([
            $this->node(1, 100, null, [
                $this->node(2, 100, 1, [
                    $this->node(3, 50, 2),
                    $this->node(4, 50, 2),
                ]),
            ]),
        ]);

        $stored = Helper::rollupAspek($tree, [3 => 100, 4 => 40]);

        $this->assertEquals(50.0, $stored[3]);   // 100 * 50/100
        $this->assertEquals(20.0, $stored[4]);   // 40 * 50/100
        $this->assertEquals(70.0, $stored[2]);   // (50+20) * 100/100
        $this->assertEquals(70.0, $stored[1]);   // 70 * 100/100
    }

    public function test_bobot_nol_menghasilkan_nol()
    {
        $tree = collect([$this->node(1, 0)]);

        $stored = Helper::rollupAspek($tree, [1 => 90]);

        $this->assertEquals(0.0, $stored[1]);
    }

    public function test_leaf_kosong_dianggap_nol()
    {
        $tree = collect([
            $this->node(1, 100, null, [
                $this->node(2, 50, 1),
                $this->node(3, 50, 1),
            ]),
        ]);

        $stored = Helper::rollupAspek($tree, [2 => 80]); // leaf 3 tidak diisi

        $this->assertEquals(40.0, $stored[2]);
        $this->assertEquals(0.0, $stored[3]);
        $this->assertEquals(40.0, $stored[1]);
    }

    public function test_saudara_bobot_kurang_dari_100()
    {
        $tree = collect([
            $this->node(1, 100, null, [
                $this->node(2, 40, 1),
                $this->node(3, 40, 1),
            ]),
        ]);

        $stored = Helper::rollupAspek($tree, [2 => 100, 3 => 100]);

        $this->assertEquals(40.0, $stored[2]);
        $this->assertEquals(40.0, $stored[3]);
        $this->assertEquals(80.0, $stored[1]); // total di bawah 100, sesuai desain
    }

    public function test_flatten_aspek_pre_order()
    {
        $tree = collect([
            $this->node(1, 100, null, [
                $this->node(2, 50, 1, [
                    $this->node(4, 100, 2),
                ]),
                $this->node(3, 50, 1),
            ]),
        ]);

        $flat = Helper::flattenAspek($tree);
        $ids = array_map(fn ($n) => $n->id, $flat);

        $this->assertSame([1, 2, 4, 3], $ids);
    }

    public function test_aspek_leaf_ids()
    {
        $flat = collect([
            $this->node(1, 100),
            $this->node(2, 50, 1),
            $this->node(3, 50, 1),
            $this->node(4, 100, 2),
        ]);

        $this->assertEquals([3, 4], Helper::aspekLeafIds($flat));
    }
}
