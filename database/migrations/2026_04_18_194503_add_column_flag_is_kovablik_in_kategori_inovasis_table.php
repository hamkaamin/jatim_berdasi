<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFlagIsKovablikInKategoriInovasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kategori_inovasis', function (Blueprint $table) {
            $table->boolean('is_kovablik')->after('is_aktif')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kategori_inovasis', function (Blueprint $table) {
            $table->dropColumn('is_kovablik');
        });
    }
}
