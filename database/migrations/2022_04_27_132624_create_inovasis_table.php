<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInovasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inovasis', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->string('nama')->nullable();
            $table->smallInteger('covid')->nullable()->default(0);
            $table->text('rancang_bangun')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('manfaat')->nullable();
            $table->text('hasil')->nullable();
            $table->string('anggaran')->nullable();
            $table->string('profil_bisnis')->nullable();
            $table->smallInteger('status')->nullable()->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tahapan_id')->constrained('tahapans');
            $table->foreignId('inisiator_id')->constrained('inisiators');
            $table->foreignId('jenis_id')->constrained('jeniss');
            $table->foreignId('bentuk_id')->constrained('bentuks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inovasis');
    }
}
