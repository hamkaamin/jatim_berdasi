<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianKovablikMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_kovablik_maps', function (Blueprint $table) {
            $table->id();
            $table->integer('proposal_id');
            $table->integer('juri_id');
            $table->integer('tahapan_id');
            $table->double('total_nilai');
            $table->text('signature_path')->nullable();
            $table->enum('is_lolos', [0, 1])->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('penilaian_kovablik_maps');
    }
}
