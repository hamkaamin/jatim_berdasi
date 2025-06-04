<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKovablikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_kovabliks')->insert(['nama' => 'Kesehatan']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Pertumbuhan Ekonomi dan Kesempatan Kerja']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Ketahanan Pangan']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Inklusi Sosial']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Tata Kelola Pemerintahan']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Ketahanan Bencana']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Pendidikan']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Pengentasan Kemiskinan']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Pemberdayaan Masyarakat']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Energi dan Lingkungan Hidup']);
        DB::table('kategori_kovabliks')->insert(['nama' => 'Penegakan Hukum']);
    }
}
