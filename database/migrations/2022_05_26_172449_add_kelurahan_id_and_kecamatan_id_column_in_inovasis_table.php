<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKelurahanIdAndKecamatanIdColumnInInovasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inovasis', function (Blueprint $table) {
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
        Schema::table('inovasis', function (Blueprint $table) {
            $table->dropColumn('kecamatan_id');
            $table->dropColumn('kelurahan_id');
        });
    }
}
