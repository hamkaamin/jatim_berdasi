<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnTahapanPenilaianMaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian_kovabliks', function (Blueprint $table) {
            $table->dropColumn('tahapan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_kovabliks', function (Blueprint $table) {
            $table->integer('tahapan_id');
        });
    }
}
