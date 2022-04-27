<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahapanInovasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapan_inovasi', function (Blueprint $table) {
            $table->foreignId('tahapan_id')->constrained('tahapans');
            $table->foreignId('inovasi_id')->constrained('inovasis');
            $table->dateTime('waktu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tahapan_inovasi');
    }
}
