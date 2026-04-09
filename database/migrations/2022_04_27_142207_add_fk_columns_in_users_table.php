<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('maker_id')->nullable()->constrained('users');
            $table->foreignId('opd_id')->nullable()->constrained('opds');
            $table->foreignId('province_id')->nullable()->constrained('provinces');
            $table->foreignId('regency_id')->nullable()->constrained('regencies');
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans');
            $table->foreignId('golongan_id')->nullable()->constrained('golongans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('maker_id');
            $table->dropColumn('opd_id');
            $table->dropColumn('province_id');
            $table->dropColumn('regency_id');
            $table->dropColumn('jabatan_id');
            $table->dropColumn('golongan_id');
        });
    }
}
