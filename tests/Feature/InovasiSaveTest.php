<?php

namespace Tests\Feature;

use App\Models\Inovasi;
use App\Models\KategoriInovasi;
use App\Models\Provinsi;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class InovasiSaveTest extends TestCase
{
    use DatabaseTransactions;

    private function user(array $attrs = []): User
    {
        return User::factory()->create(array_merge([
            'role'        => 3,
            'tahun'       => 2026,
            'province_id' => null,
            'regency_id'  => null,
            'opd_id'      => null,
        ], $attrs));
    }

    private function userWithProvince(): User
    {
        $province = Provinsi::first();
        $this->assertNotNull($province, 'Tabel provinces kosong');
        return $this->user(['province_id' => $province->id]);
    }

    private function kategoriId(): int
    {
        $k = KategoriInovasi::where('id', '!=', 1)->first();
        $this->assertNotNull($k, 'Tabel kategori_inovasis kosong');
        return $k->id;
    }

    private function tahapanId(): int
    {
        $t = Tahapan::first();
        $this->assertNotNull($t, 'Tabel tahapans kosong');
        return $t->id;
    }

    private function rancangBangun(int $wordCount = 15): string
    {
        return implode(' ', array_fill(0, $wordCount, 'kata'));
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'id'                 => 0,
            'label'              => 1,
            'nama'               => 'Inovasi Test',
            'kategori_id'        => null,
            'tahapan_id'         => null,
            'inisiator_id'       => null,
            'jenis_id'           => null,
            'bentuk_id'          => null,
            'tematik_id'         => null,
            'asta_cita_id'       => null,
            'detail_tematik_id'  => null,
            'nama_inisiator'     => 'Budi Santoso',
            'covid'              => 0,
            'rancang_bangun'     => $this->rancangBangun(15),
            'tujuan'             => 'Tujuan inovasi',
            'manfaat'            => 'Manfaat inovasi',
            'hasil'              => 'Hasil inovasi',
            'status'             => 0,
            'waktu_uji_coba'     => null,
            'waktu_penerapan'    => null,
            'waktu_pengembangan' => null,
            'urusan_id'          => [],
        ], $overrides);
    }

    // --- Auth ---

    public function test_unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->post(route('inovasi.save'), $this->payload());

        $response->assertRedirect('/login');
    }

    // --- Validation: rancang bangun word count ---

    public function test_rancang_bangun_with_fewer_than_10_words_returns_error()
    {
        $response = $this->actingAs($this->user())
            ->post(route('inovasi.save'), $this->payload([
                'kategori_id' => $this->kategoriId(),
                'tahapan_id'  => $this->tahapanId(),
                'rancang_bangun' => 'terlalu sedikit kata',
            ]));

        $response->assertSessionHas('error');
    }

    public function test_rancang_bangun_with_exactly_10_words_passes()
    {
        $response = $this->actingAs($this->user())
            ->post(route('inovasi.save'), $this->payload([
                'kategori_id'    => $this->kategoriId(),
                'tahapan_id'     => $this->tahapanId(),
                'rancang_bangun' => $this->rancangBangun(10),
            ]));

        $response->assertSessionMissing('error');
    }

    // --- Create (id = 0) ---

    public function test_creates_new_inovasi_and_redirects()
    {
        $response = $this->actingAs($this->user())
            ->post(route('inovasi.save'), $this->payload([
                'kategori_id' => $this->kategoriId(),
                'tahapan_id'  => $this->tahapanId(),
            ]));

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_create_persists_basic_fields_to_database()
    {
        $user = $this->user();
        $kategoriId = $this->kategoriId();

        $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'nama'           => 'Inovasi Spesifik',
            'nama_inisiator' => 'Dewi Rahayu',
            'label'          => 1,
            'kategori_id'    => $kategoriId,
            'tahapan_id'     => $this->tahapanId(),
        ]));

        $this->assertDatabaseHas('inovasis', [
            'nama'           => 'Inovasi Spesifik',
            'nama_inisiator' => 'Dewi Rahayu',
            'label'          => 1,
            'user_id'        => $user->id,
        ]);
    }

    public function test_create_persists_narasi_fields_correctly()
    {
        $user = $this->user();

        $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'kategori_id' => $this->kategoriId(),
            'tahapan_id'  => $this->tahapanId(),
            'tujuan'      => 'Tujuan inovasi spesifik',
            'manfaat'     => 'Manfaat inovasi spesifik',
            'hasil'       => 'Hasil inovasi spesifik',
        ]));

        $this->assertDatabaseHas('inovasis', [
            'tujuan'  => 'Tujuan inovasi spesifik',
            'manfaat' => 'Manfaat inovasi spesifik',
            'hasil'   => 'Hasil inovasi spesifik',
        ]);
    }

    public function test_create_auto_assigns_user_id_kode_and_tahun()
    {
        $user = $this->user(['tahun' => 2026]);

        $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'kategori_id' => $this->kategoriId(),
            'tahapan_id'  => $this->tahapanId(),
        ]));

        $inovasi = Inovasi::where('user_id', $user->id)->latest('id')->first();
        $this->assertNotNull($inovasi);
        $this->assertNotEmpty($inovasi->kode);
        $this->assertEquals(2026, $inovasi->tahun);
    }

    public function test_create_sets_provinsi_id_for_role_3_user()
    {
        $user = $this->userWithProvince();

        $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'kategori_id' => $this->kategoriId(),
            'tahapan_id'  => $this->tahapanId(),
        ]));

        $this->assertDatabaseHas('inovasis', [
            'user_id'     => $user->id,
            'provinsi_id' => $user->province_id,
        ]);
    }

    public function test_kategori_id_5_forces_tahapan_id_to_6()
    {
        $user = $this->user();

        $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'kategori_id' => 5,
            'tahapan_id'  => 99,
        ]));

        $inovasi = Inovasi::where('user_id', $user->id)->latest('id')->first();
        $this->assertNotNull($inovasi);
        $this->assertEquals(6, $inovasi->tahapan_id);
    }

    // --- Update (id != 0) ---

    public function test_updates_existing_inovasi_nama()
    {
        $user = $this->user();
        $inovasi = Inovasi::forceCreate([
            'user_id'    => $user->id,
            'kode'       => uniqid(),
            'nama'       => 'Nama Lama',
            'label'      => 1,
            'tahun'      => 2026,
            'status'     => 0,
            'tahapan_id' => $this->tahapanId(),
        ]);

        $response = $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'id'          => $inovasi->id,
            'nama'        => 'Nama Baru',
            'kategori_id' => $this->kategoriId(),
            'tahapan_id'  => $this->tahapanId(),
        ]));

        $response->assertRedirect();
        $this->assertDatabaseHas('inovasis', [
            'id'   => $inovasi->id,
            'nama' => 'Nama Baru',
        ]);
    }

    public function test_update_does_not_create_duplicate_record()
    {
        $user = $this->user();
        $inovasi = Inovasi::forceCreate([
            'user_id'    => $user->id,
            'kode'       => uniqid(),
            'nama'       => 'Nama Awal',
            'label'      => 1,
            'tahun'      => 2026,
            'status'     => 0,
            'tahapan_id' => $this->tahapanId(),
        ]);

        $countBefore = Inovasi::where('user_id', $user->id)->count();

        $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'id'          => $inovasi->id,
            'nama'        => 'Nama Updated',
            'kategori_id' => $this->kategoriId(),
            'tahapan_id'  => $this->tahapanId(),
        ]));

        $this->assertEquals($countBefore, Inovasi::where('user_id', $user->id)->count());
    }

    public function test_update_status_1_with_no_indikator_returns_error()
    {
        $user = $this->user();
        $inovasi = Inovasi::forceCreate([
            'user_id'    => $user->id,
            'kode'       => uniqid(),
            'nama'       => 'Test Inovasi',
            'label'      => 1,
            'tahun'      => 2026,
            'status'     => 0,
            'tahapan_id' => $this->tahapanId(),
        ]);

        $response = $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'id'     => $inovasi->id,
            'status' => 1,
        ]));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('inovasis', ['id' => $inovasi->id, 'status' => 0]);
    }

    public function test_update_status_1_with_missing_nama_returns_error()
    {
        $user = $this->user();
        $inovasi = Inovasi::forceCreate([
            'user_id'    => $user->id,
            'kode'       => uniqid(),
            'nama'       => null,
            'label'      => 1,
            'tahun'      => 2026,
            'status'     => 0,
            'tahapan_id' => $this->tahapanId(),
        ]);

        $response = $this->actingAs($user)->post(route('inovasi.save'), $this->payload([
            'id'     => $inovasi->id,
            'status' => 1,
        ]));

        $response->assertSessionHas('error');
    }

    // --- Redirect route ---

    public function test_redirects_to_masyarakat_when_label_is_1()
    {
        $response = $this->actingAs($this->user())
            ->post(route('inovasi.save'), $this->payload([
                'label'       => 1,
                'kategori_id' => $this->kategoriId(),
                'tahapan_id'  => $this->tahapanId(),
            ]));

        $response->assertRedirect(route('inovasi.index', ['area' => 'masyarakat']));
    }

    public function test_redirects_to_kota_when_label_is_not_1()
    {
        $response = $this->actingAs($this->user())
            ->post(route('inovasi.save'), $this->payload([
                'label'       => 0,
                'kategori_id' => $this->kategoriId(),
                'tahapan_id'  => $this->tahapanId(),
            ]));

        $response->assertRedirect(route('inovasi.index', ['area' => 'kota']));
    }
}
