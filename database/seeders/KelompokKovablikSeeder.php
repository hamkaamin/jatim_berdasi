<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokKovablikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kelompok_kovabliks')->insert(['nama' => 'Umum']);
        DB::table('kelompok_kovabliks')->insert(['nama' => 'Khusus']);
        DB::table('kelompok_kovabliks')->insert(['nama' => 'Replikasi']);
    }
}
