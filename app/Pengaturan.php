<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';
    // Tambahkan sub_judul di sini
    protected $fillable = ['nama_aplikasi', 'sub_judul', 'logo_aplikasi']; 
}