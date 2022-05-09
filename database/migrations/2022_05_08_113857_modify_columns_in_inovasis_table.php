<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInInovasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inovasis', function (Blueprint $table) {
            $table->bigInteger('inisiator_id')->nullable()->change();
            $table->bigInteger('jenis_id')->nullable()->change();
            $table->bigInteger('bentuk_id')->nullable()->change();
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
            $table->bigInteger('inisiator_id')->change();
            $table->bigInteger('jenis_id')->change();
            $table->bigInteger('bentuk_id')->change();
        });
    }
}
