<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSistemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
        DB::table('settings')->insert(['id' => 1, 'kode'=>'bobot_akhir','nama' => 'Bobot Akhir','is_aktif'=>1]);
        DB::table('settings')->insert(['id' => 2, 'kode'=>'tambah_inovasi','nama' => 'Tombol Tambah Inovasi','is_aktif'=>1]);
    }
}