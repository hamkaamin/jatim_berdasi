<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'nama'=>'BRIDA Provinsi Jawa Timur',
            'alamat' =>'Jl. Gayung Kebonsari No.56, Gayungan, Kec. Gayungan, Surabaya, Jawa Timur 60235',
            'no_telp' => '(031) 8290719',
            'email' => 'brida@jatimprov.go.id.',
            'fax' => '(031) 8290719',
            'instagram' => 'briprovjatim',
            'facebook' => 'briprovjatim',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}