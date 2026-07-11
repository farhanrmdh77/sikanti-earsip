<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subbag_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('user_id');
            
            $table->string('nomor_dokumen'); // Kode Klasifikasi
            $table->string('nama_arsip'); // Nama Berkas
            $table->string('tahun_berkas')->nullable();
            $table->integer('jumlah_berkas')->default(1);
            $table->string('retensi_aktif')->nullable();
            $table->string('retensi_inaktif')->nullable();
            $table->enum('nasib_akhir', ['Musnah', 'Permanen'])->nullable();
            $table->enum('lokasi_fisik', ['Internal Subbagian', 'Diserahkan ke Umum'])->nullable();
            $table->string('warna_berkas')->nullable();
            
            $table->text('keterangan')->nullable(); // Deskripsi
            $table->string('file_dokumen')->nullable(); // Opsional
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subbag_id')->references('id')->on('subbagians')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arsips');
    }
}
