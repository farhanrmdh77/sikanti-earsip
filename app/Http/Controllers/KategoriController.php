<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    // Memastikan hanya admin yang sudah login yang bisa mengakses
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 1. READ: Menampilkan daftar folder milik subbagian admin
    public function index()
    {
        $kategoris = Kategori::where('subbag_id', Auth::user()->subbag_id)
                            ->orderBy('nama_kategori', 'asc')
                            ->get();
        
        return view('kategori.index', compact('kategoris'));
    }

    // 2. CREATE: Menyimpan folder baru dan mengunci subbag_id-nya
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        Kategori::create([
            'subbag_id' => Auth::user()->subbag_id, // Otomatis mengikuti subbag admin
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Folder kategori berhasil dibuat!');
    }

    // 3. UPDATE: Memperbarui nama/deskripsi folder
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        // Cari folder berdasarkan ID, TAPI pastikan itu milik subbagiannya
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Folder berhasil diperbarui!');
    }

    // 4. DELETE: Menghapus folder
    public function destroy($id)
    {
        $kategori = Kategori::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Folder berhasil dihapus!');
    }
}