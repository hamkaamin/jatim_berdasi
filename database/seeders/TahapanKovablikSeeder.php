<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahapanKovablikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tahapan_kovabliks')->insert(['nama' => 'Tahap I : Proposal']);
        DB::table('tahapan_kovabliks')->insert(['nama' => 'Tahap II : Presentasi & Wawancara']);
    }
}
