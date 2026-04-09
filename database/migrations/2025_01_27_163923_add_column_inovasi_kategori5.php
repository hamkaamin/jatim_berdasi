<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInovasiKategori5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inovasis', function (Blueprint $table) {
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('file_hasil_inovasi')->nullable();
            $table->text('file_kajian')->nullable();
            $table->text('file_struktur_oragnisasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}