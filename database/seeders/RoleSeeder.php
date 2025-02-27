<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert(['id' => 1, 'nama' => 'Super Admin']);
        DB::table('roles')->insert(['id' => 2, 'nama' => 'Verifikator']);
        // DB::table('roles')->insert(['id' => 3, 'nama' => 'Provinsi']);
        DB::table('roles')->insert(['id' => 4, 'nama' => 'Admin OPD Provinsi']);
        DB::table('roles')->insert(['id' => 5, 'nama' => 'Admin Kab/Kota']);
        DB::table('roles')->insert(['id' => 7, 'nama' => 'Juri']);
    }
}