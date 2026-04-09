<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriInovasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_inovasis')->delete();
        DB::table('kategori_inovasis')->insert(['id' => 1, 'kode'=>1, 'nama'=>'Kategori I : Inovasi Daerah', 'nama_singkat' => 'Inovasi Daerah']); 
        DB::table('kategori_inovasis')->insert(['id' => 2, 'kode'=>2, 'nama'=>'Kategori II : Inovasi Digital', 'nama_singkat' => 'Inovasi Digital']); 
        DB::table('kategori_inovasis')->insert(['id' => 3, 'kode'=>3, 'nama'=>'Kategori III : Agribis & Energi Terbarukan', 'nama_singkat' => 'Agribis & Energi Terbarukan']); 
        DB::table('kategori_inovasis')->insert(['id' => 4, 'kode'=>4, 'nama'=>'Kategori IV : Sosial Budaya', 'nama_singkat' => 'Sosial Budaya']); 
        DB::table('kategori_inovasis')->insert(['id' => 5, 'kode'=>5, 'nama'=>'Kategori V : Inovasi Milenial', 'nama_singkat' => 'Inovasi Milenial']); 
    }
}
