<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturansTable extends Migration
{
    public function up()
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi')->default('E-Arsip SIKANTI');
            $table->string('logo_aplikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaturans');
    }
}