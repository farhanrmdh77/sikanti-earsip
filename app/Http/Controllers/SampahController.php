<?php

namespace App\Http\Controllers;

use App\Arsip;
use App\Kategori; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subbag_id = Auth::user()->subbag_id;
        
        $arsip_sampah = Arsip::onlyTrashed()
                             ->where('subbag_id', $subbag_id)
                             ->latest('deleted_at')
                             ->get();
                             
        $kategori_sampah = Kategori::onlyTrashed()
                                   ->where('subbag_id', $subbag_id)
                                   ->latest('deleted_at')
                                   ->get();

        return view('sampah.index', compact('arsip_sampah', 'kategori_sampah'));
    }

    public function restoreKategori($id)
    {
        $kategori = Kategori::onlyTrashed()->where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        $kategori->restore();

        // ==========================================
        // REKAM AKTIVITAS: PULIHKAN FOLDER
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'UPDATE',
            'deskripsi' => 'Memulihkan folder klasifikasi dari keranjang sampah: ' . $kategori->nama_kategori
        ]);

        return redirect()->back()->with('success', 'Folder klasifikasi berhasil dipulihkan ke Gudang Folder.');
    }

    public function restoreArsip($id)
    {
        $arsip = Arsip::onlyTrashed()->where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        
        if ($arsip->kategori && $arsip->kategori->trashed()) {
            $arsip->kategori->restore();
        }
        
        $arsip->restore();

        // ==========================================
        // REKAM AKTIVITAS: PULIHKAN DOKUMEN
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'UPDATE',
            'deskripsi' => 'Memulihkan dokumen arsip dari keranjang sampah: ' . $arsip->nama_arsip
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil dipulihkan kembali ke Gudang Folder.');
    }

    public function forceDeleteArsip($id)
    {
        $arsip = Arsip::onlyTrashed()->where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        $nama_arsip = $arsip->nama_arsip;
        
        if ($arsip->file_dokumen && \Storage::exists('public/arsip_dokumen/' . $arsip->file_dokumen)) {
            \Storage::delete('public/arsip_dokumen/' . $arsip->file_dokumen);
        }
        
        $arsip->forceDelete(); 

        // ==========================================
        // REKAM AKTIVITAS: PEMUSNAHAN DOKUMEN
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'DELETE',
            'deskripsi' => 'MEMUSNAHKAN DOKUMEN SECARA PERMANEN: ' . $nama_arsip
        ]);

        return redirect()->back()->with('success', 'Dokumen beserta file lampirannya telah dimusnahkan secara permanen.');
    }

    public function forceDeleteKategori($id)
    {
        $kategori = Kategori::onlyTrashed()->where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        $nama_kategori = $kategori->nama_kategori;
        
        $arsips = Arsip::withTrashed()->where('kategori_id', $kategori->id)->get();
        foreach($arsips as $arsip) {
            if ($arsip->file_dokumen && \Storage::exists('public/arsip_dokumen/' . $arsip->file_dokumen)) {
                \Storage::delete('public/arsip_dokumen/' . $arsip->file_dokumen);
            }
            $arsip->forceDelete();
        }

        $kategori->forceDelete(); 

        // ==========================================
        // REKAM AKTIVITAS: PEMUSNAHAN FOLDER
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'DELETE',
            'deskripsi' => 'MEMUSNAHKAN FOLDER SECARA PERMANEN beserta seluruh isinya: ' . $nama_kategori
        ]);

        return redirect()->back()->with('success', 'Folder beserta seluruh dokumen di dalamnya telah dimusnahkan secara permanen.');
    }
}