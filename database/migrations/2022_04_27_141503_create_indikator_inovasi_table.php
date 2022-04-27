<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndikatorInovasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indikator_inovasi', function (Blueprint $table) {
            $table->foreignId('indikator_id')->constrained('indikators');
            $table->foreignId('inovasi_id')->constrained('inovasis');
            $table->string('param_awal')->nullable();
            $table->string('param_akhir')->nullable();
            $table->double('bobot_awal')->nullable();
            $table->double('bobot_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indikator_inovasi');
    }
}
