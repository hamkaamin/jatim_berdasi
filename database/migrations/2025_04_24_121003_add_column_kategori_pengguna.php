<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKategoriPengguna extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_kategori_1')->default(1)->nullable();
            $table->integer('is_kategori_2')->default(1)->nullable();
            $table->integer('is_kategori_3')->default(1)->nullable();
            $table->integer('is_kategori_4')->default(1)->nullable();
            $table->integer('is_kategori_5')->default(1)->nullable();
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