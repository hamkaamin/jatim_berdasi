<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBobotNilaiToPenilaians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->integer('bobot_nilai')->default(100)->nullable()->after('nilai_max');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn('bobot_nilai');
        });
    }
}
