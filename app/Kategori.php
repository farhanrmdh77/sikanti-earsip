<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;
    protected $fillable = ['subbag_id', 'nama_kategori', 'deskripsi'];

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'kategori_id', 'id');
    }

    public function subbagian()
    {
        return $this->belongsTo(Subbagian::class, 'subbag_id', 'id');
    }
}