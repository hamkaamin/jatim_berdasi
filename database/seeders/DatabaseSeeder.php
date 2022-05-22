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
        DB::table('indikator_provinsi')->where('provinsi_id', 35)->update([
            'bobot_akhir' => 10
        ]);
    }
}
