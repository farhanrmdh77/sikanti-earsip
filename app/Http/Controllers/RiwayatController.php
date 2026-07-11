<?php

namespace App\Http\Controllers;

use App\RiwayatAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $subbag_id = Auth::user()->subbag_id;

        // Ambil riwayat khusus subbagian yang login, urutkan dari yang terbaru
        $query = RiwayatAktivitas::with('user')
                    ->where('subbag_id', $subbag_id)
                    ->latest();

        // Fitur Pencarian Kata Kunci
        if ($request->filled('search')) {
            $query->where('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        // Gunakan pagination agar halaman tidak berat jika log sudah mencapai ribuan
        $riwayats = $query->paginate(20);

        return view('riwayat.index', compact('riwayats'));
    }
}