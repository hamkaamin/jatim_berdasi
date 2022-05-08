<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTampilkanKolomColumnInTahapansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tahapans', function (Blueprint $table) {
            $table->smallInteger('tampilkan_kolom')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tahapans', function (Blueprint $table) {
            $table->dropColumn('tampilkan_kolom');
        });
    }
}
