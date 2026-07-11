<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    protected $table = 'riwayat_aktivitas';
    
    protected $fillable = [
        'user_id', 'subbag_id', 'tipe_aksi', 'deskripsi'
    ];

    // Relasi untuk mengetahui siapa yang melakukan aktivitas ini
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}