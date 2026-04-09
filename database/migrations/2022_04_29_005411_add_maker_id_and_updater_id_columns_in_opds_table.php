<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMakerIdAndUpdaterIdColumnsInOpdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->foreignId('maker_id')->nullable()->constrained('users');
            $table->foreignId('updater_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn('maker_id');
            $table->dropColumn('updater_id');
        });
    }
}
