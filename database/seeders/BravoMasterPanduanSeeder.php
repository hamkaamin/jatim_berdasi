<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BravoMasterPanduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_panduans')->delete();
        DB::table('master_panduans')->insert(['nama' => 'Manual Book Aplikasi Bravo 2024 (Pengusul)','path'=>'user-manual/bravo/Manual Book Aplikasi Bravo 2024 (Pengusul).pdf','role'=>4]);
        DB::table('master_panduans')->insert(['nama' => 'Manual Book Aplikasi Bravo 2024 (Superadmin)','path'=>'user-manual/bravo/Manual Book Aplikasi Bravo 2024 (Superadmin).pdf','role'=>1]);DB::table('master_panduans')->insert(['nama' => 'Manual Book Aplikasi Bravo 2024 (Verifikator)','path'=>'user-manual/bravo/Manual Book Aplikasi Bravo 2024 (Verifikator).pdf','role'=>2]);
    }
}