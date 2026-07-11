<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatAktivitasTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Siapa pelakunya
            $table->unsignedBigInteger('subbag_id'); // Dari sektor mana
            $table->string('tipe_aksi'); // Contoh: CREATE, UPDATE, DELETE, VERIFIKASI
            $table->text('deskripsi'); // Detail: "Menambahkan dokumen SPPD..."
            $table->timestamps(); // Kapan waktu kejadiannya (otomatis)
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_aktivitas');
    }
}