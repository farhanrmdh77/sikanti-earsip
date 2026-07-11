<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifikasiAksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifikasi_akses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->constrained('arsips')->onDelete('cascade');
            $table->string('nama_pemohon');
            $table->string('subbagian_pemohon');
            $table->text('tujuan_akses');
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->boolean('izin_unduh')->default(false);
            $table->string('diverifikasi_oleh')->nullable(); // Nama admin yang ACC
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verifikasi_akses');
    }
}
