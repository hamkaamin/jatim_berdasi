<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiabangMasterPanduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_panduans')->delete();

        DB::table('master_panduans')->insert([
            [
                'nama' => '1. Manual Book_Superadmin_Siabang.pdf',
                'role' => 1,
                'path' => 'user-manual/siabang/Manual Book_Superadmin_Siabang.pdf'
            ]
        ]);
        DB::table('master_panduans')->insert([
            [
                'nama' => '1. Ubah Password (Verifikator).mp4',
                'role' => 2,
                'path' => 'user-manual/siabang/1. Panduan User Verifikator/1. Ubah Password (Verifikator).mp4'
            ],
            [
                'nama' => '2. Dashboard (Verifikator).mp4',
                'role' => 2,
                'path' => 'user-manual/siabang/1. Panduan User Verifikator/2. Dashboard (Verifikator).mp4'
            ],
            [
                'nama' => '3. Menu Inovasi Daerah (Verifikator).mp4',
                'role' => 2,
                'path' => 'user-manual/siabang/1. Panduan User Verifikator/3. Menu Inovasi Daerah (Verifikator).mp4'
            ],
            [
                'nama' => '4. Menu Inotek Award SIABANG (Verifikator).mp4',
                'role' => 2,
                'path' => 'user-manual/siabang/1. Panduan User Verifikator/4. Menu Inotek Award SIABANG (Verifikator).mp4'
            ],
            [
                'nama' => '5. Menu Bank Data (Verifikator).mp4',
                'role' => 2,
                'path' => 'user-manual/siabang/1. Panduan User Verifikator/5. Menu Bank Data (Verifikator).mp4'
            ],
            [
                'nama' => '6. Menu Panduan (Verifikator).mp4',
                'role' => 2,
                'path' => 'user-manual/siabang/1. Panduan User Verifikator/6. Menu Panduan (Verifikator).mp4'
            ]
        ]);

        DB::table('master_panduans')->insert([
            [
                'nama' => '1. Ubah Password (Pengusul).mp4',
                'role' => 4,
                'path' => 'user-manual/siabang/2. Panduan User Pengusul/1. Ubah Password (Pengusul).mp4'
            ],
            [
                'nama' => '2. Dashboard (Pengusul).mp4',
                'role' => 4,
                'path' => 'user-manual/siabang/2. Panduan User Pengusul/2. Dashboard (Pengusul).mp4'
            ],
            [
                'nama' => '3. Menu Inovasi Daerah (Pengusul).mp4',
                'role' => 4,
                'path' => 'user-manual/siabang/2. Panduan User Pengusul/3. Menu Inovasi Daerah (Pengusul).mp4'
            ],
            [
                'nama' => '4. Menu Inotek Award SIABANG (Pengusul).mp4',
                'role' => 4,
                'path' => 'user-manual/siabang/2. Panduan User Pengusul/4. Menu Inotek Award SIABANG (Pengusul).mp4'
            ],
            [
                'nama' => '5. Menu Bank Data (Pengusul).mp4',
                'role' => 4,
                'path' => 'user-manual/siabang/2. Panduan User Pengusul/5. Menu Bank Data (Pengusul).mp4'
            ],
            [
                'nama' => '6. Menu Panduan (Pengusul).mp4',
                'role' => 4,
                'path' => 'user-manual/siabang/2. Panduan User Pengusul/6. Menu Panduan (Pengusul).mp4'
            ]
        ]);
    }
}