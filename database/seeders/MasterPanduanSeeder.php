<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterPanduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_panduans')->delete();
        DB::table('master_panduans')->insert(['nama' => '1. Menu Dashboard','path'=>'user-manual/jatim-berdasi/1. Menu Dashboard.mp4','role'=>5]);
        DB::table('master_panduans')->insert(['nama' => '2. Setting Tahun','path'=>'user-manual/jatim-berdasi/2. Setting Tahun.mp4','role'=>5]);
        DB::table('master_panduans')->insert(['nama' => '3. Ganti Password','path'=>'user-manual/jatim-berdasi/3. Ganti Password.mp4','role'=>5]);
        DB::table('master_panduans')->insert(['nama' => '4. Cara Melakukan Usulan_Pengajuan Inovasi','path'=>'user-manual/jatim-berdasi/4. Cara Melakukan Usulan_Pengajuan Inovasi.mp4','role'=>5]);
        DB::table('master_panduans')->insert(['nama' => '5. Cara Melakukan Verifikasi Usulan_Pengajuan Inovasi (Verifikator)','path'=>'user-manual/jatim-berdasi/5. Cara Melakukan Verifikasi Usulan_Pengajuan Inovasi (Verifikator).mp4','role'=>5]);
        DB::table('master_panduans')->insert(['nama' => '6. Cara Melakukan Penilaian Usulan_Pengajuan Inovasi (Juri)','path'=>'user-manual/jatim-berdasi/6. Cara Melakukan Penilaian Usulan_Pengajuan Inovasi (Juri).mp4','role'=>5]);
    }
}