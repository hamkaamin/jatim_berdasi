<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillIsAktifKategoriInovasis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('kategori_inovasis')->whereNull('is_aktif')->update(['is_aktif' => 1]);

        Schema::table('kategori_inovasis', function (Blueprint $table) {
            $table->integer('is_aktif')->default(1)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kategori_inovasis', function (Blueprint $table) {
            $table->integer('is_aktif')->default(0)->nullable()->change();
        });
    }
}
