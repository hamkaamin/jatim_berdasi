<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(RoleSeeder::class);
        // $this->call(KategoriInovasiSeeder::class);
        // $this->call(MasterPanduanSeeder::class);
        // DB::table('indikator_provinsi')->where('provinsi_id', 35)->update([
        //     'bobot_akhir' => 10
        // ]);
        // $this->call(KategoriKovablikSeeder::class);
        // $this->call(KelompokKovablikSeeder::class);
        // $this->call(TahapanKovablikSeeder::class);
        $this->call(KategoriNilaiKovablikSeeder::class);
    }
}
