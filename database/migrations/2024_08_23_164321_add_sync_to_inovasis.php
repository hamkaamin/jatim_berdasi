<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyncToInovasis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inovasis', function (Blueprint $table) {
            $table->integer('kab_inovasis_id')->nullable(); // id yang ada di tabelnya kab
            $table->integer('kab_integration_id')->nullable(); // id yang ada saat sync
        });
        Schema::table('indikator_inovasi', function (Blueprint $table) {
            $table->integer('kab_indikator_id')->nullable(); // id yang ada di tabelnya kab
            $table->integer('kab_inovasi_id')->nullable(); // id yang ada di tabelnya kab
        });
        Schema::table('uploads', function (Blueprint $table) {
            $table->integer('kab_uploads_id')->nullable(); // id yang ada di tabelnya kab 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inovasis', function (Blueprint $table) {
            //
        });
    }
}
