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
        DB::table('master_panduans')->insert(['nama' => 'Pengajuan Inovasi','path'=>'user-manual/Pengajuan Inovasi Daerah.mp4','role'=>4]);
        DB::table('master_panduans')->insert(['nama' => 'Dashboard','path'=>'user-manual/1. Dashboard.mp4','role'=>5]);DB::table('master_panduans')->insert(['nama' => 'Menu Inovasi Daerah (Provinsi)','path'=>'user-manual/2. Menu Inovasi Daerah (Provinsi).mp4','role'=>5]);
    }
}