<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubbagIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom foreign key setelah kolom id
            $table->unsignedBigInteger('subbag_id')->nullable()->after('id');
            
            // Relasi ke tabel subbagians
            $table->foreign('subbag_id')->references('id')->on('subbagians')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['subbag_id']);
            $table->dropColumn('subbag_id');
        });
    }
}
