<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianKovabliksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_kovabliks', function (Blueprint $table) {
            $table->integer('penilaian_id');
            $table->integer('proposal_id');
            $table->string('catatan_saran')->nullable();
            $table->double('nilai')->default(0)->nullable();
            $table->integer('user_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian_kovabliks');
    }
}
