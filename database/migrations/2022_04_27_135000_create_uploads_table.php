<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->dateTime('tgl_dokumen')->nullable();
            $table->text('tentang')->nullable();
            $table->string('url')->nullable();
            $table->string('cover')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->foreignId('indikator_id')->constrained('indikators');
            $table->foreignId('inovasi_id')->constrained('inovasis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
    }
}
