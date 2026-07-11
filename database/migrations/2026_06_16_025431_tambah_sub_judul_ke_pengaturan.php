<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahSubJudulKePengaturan extends Migration
{
    public function up()
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            // Mengecek agar tidak terjadi error duplicate
            if (!Schema::hasColumn('pengaturans', 'sub_judul')) {
                $table->string('sub_judul')->default('SISTEM INFORMASI KEARSIPAN')->after('nama_aplikasi');
            }
        });
    }

    public function down()
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            if (Schema::hasColumn('pengaturans', 'sub_judul')) {
                $table->dropColumn('sub_judul');
            }
        });
    }
}   