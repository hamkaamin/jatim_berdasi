<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opds', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('logo')->nullable();
            $table->string('fax')->nullable();
            $table->string('telp')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('provinsi_id')->nullable()->constrained('provinces');
            $table->foreignId('kabkota_id')->nullable()->constrained('regencies');
            $table->foreignId('kecamatan_id')->nullable()->constrained('districts');
            $table->foreignId('kelurahan_id')->nullable()->constrained('villages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opds');
    }
}
