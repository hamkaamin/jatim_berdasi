<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndikatorProvinsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indikator_provinsi', function (Blueprint $table) {
            $table->foreignId('indikator_id')->constrained('indikators');
            $table->foreignId('provinsi_id')->constrained('provinces');
            $table->string('param_akhir')->nullable();
            $table->double('bobot_akhir')->nullable();
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indikator_provinsi');
    }
}