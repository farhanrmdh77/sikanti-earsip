<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subbag_id'); // Isolasi folder per subbagian
            $table->string('nama_kategori'); // Nama folder
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            // Relasi
            $table->foreign('subbag_id')->references('id')->on('subbagians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategoris');
    }
}
