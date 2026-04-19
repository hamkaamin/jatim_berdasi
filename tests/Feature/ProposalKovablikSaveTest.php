<?php

namespace Tests\Feature;

use App\Models\Provinsi;
use App\Models\ProposalKovablik;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProposalKovablikSaveTest extends TestCase
{
    use DatabaseTransactions;

    private static array $uploadDirs = [
        'file_standart_pelayanan',
        'file_maklumat_pelayanan',
        'file_sk_pengelolaan_pengaduan',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        foreach (self::$uploadDirs as $dir) {
            $path = public_path($dir);
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }
    }

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

    private function fakeDoc(string $name = 'doc.png'): UploadedFile
    {
        return UploadedFile::fake()->image($name, 1, 1);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'id'                         => 0,
            'label'                      => 2,
            'nama'                       => 'Inovasi Kovablik Test',
            'kategori_kovablik_id'       => null,
            'kelompok_id'                => null,
            'kov_instansi_asal'          => 'Dinas Kominfo Test',
            'kov_jenis_inovasi'          => 'Digital',
            'tanggal_mulai'              => '2026-01-01',
            'nama_inovator'              => 'Budi Santoso',
            'kov_nip_inovator'           => '198501012010011001',
            'no_telpon_inovator'         => '081234567890',
            'kov_nomor_iga'              => 'IGA-2026-001',
            'kov_link_video'             => 'https://youtube.com/test',
            'kov_keterangan_video'       => 'Video demo inovasi',
            'kov_sektor_pemerintahan_id' => null,
            'kov_asta_cita_id'           => null,
            'email_inovator'             => 'budi@test.com',
            'ringkasan'                  => 'Ringkasan singkat inovasi test',
            'kov_koordinat'              => '-7.123,112.456',
            'kov_latar_belakang'         => 'Latar belakang inovasi kovablik',
            'kov_tujuan'                 => 'Tujuan inovasi kovablik',
            'kov_cara_kerja'             => 'Cara kerja inovasi kovablik',
            'kov_keunggulan'             => 'Keunggulan inovasi kovablik',
            'kov_mekanisme'              => 'Mekanisme monitoring inovasi',
            'kov_dampak'                 => 'Dampak inovasi kovablik',
            'kov_difusi'                 => 'Potensi replikasi inovasi',
            'kov_sumber_daya'            => 'Sumber daya inovasi',
            'kov_strategi'               => 'Strategi keberlanjutan',
            'implementasi_inovasi'       => 'Deskripsi implementasi',
            'signifikansi'               => 'Signifikansi inovasi',
            'adaptabilitas'              => 'Adaptabilitas inovasi',
            'status'                     => 0,
        ], $overrides);
    }

    private function payloadWithFiles(array $overrides = []): array
    {
        return array_merge($this->payload(), [
            'dokumen_standart_pelayanan'      => $this->fakeDoc('standart.png'),
            'dokumen_maklumat_pelayanan'      => $this->fakeDoc('maklumat.png'),
            'dokumen_sk_pengelolaan_pengaduan' => $this->fakeDoc('sk.png'),
        ], $overrides);
    }

    // --- Auth ---

    public function test_unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->post(route('kovablik.save'), $this->payload());

        $response->assertRedirect('/login');
    }

    // --- Validation ---

    public function test_missing_latar_belakang_fails_validation()
    {
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payload(['kov_latar_belakang' => '']));

        $response->assertSessionHasErrors('kov_latar_belakang');
    }

    public function test_missing_tujuan_fails_validation()
    {
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payload(['kov_tujuan' => '']));

        $response->assertSessionHasErrors('kov_tujuan');
    }

    public function test_missing_cara_kerja_fails_validation()
    {
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payload(['kov_cara_kerja' => '']));

        $response->assertSessionHasErrors('kov_cara_kerja');
    }

    public function test_missing_strategi_fails_validation()
    {
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payload(['kov_strategi' => '']));

        $response->assertSessionHasErrors('kov_strategi');
    }

    // --- Validasi dokumen (form lama vs form baru) ---

    public function test_old_form_requires_standard_documents_when_creating()
    {
        // Tanpa form_type = 'new', ketiga dokumen wajib ada
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payload());

        $response->assertSessionHasErrors([
            'dokumen_standart_pelayanan',
            'dokumen_maklumat_pelayanan',
            'dokumen_sk_pengelolaan_pengaduan',
        ]);
    }

    public function test_new_form_type_allows_create_without_standard_documents()
    {
        // form_type = 'new' → ketiga dokumen tidak wajib
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payload(['form_type' => 'new']));

        $response->assertSessionMissing('errors');
        $response->assertSessionHas('success');
    }

    // --- Create (id = 0) ---

    public function test_creates_new_proposal_kovablik_and_redirects()
    {
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payloadWithFiles());

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_create_persists_basic_fields_to_database()
    {
        $user = $this->user();

        $this->actingAs($user)->post(route('kovablik.save'), $this->payloadWithFiles([
            'nama'              => 'Inovasi Kovablik Spesifik',
            'kov_instansi_asal' => 'Bappeda Jatim',
            'nama_inovator'     => 'Siti Rahayu',
        ]));

        $this->assertDatabaseHas('proposal_kovabliks', [
            'judul'         => 'Inovasi Kovablik Spesifik',
            'instansi'      => 'Bappeda Jatim',
            'nama_inovator' => 'Siti Rahayu',
            'user_id'       => $user->id,
        ]);
    }

    public function test_create_persists_narasi_fields_correctly()
    {
        $user = $this->user();

        $this->actingAs($user)->post(route('kovablik.save'), $this->payloadWithFiles([
            'kov_latar_belakang' => 'Latar belakang spesifik A',
            'kov_tujuan'         => 'Tujuan spesifik B',
            'kov_cara_kerja'     => 'Cara kerja spesifik C',
            'kov_keunggulan'     => 'Keunggulan spesifik D',
            'kov_dampak'         => 'Dampak spesifik E',
            'kov_difusi'         => 'Difusi spesifik F',
            'kov_sumber_daya'    => 'Sumber daya spesifik G',
            'kov_strategi'       => 'Strategi spesifik H',
        ]));

        $this->assertDatabaseHas('proposal_kovabliks', [
            'latar_belakang'         => 'Latar belakang spesifik A',
            'tujuan_outcome'         => 'Tujuan spesifik B',
            'cara_kerja'             => 'Cara kerja spesifik C',
            'kebaharuan'             => 'Keunggulan spesifik D',
            'bentuk_dampak'          => 'Dampak spesifik E',
            'potensi_replikasi'      => 'Difusi spesifik F',
            'sumber_daya'            => 'Sumber daya spesifik G',
            'strategi_keberlanjutan' => 'Strategi spesifik H',
        ]);
    }

    public function test_create_auto_assigns_user_id_and_kode()
    {
        $user = $this->user();

        $this->actingAs($user)->post(route('kovablik.save'), $this->payloadWithFiles());

        $proposal = ProposalKovablik::where('user_id', $user->id)->latest('id')->first();
        $this->assertNotNull($proposal);
        $this->assertNotEmpty($proposal->kode);
    }

    public function test_create_sets_provinsi_id_for_role_3_user()
    {
        $user = $this->userWithProvince();

        $this->actingAs($user)->post(route('kovablik.save'), $this->payloadWithFiles());

        $this->assertDatabaseHas('proposal_kovabliks', [
            'user_id'     => $user->id,
            'provinsi_id' => $user->province_id,
        ]);
    }

    // --- Update (id != 0) ---

    public function test_updates_existing_proposal_kovablik()
    {
        $user = $this->user();
        $proposal = ProposalKovablik::forceCreate([
            'user_id' => $user->id,
            'kode'    => uniqid(),
            'judul'   => 'Judul Lama',
            'label'   => 2,
            'tahun'   => 2026,
            'status'  => 0,
        ]);

        $response = $this->actingAs($user)->post(route('kovablik.save'), $this->payload([
            'id'   => $proposal->id,
            'nama' => 'Judul Baru',
        ]));

        $response->assertRedirect();
        $this->assertDatabaseHas('proposal_kovabliks', [
            'id'    => $proposal->id,
            'judul' => 'Judul Baru',
        ]);
    }

    public function test_update_does_not_create_duplicate_record()
    {
        $user = $this->user();
        $proposal = ProposalKovablik::forceCreate([
            'user_id' => $user->id,
            'kode'    => uniqid(),
            'judul'   => 'Judul Awal',
            'label'   => 2,
            'tahun'   => 2026,
            'status'  => 0,
        ]);

        $countBefore = ProposalKovablik::where('user_id', $user->id)->count();

        $this->actingAs($user)->post(route('kovablik.save'), $this->payload([
            'id'   => $proposal->id,
            'nama' => 'Judul Updated',
        ]));

        $this->assertEquals($countBefore, ProposalKovablik::where('user_id', $user->id)->count());
    }

    // --- Redirect route ---

    public function test_redirects_to_masyarakat_when_label_is_2()
    {
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payloadWithFiles(['label' => 2]));

        $response->assertRedirect(route('kovablik.index', ['area' => 'masyarakat']));
    }

    public function test_redirects_to_kota_when_label_is_not_2()
    {
        $response = $this->actingAs($this->user())
            ->post(route('kovablik.save'), $this->payloadWithFiles(['label' => 0]));

        $response->assertRedirect(route('kovablik.index', ['area' => 'kota']));
    }
}
