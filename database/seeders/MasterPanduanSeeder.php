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
        DB::table('master_panduans')->insert(['nama' => 'Pengajuan Inovasi','path'=>'user-manual/Pengajuan Inovasi Daerah.mp4','role'=>4]);
        DB::table('master_panduans')->insert(['nama' => 'Ganti Password','path'=>'user-manual/Ganti Password.mp4','role'=>4]);
    }
}