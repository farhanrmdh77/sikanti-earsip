<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahRoleKeTabelUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Memastikan kolom belum ada sebelum ditambahkan untuk mencegah error ganda
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('Staff')->after('password');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
}