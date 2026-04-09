<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TematikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tematiks')->delete();
        $tematiks = [
            [
                'id' => 1,
                'nama' => 'Digitalisasi Layanan Pemerintah',
            ],
            [
                'id' => 2,
                'nama' => 'Penanggulangan Kemiskinan',
            ],
            [
                'id' => 3,
                'nama' => 'Kemudahan Investasi',
            ],
            [
                'id' => 4,
                'nama' => 'Prioritas Aktual Presiden',
            ],
            [
                'id' => 5,
                'nama' => 'Non Tematik',
            ],
        ];

        // Insert the data into the 'tematiks' table
        DB::table('tematiks')->insert($tematiks);

    }
}