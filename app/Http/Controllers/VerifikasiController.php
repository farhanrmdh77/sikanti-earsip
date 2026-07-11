<?php

namespace App\Http\Controllers;

use App\VerifikasiAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['scan', 'requestAkses', 'apiCheckPegawai']);
    }

    public function index()
    {
        $subbag_id = Auth::user()->subbag_id;

        $semua_request = VerifikasiAkses::whereHas('arsip', function($q) use ($subbag_id) {
            $q->where('subbag_id', $subbag_id);
        })->latest()->get();

        $menunggu = $semua_request->where('status', 'Menunggu');
        $disetujui = $semua_request->where('status', 'Disetujui');
        $ditolak = $semua_request->where('status', 'Ditolak');

        return view('verifikasi.index', compact('menunggu', 'disetujui', 'ditolak'));
    }

    public function approve(Request $request, $id)
    {
        $verifikasi = VerifikasiAkses::findOrFail($id);
        $verifikasi->update([
            'status' => 'Disetujui',
            'izin_unduh' => $request->has('izin_unduh') ? true : false,
            'diverifikasi_oleh' => Auth::user()->name,
            'catatan_admin' => $request->catatan_admin ?? 'Akses diberikan sesuai ketentuan.'
        ]);

        // ==========================================
        // REKAM AKTIVITAS: SETUJUI AKSES
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'VERIFIKASI',
            'deskripsi' => 'Menyetujui permintaan akses dokumen dari pegawai: ' . $verifikasi->nama_pemohon
        ]);

        return redirect()->back()->with('success', 'Akses untuk ' . $verifikasi->nama_pemohon . ' berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $verifikasi = VerifikasiAkses::findOrFail($id);
        $verifikasi->update([
            'status' => 'Ditolak',
            'izin_unduh' => false,
            'diverifikasi_oleh' => Auth::user()->name,
            'catatan_admin' => $request->catatan_admin ?? 'Akses ditolak oleh Administrator.'
        ]);

        // ==========================================
        // REKAM AKTIVITAS: TOLAK AKSES
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'VERIFIKASI',
            'deskripsi' => 'Menolak atau mencabut izin akses dokumen dari: ' . $verifikasi->nama_pemohon
        ]);

        return redirect()->back()->with('success', 'Akses berhasil ditolak/dicabut.');
    }

    public function destroy($id)
    {
        $verifikasi = VerifikasiAkses::findOrFail($id);
        $verifikasi->delete();

        return redirect()->back()->with('success', 'Log verifikasi berhasil dihapus permanen.');
    }

    // ==========================================
    // FUNGSI BARU: IZIN UNDUH REAL-TIME (AJAX)
    // ==========================================
    public function allowDownload($id)
    {
        $verifikasi = VerifikasiAkses::findOrFail($id);
        
        $verifikasi->update([
            'izin_unduh' => true,
        ]);

        // Rekam aktivitas agar aksi diam-diam ini tetap tercatat oleh sistem
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'VERIFIKASI',
            'deskripsi' => 'Memberikan izin akses unduh tambahan secara langsung untuk pegawai: ' . $verifikasi->nama_pemohon
        ]);

        return response()->json(['success' => true]);
    }

    public function scan($id)
    {
        $arsip = \App\Arsip::findOrFail($id);
        $verifikasi_id = session('tiket_akses_' . $id);
        $verifikasi = null;

        if ($verifikasi_id) {
            $verifikasi = \App\VerifikasiAkses::find($verifikasi_id);
        }

        return view('verifikasi.scan', compact('arsip', 'verifikasi'));
    }

    public function requestAkses(Request $request, $id)
    {
        $request->validate([
            'nama_pemohon' => 'required|string',
            'subbagian_pemohon' => 'required|string',
            'tujuan_akses' => 'required|string',
        ]);

        $verifikasi = \App\VerifikasiAkses::create([
            'arsip_id' => $id,
            'nama_pemohon' => $request->nama_pemohon,
            'subbagian_pemohon' => $request->subbagian_pemohon,
            'tujuan_akses' => $request->tujuan_akses,
            'status' => 'Menunggu',
            'izin_unduh' => false,
        ]);

        session(['tiket_akses_' . $id => $verifikasi->id]);

        return redirect()->route('scan.arsip', $id);
    }

    public function apiCheckAdmin()
    {
        $subbag_id = Auth::user()->subbag_id;
        
        $pending_requests = \App\VerifikasiAkses::whereHas('arsip', function($q) use ($subbag_id) {
            $q->where('subbag_id', $subbag_id);
        })->where('status', 'Menunggu')->orderBy('id', 'desc')->get();

        $latest = $pending_requests->first();
        $count = $pending_requests->count(); 

        return response()->json([
            'has_new' => $latest ? true : false,
            'latest_id' => $latest ? $latest->id : 0,
            'nama' => $latest ? $latest->nama_pemohon : '',
            'jumlah_pending' => $count 
        ]);
    }

    public function apiCheckPegawai($verifikasi_id)
    {
        $verifikasi = \App\VerifikasiAkses::find($verifikasi_id);
        if (!$verifikasi) {
            return response()->json(['status' => 'Dihapus']);
        }
        return response()->json(['status' => $verifikasi->status, 'izin_unduh' => $verifikasi->izin_unduh]);
    }
}