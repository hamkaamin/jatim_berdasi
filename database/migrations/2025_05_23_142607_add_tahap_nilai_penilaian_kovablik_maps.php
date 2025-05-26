<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTahapNilaiPenilaianKovablikMaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian_kovablik_maps', function (Blueprint $table) {
            $table->integer('juri_tahap')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_kovablik_maps', function (Blueprint $table) {
            $table->dropColumn('juri_tahap');
        });
    }
}
