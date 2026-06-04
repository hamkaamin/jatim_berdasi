<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNilaiJuriTahapInInovasisTableAndProposalKovabliksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inovasis', function (Blueprint $table) {
            $table->integer('nilai_juri_tahap_show')->default(0)->after('juri_tahap');
        });

        Schema::table('proposal_kovabliks', function (Blueprint $table) {
            $table->integer('nilai_juri_tahap_show')->default(0)->after('juri_tahap');
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
            $table->dropColumn('nilai_juri_tahap_show');
        });

        Schema::table('proposal_kovabliks', function (Blueprint $table) {
            $table->dropColumn('nilai_juri_tahap_show');
        });
    }
}
