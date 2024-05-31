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
        DB::table('master_panduans')->insert(['nama' => 'Manual Book Aplikasi Jatim Berdasi 2024 (Pengusul)','path'=>'user-manual/jatim-berdasi/Manual Book Aplikasi Jatim Berdasi 2024 (Pengusul).pdf','role'=>5]);
        DB::table('master_panduans')->insert(['nama' => 'Manual Book Aplikasi Jatim Berdasi 2024 (Verifikator)','path'=>'user-manual/jatim-berdasi/Manual Book Aplikasi Jatim Berdasi 2024 (Verifikator).pdf','role'=>2]);DB::table('master_panduans')->insert(['nama' => 'Manual Book Aplikasi Jatim Berdasi 2024 (Superadmin)','path'=>'user-manual/jatim-berdasi/Manual Book Aplikasi Jatim Berdasi 2024 (Superadmin).pdf','role'=>1]);
    }
}