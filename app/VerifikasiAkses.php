<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class VerifikasiAkses extends Model
{
    protected $table = 'verifikasi_akses';
    protected $fillable = [
        'arsip_id', 'nama_pemohon', 'subbagian_pemohon', 'tujuan_akses', 
        'status', 'izin_unduh', 'diverifikasi_oleh', 'catatan_admin'
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class, 'arsip_id');
    }
}