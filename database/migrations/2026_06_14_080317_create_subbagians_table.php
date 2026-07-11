<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubbagiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subbagians', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nama_subbag'); // Contoh: SDM, Keuangan, Hukum
            $table->string('kode_klasifikasi'); // Contoh: KP, KU, HK
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
        Schema::dropIfExists('subbagians');
    }
}
