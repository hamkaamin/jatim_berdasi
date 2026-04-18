<?php

namespace Tests\Feature;

use App\Models\Fase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FaseSaveTest extends TestCase
{
    use DatabaseTransactions;

    private function superadmin(): User
    {
        return User::factory()->create(['role' => 1]);
    }

    private function regularUser(): User
    {
        return User::factory()->create(['role' => 2]);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'id'           => 0,
            'nama'         => 'iga',
            'keterangan'   => 'Fase IGA 2026',
            'tahun'        => 2026,
            'tgl_berakhir' => '2026-06-30 23:59:00',
            'active'       => 0,
            'kode'         => null,
        ], $overrides);
    }

    // --- Auth & Authorization ---

    public function test_unauthenticated_user_is_redirected()
    {
        $response = $this->post(route('master.fase.save'), $this->payload());

        $response->assertRedirect('/login');
    }

    public function test_non_superadmin_gets_403()
    {
        $response = $this->actingAs($this->regularUser())
            ->post(route('master.fase.save'), $this->payload());

        $response->assertForbidden();
    }

    // --- Create (id = 0) ---

    public function test_superadmin_can_create_new_fase()
    {
        $response = $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload());

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('fases', [
            'nama'       => 'iga',
            'keterangan' => 'Fase IGA 2026',
            'tahun'      => 2026,
            'active'     => 0,
        ]);
    }

    public function test_create_fase_saves_all_fields_correctly()
    {
        $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload([
                'nama'         => 'inotek',
                'keterangan'   => 'Fase Inotek',
                'tahun'        => 2025,
                'tgl_berakhir' => '2025-12-31 23:59:00',
                'active'       => 0,
                'kode'         => 'INO-01',
            ]));

        $fase = Fase::orderBy('id', 'desc')->first();
        $this->assertEquals('inotek', $fase->nama);
        $this->assertEquals('Fase Inotek', $fase->keterangan);
        $this->assertEquals(2025, $fase->tahun);
        $this->assertEquals('INO-01', $fase->kode);
    }

    // --- Update (id != 0) ---

    public function test_superadmin_can_update_existing_fase()
    {
        $fase = (new Fase)->forceFill([
            'nama'       => 'iga',
            'keterangan' => 'Lama',
            'tahun'      => 2025,
            'active'     => 0,
        ]);
        $fase->save();

        $response = $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload([
                'id'         => $fase->id,
                'keterangan' => 'Baru',
                'tahun'      => 2026,
            ]));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('fases', [
            'id'         => $fase->id,
            'keterangan' => 'Baru',
            'tahun'      => 2026,
        ]);
    }

    public function test_update_with_nonexistent_id_returns_404()
    {
        $response = $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload(['id' => 9999]));

        $response->assertNotFound();
    }

    // --- Active flag logic ---

    public function test_fase_saved_with_active_1_is_active()
    {
        $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload(['active' => 1]));

        $fase = Fase::orderBy('id', 'desc')->first();
        $this->assertEquals(1, $fase->active);
        $this->assertEquals(1, $fase->timer);
    }

    public function test_fase_saved_with_active_0_is_inactive()
    {
        $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload(['active' => 0]));

        $fase = Fase::orderBy('id', 'desc')->first();
        $this->assertEquals(0, $fase->active);
        $this->assertEquals(0, $fase->timer);
    }

    public function test_multiple_fases_can_be_active_simultaneously()
    {
        $existing = (new Fase)->forceFill(['nama' => 'inotek', 'active' => 1, 'timer' => 1]);
        $existing->save();

        $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload(['nama' => 'iga', 'active' => 1]));

        $this->assertDatabaseHas('fases', ['id' => $existing->id, 'active' => 1, 'timer' => 1]);
        $this->assertDatabaseHas('fases', ['nama' => 'iga', 'active' => 1, 'timer' => 1]);
    }

    public function test_saving_fase_does_not_affect_other_fases_active_status()
    {
        $other = (new Fase)->forceFill(['nama' => 'kovablik', 'active' => 1, 'timer' => 1]);
        $other->save();

        $this->actingAs($this->superadmin())
            ->post(route('master.fase.save'), $this->payload(['nama' => 'iga', 'active' => 0]));

        $this->assertDatabaseHas('fases', ['id' => $other->id, 'active' => 1, 'timer' => 1]);
    }
}
