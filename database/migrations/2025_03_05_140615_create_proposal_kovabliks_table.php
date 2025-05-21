<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalKovabliksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('proposal_kovabliks', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kode')->nullable();
        //     $table->string('judul')->nullable();
        //     $table->text('link_standart')->nullable();
        //     $table->text('link_maklumat')->nullable();
        //     $table->text('link_sk_pengaduan')->nullable();
        //     $table->string('instansi')->nullable();
        //     $table->date('tanggal_mulai')->nullable();
        //     $table->string('nama_inovator')->nullable();
        //     $table->string('no_telpon_inovator')->nullable();
        //     $table->string('email_inovator')->nullable();

        //     $table->text('ringkasan')->nullable();
        //     $table->text('latar_belakang')->nullable();
        //     $table->text('nilai_tambah')->nullable();
        //     $table->text('implementasi')->nullable();
        //     $table->text('signifikansi')->nullable();
        //     $table->text('adaptabilitas')->nullable();
        //     $table->text('sumber_daya')->nullable();
        //     $table->text('strategi_keberlanjutan')->nullable();
            
        //     $table->smallInteger('label')->nullable()->default(0);
        //     $table->integer('tahun')->nullable();
        //     $table->smallInteger('status')->nullable()->default(0);
        //     $table->text('keterangan')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreignId('tahapan_id')->nullable()->default(1)->constrained('tahapan_kovabliks');
        //     $table->foreignId('kategori_id')->nullable()->constrained('kategori_kovabliks');
        //     $table->foreignId('kelompok_id')->nullable()->constrained('kelompok_kovabliks');
        //     $table->foreignId('user_id')->constrained('users');
        //     $table->foreignId('kota_id')->nullable()->constrained('regencies');
        //     $table->foreignId('kecamatan_id')->nullable()->constrained('districts');
        //     $table->foreignId('kelurahan_id')->nullable()->constrained('villages');
        //     $table->foreignId('provinsi_id')->nullable()->constrained('provinces');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_kovabliks');
    }
}