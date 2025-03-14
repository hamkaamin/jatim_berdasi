<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriNilaiKovabliksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_nilai_kovabliks', function (Blueprint $table) {
            $table->id();
            $table->text('bagian')->nullable();
            $table->text('indikator')->nullable();
            $table->integer('nilai_min')->default(0)->nullable();
            $table->integer('nilai_max')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori_nilai_kovabliks');
    }
}
