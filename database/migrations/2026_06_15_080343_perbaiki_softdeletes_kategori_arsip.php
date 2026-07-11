<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PerbaikiSoftdeletesKategoriArsip extends Migration
{
    public function up()
    {
        Schema::table('kategoris', function (Blueprint $table) {
            if (!Schema::hasColumn('kategoris', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('arsips', function (Blueprint $table) {
            if (!Schema::hasColumn('arsips', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down()
    {
        Schema::table('kategoris', function (Blueprint $table) {
            if (Schema::hasColumn('kategoris', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('arsips', function (Blueprint $table) {
            if (Schema::hasColumn('arsips', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
}