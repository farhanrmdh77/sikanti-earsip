<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $subbag_id = Auth::user()->subbag_id;

        $penggunas = User::where('subbag_id', $subbag_id)->latest();

        if ($request->filled('search')) {
            $penggunas->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $penggunas = $penggunas->get();

        return view('pengguna.index', compact('penggunas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string'
        ]);

        // ==========================================
        // CREATE USER (OTOMATIS TERPERCAYA)
        // ==========================================
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'subbag_id' => Auth::user()->subbag_id, 
            'role' => $request->role,
            
            // CATATAN: Jika di database Anda ada kolom status verifikasi, 
            // buka komentar di bawah ini agar user otomatis disetujui
            // 'status_verifikasi' => 'Disetujui', 
            // 'is_verified' => 1,
        ]);

        // ==========================================
        // REKAM AKTIVITAS: CREATE USER
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'CREATE',
            'deskripsi' => 'Mendaftarkan akun operasional baru (Terpercaya) bernama: ' . $request->name
        ]);

        return redirect()->back()->with('success', 'Pengguna baru berhasil didaftarkan dan langsung dapat digunakan untuk Login.');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);

        // ==========================================
        // PERBAIKAN BUG VALIDASI ROLE
        // ==========================================
        // Role hanya diwajibkan jika form benar-benar mengirimkan 'role'.
        // (Sebab Admin tidak bisa mengedit rolenya sendiri dari form UI).
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, 
            'password' => 'nullable|string|min:6|confirmed',
        ];

        if ($request->has('role')) {
            $rules['role'] = 'required|string';
        }

        $request->validate($rules);

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Simpan role baru HANYA JIKA role dikirimkan
        if ($request->has('role')) {
            $user->role = $request->role;
        }

        // Simpan password baru HANYA JIKA diisi (tidak kosong)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // ==========================================
        // REKAM AKTIVITAS: UPDATE USER
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'UPDATE',
            'deskripsi' => 'Memperbarui data akun operasional milik: ' . $user->name
        ]);

        return redirect()->back()->with('success', 'Data pengguna ' . $user->name . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->back()->withErrors(['error' => 'Peringatan Sistem: Anda tidak diizinkan menghapus akun Anda sendiri yang sedang aktif digunakan!']);
        }

        $user = User::where('subbag_id', Auth::user()->subbag_id)->findOrFail($id);
        $nama_user = $user->name;
        
        // ==========================================
        // REKAM AKTIVITAS: DELETE USER
        // ==========================================
        \App\RiwayatAktivitas::create([
            'user_id' => Auth::user()->id,
            'subbag_id' => Auth::user()->subbag_id,
            'tipe_aksi' => 'DELETE',
            'deskripsi' => 'Menghapus permanen akun operasional: ' . $nama_user
        ]);

        $user->delete();

        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus permanen dari sistem.');
    }
}