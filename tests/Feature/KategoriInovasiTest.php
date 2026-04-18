<?php

namespace Tests\Feature;

use App\Models\KategoriInovasi;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KategoriInovasiTest extends TestCase
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

    private function makeKategori(array $attrs = []): KategoriInovasi
    {
        $kategori = (new KategoriInovasi)->forceFill(array_merge([
            'nama'        => 'Kategori Test',
            'is_aktif'    => 1,
            'is_kovablik' => 0,
        ], $attrs));
        $kategori->save();
        return $kategori;
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'id'          => 0,
            'nama'        => 'Kategori Baru',
            'is_active'   => 1,
            'is_kovablik' => 0,
        ], $overrides);
    }

    // --- Auth & Authorization ---

    public function test_unauthenticated_user_is_redirected_on_save()
    {
        $response = $this->post(route('master.kategori.save'), $this->payload());

        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_user_is_redirected_on_delete()
    {
        $kategori = $this->makeKategori();

        $response = $this->post(route('master.kategori.delete'), ['id' => $kategori->id]);

        $response->assertRedirect('/login');
    }

    public function test_non_superadmin_cannot_save()
    {
        $response = $this->actingAs($this->regularUser())
            ->post(route('master.kategori.save'), $this->payload());

        $response->assertForbidden();
    }

    public function test_non_superadmin_cannot_delete()
    {
        $kategori = $this->makeKategori();

        $response = $this->actingAs($this->regularUser())
            ->post(route('master.kategori.delete'), ['id' => $kategori->id]);

        $response->assertForbidden();
    }

    // --- Save: Create (id = 0) ---

    public function test_superadmin_can_create_kategori()
    {
        $response = $this->actingAs($this->superadmin())
            ->post(route('master.kategori.save'), $this->payload());

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kategori_inovasis', [
            'nama'        => 'Kategori Baru',
            'is_aktif'    => 1,
            'is_kovablik' => 0,
        ]);
    }

    public function test_create_kategori_saves_all_fields_correctly()
    {
        $this->actingAs($this->superadmin())
            ->post(route('master.kategori.save'), $this->payload([
                'nama'        => 'Inovasi Pelayanan',
                'is_active'   => 0,
                'is_kovablik' => 1,
            ]));

        $kategori = KategoriInovasi::orderBy('id', 'desc')->first();
        $this->assertEquals('Inovasi Pelayanan', $kategori->nama);
        $this->assertEquals(0, $kategori->is_aktif);
        $this->assertEquals(1, $kategori->is_kovablik);
    }

    public function test_create_kategori_with_is_kovablik_false()
    {
        $this->actingAs($this->superadmin())
            ->post(route('master.kategori.save'), $this->payload([
                'is_kovablik' => 0,
            ]));

        $kategori = KategoriInovasi::orderBy('id', 'desc')->first();
        $this->assertEquals(0, $kategori->is_kovablik);
    }

    // --- Save: Update (id != 0) ---

    public function test_superadmin_can_update_existing_kategori()
    {
        $kategori = $this->makeKategori(['nama' => 'Lama', 'is_aktif' => 0]);

        $response = $this->actingAs($this->superadmin())
            ->post(route('master.kategori.save'), $this->payload([
                'id'        => $kategori->id,
                'nama'      => 'Baru',
                'is_active' => 1,
            ]));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kategori_inovasis', [
            'id'          => $kategori->id,
            'nama'        => 'Baru',
            'is_aktif'    => 1,
            'is_kovablik' => 0,
        ]);
    }

    public function test_update_with_nonexistent_id_returns_404()
    {
        $response = $this->actingAs($this->superadmin())
            ->post(route('master.kategori.save'), $this->payload(['id' => 99999]));

        $response->assertNotFound();
    }

    // --- Delete ---

    public function test_superadmin_can_delete_kategori()
    {
        $kategori = $this->makeKategori(['nama' => 'Akan Dihapus']);

        $response = $this->actingAs($this->superadmin())
            ->post(route('master.kategori.delete'), ['id' => $kategori->id]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('kategori_inovasis', ['id' => $kategori->id]);
    }

    public function test_delete_with_nonexistent_id_returns_404()
    {
        $response = $this->actingAs($this->superadmin())
            ->post(route('master.kategori.delete'), ['id' => 99999]);

        $response->assertNotFound();
    }
}
