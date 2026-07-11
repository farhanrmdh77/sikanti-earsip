@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    #app > nav { display: none !important; }
    #app > main { padding-top: 0 !important; padding-bottom: 0 !important; }
    body { background-color: #f4f7fb; font-family: 'Poppins', sans-serif; overflow-x: hidden; margin: 0; color: #334155; }

    .dashboard-wrapper { display: flex; min-height: 100vh; width: 100%; }
    
    /* ================= SIDEBAR SAAS STYLE ================= */
    .sidebar { width: 280px; background-color: #0f172a; color: #fff; display: flex; flex-direction: column; flex-shrink: 0; position: sticky; top: 0; height: 100vh; box-shadow: 4px 0 24px rgba(0,0,0,0.05); z-index: 1000;}
    .sidebar-header { padding: 30px 25px 20px 25px; }
    .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; flex-grow: 1; overflow-y: auto; }
    .sidebar-menu::-webkit-scrollbar { width: 4px; }
    .sidebar-menu::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 4px; }
    .sidebar-menu li { margin-bottom: 8px; }
    .sidebar-menu a { display: flex; align-items: center; color: #94a3b8; text-decoration: none; padding: 14px 18px; border-radius: 14px; font-weight: 500; font-size: 0.9rem; transition: all 0.3s ease; }
    .sidebar-menu a i { margin-right: 16px; font-size: 1.1rem; width: 24px; text-align: center; transition: all 0.3s ease; }
    .sidebar-menu a:hover { color: #fff; background-color: rgba(255,255,255,0.05); transform: translateX(5px); }
    .sidebar-menu a.active { background-color: #2563eb; color: #fff; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3); }
    .sidebar-menu a.active i { color: #fff; }

    .main-content { flex-grow: 1; padding: 0 40px 80px 40px; min-height: 100vh; }
    
    /* ================= NAVBAR STICKY GLASSMORPHISM ================= */
    .top-navbar-sticky { position: sticky; top: 0; background-color: rgba(244, 247, 251, 0.85); -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px); z-index: 999; margin: 0 -40px 30px -40px; padding: 20px 40px; border-bottom: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.02); }

    /* ================= SAAS COMPONENTS & FORM ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); position: relative; }
    
    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 12px 30px; font-size: 0.95rem; box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25); transition: 0.3s; display: inline-flex; align-items: center; cursor: pointer; }
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 12px 20px rgba(37, 99, 235, 0.3); }
    
    .btn-light-modern { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 600; padding: 12px 25px; font-size: 0.95rem; transition: 0.3s; text-decoration: none; display: inline-flex; align-items: center;}
    .btn-light-modern:hover { background-color: #e2e8f0; color: #0f172a; text-decoration: none; }

    .btn-back-modern { background-color: #fff; color: #475569; border: 1px solid #cbd5e1; border-radius: 12px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: 0.3s; margin-right: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); text-decoration: none;}
    .btn-back-modern:hover { background-color: #f1f5f9; color: #0f172a; transform: translateX(-3px); text-decoration: none;}

    .form-label-modern { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; display: block; }
    .form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; background-color: #f8fafc; transition: all 0.3s ease; color: #334155; font-size: 0.9rem; width: 100%; height: auto;}
    .form-control-modern:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); outline: none; }
    textarea.form-control-modern { min-height: 120px; resize: vertical; }
    select.form-control-modern { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 15px center; padding-right: 40px; cursor: pointer; }
    
    .section-badge { display: inline-flex; align-items: center; background: #eff6ff; color: #2563eb; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; margin-bottom: 25px; border: 1px solid rgba(37, 99, 235, 0.1); }
    .section-badge.warning { background: #fef3c7; color: #d97706; border-color: rgba(217, 119, 6, 0.1); }
    
    .border-right-dashed { border-right: 2px dashed #f1f5f9; }
    
    /* CUSTOM FILE UPLOAD DRAG & DROP STYLE */
    .file-upload-wrapper { position: relative; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 30px 20px; text-align: center; background-color: #f8fafc; transition: all 0.3s ease; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .file-upload-wrapper:hover { border-color: #3b82f6; background-color: #eff6ff; }
    .file-upload-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10; }
    .file-icon-large { font-size: 2.5rem; color: #94a3b8; margin-bottom: 10px; transition: 0.3s; }
    .file-upload-wrapper:hover .file-icon-large { color: #3b82f6; transform: translateY(-5px); }
    .file-upload-text { font-size: 0.9rem; color: #475569; font-weight: 600; margin-bottom: 5px; }

    /* RESPONSIVE */
    .mobile-menu-btn { display: none; background: transparent; border: none; color: #0f172a; font-size: 1.5rem; cursor: pointer; padding: 0; margin-right: 15px; transition: 0.3s; }
    .mobile-menu-btn:hover { color: #2563eb; }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 9998; opacity: 0; transition: opacity 0.3s ease; }
    .sidebar-overlay.show { display: block; opacity: 1; }

    @media (max-width: 991px) {
        .sidebar { position: fixed; left: -300px; top: 0; height: 100vh; z-index: 9999; transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1); width: 280px; }
        .sidebar.show { left: 0; box-shadow: 10px 0 30px rgba(0,0,0,0.2); }
        .main-content { padding: 0 15px 80px 15px; width: 100%; }
        .top-navbar-sticky { margin: 0 -15px 25px -15px; padding: 15px; border-radius: 0 0 20px 20px; }
        .mobile-menu-btn { display: block; }
        .user-profile-text { display: none !important; }
        .border-right-dashed { border-right: none; border-bottom: 2px dashed #f1f5f9; margin-bottom: 30px; padding-bottom: 30px; }
    }
</style>

<div class="dashboard-wrapper">
    <!-- ================================================================ -->
    <!-- BLOK SIDEBAR TERKUNCI (KONSISTEN) -->
    <!-- ================================================================ -->
    <div class="sidebar">
        <!-- HEADER SIDEBAR -->
        <div class="sidebar-header d-flex align-items-center">
            @if(isset($app_setting) && $app_setting->logo_aplikasi)
                <img src="{{ asset('storage/pengaturan/' . $app_setting->logo_aplikasi) }}" alt="Logo" class="mr-3" style="width: 48px; height: 48px; object-fit: contain; background: transparent; filter: drop-shadow(0 0 12px rgba(96, 165, 250, 0.7));">
            @else
                <div class="bg-primary text-white mr-3 shadow-lg" style="width: 48px; height: 48px; font-size: 1.2rem; border-radius: 14px; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-boxes-stacked"></i></div>
            @endif
            
            <div>
                <h5 class="mb-0 font-weight-bold" style="font-size: 1.15rem; letter-spacing: 0.5px; background: linear-gradient(to right, #60a5fa, #ffffff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 20px rgba(96, 165, 250, 0.1);">
                    {{ isset($app_setting) ? $app_setting->nama_aplikasi : 'SIKANTI' }}
                </h5>
                <small style="color: #94a3b8; font-size: 0.6rem; display: block; line-height: 1.3; margin-top: 2px; font-weight: 500; letter-spacing: 0.5px;">
                    {{ isset($app_setting) && $app_setting->sub_judul ? $app_setting->sub_judul : 'Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi' }}
                </small>
            </div>
        </div>

        <!-- NAVIGASI UTAMA DENGAN MARGIN/PADDING YANG DISELARASKAN -->
        <div class="px-4 mb-3 mt-4" style="color: #475569; font-weight: 700; font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase;">Navigasi Utama</div>
        
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            <li><a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') || request()->routeIs('arsip.*') ? 'active' : '' }}"><i class="fa-solid fa-folder-open"></i> Gudang Folder</a></li>
            
            @if(Auth::user()->role == 'Admin' || empty(Auth::user()->role))
            <li>
                <a href="{{ route('verifikasi.index') }}" class="{{ request()->routeIs('verifikasi.*') ? 'active' : '' }} d-flex align-items-center">
                    <i class="fa-solid fa-shield-halved"></i> Verifikasi Akses
                    <span id="badge-verifikasi-global" class="badge badge-danger ml-auto" style="display: none; border-radius: 8px; padding: 5px 8px; font-family: 'Poppins';">0</span>
                </a>
            </li>
            <li><a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Manajemen Tim</a></li>
            <li><a href="{{ route('sampah.index') }}" class="{{ request()->routeIs('sampah.*') ? 'active' : '' }}"><i class="fa-solid fa-trash-can"></i> Kelola Sampah</a></li>
            
            <div class="px-4 mb-3 mt-4" style="color: #475569; font-weight: 700; font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase;">Sistem</div>
            <li><a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}"><i class="fa-solid fa-clock-rotate-left"></i> Jejak Aktivitas</a></li>
            <li><a href="{{ route('pengaturan.index') }}" class="{{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"><i class="fa-solid fa-sliders"></i> Pengaturan Utama</a></li>
            @endif
        </ul>

        <!-- FOOTER SIDEBAR DENGAN TOMBOL LOGOUT TERKUNCI -->
        <div class="mt-auto p-4 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
            <div style="background: rgba(255,255,255,0.03); border-radius: 16px; padding: 15px; margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.05);">
                <small style="color: #64748b; font-size: 0.65rem; font-weight: 600; display: block; margin-bottom: 2px;">
                    SEKTOR AKTIF • <span style="color: #fbbf24;">{{ (Auth::user()->role == 'Admin' || empty(Auth::user()->role)) ? 'ADMIN' : 'USER' }}</span>
                </small>
                <strong style="color: #C8A35A; font-size: 0.9rem;">{{ Auth::user()->subbagian->nama_subbag ?? 'UMUM' }} ({{ Auth::user()->subbagian->kode_klasifikasi ?? 'XX' }})</strong>
            </div>
            
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-block" style="background: rgba(225, 29, 72, 0.1); color: #fb7185; border-radius: 12px; font-weight: 600; font-size: 0.9rem; padding: 12px; transition: 0.3s;">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Akhiri Sesi
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
    <!-- ================================================================ -->

    <div class="main-content">
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <div class="top-navbar-sticky d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                <a href="{{ route('arsip.index', $kategori->id) }}" class="btn-back-modern" title="Batal Tambah">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Registrasi Dokumen Baru</h3>
                    <small style="color: #64748b; font-weight: 500; font-size: 0.8rem;">Modul Gudang Folder: {{ $kategori->nama_kategori }}</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="text-right mr-3 d-none d-md-block user-profile-text">
                    <div class="font-weight-bold" style="color: #0f172a; font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                    <div style="color: #64748b; font-size: 0.8rem; font-weight: 500;">{{ Auth::user()->email }}</div>
                </div>
                <div class="shadow-sm" style="width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background-color: #fff; color: #C8A35A; border: 1px solid #e2e8f0; overflow: hidden;">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/profil/' . Auth::user()->foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-user-shield"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="saas-card mb-5">
            <div class="px-5 py-4 border-bottom bg-white" style="border-radius: 20px 20px 0 0; border-color: #f1f5f9 !important;">
                <h4 class="font-weight-bold mb-0" style="color: #0f172a;">
                    <i class="fa-solid fa-file-signature text-primary mr-2"></i>Form Registrasi Arsip
                </h4>
            </div>

            <form action="{{ route('arsip.store', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                @csrf 
                
                <div class="px-5 py-5 bg-white">
                    <div class="row">
                        <div class="col-lg-6 border-right-dashed pr-lg-5">
                            <div class="section-badge">
                                <i class="fa-solid fa-circle-info mr-2"></i> Informasi Utama Berkas
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="form-label-modern">Kode Klas</label>
                                    <input type="text" class="form-control-modern font-weight-bold" name="nomor_dokumen" placeholder="Cth: 02.01" required>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label class="form-label-modern">Nama Berkas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control-modern font-weight-bold" name="nama_arsip" placeholder="Cth: Dokumen Seleksi..." required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Tahun Berkas</label>
                                    <input type="text" class="form-control-modern" name="tahun_berkas" placeholder="Cth: Januari 2024">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Jumlah (Lembar)</label>
                                    <input type="number" class="form-control-modern" name="jumlah_berkas" value="1">
                                </div>
                            </div>
                            
                            <div class="form-group mb-0">
                                <label class="form-label-modern">Deskripsi (Uraian)</label>
                                <textarea class="form-control-modern" name="keterangan" placeholder="Catatan opsional mengenai arsip ini..."></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 pl-lg-5">
                            <div class="section-badge warning mt-4 mt-lg-0">
                                <i class="fa-solid fa-scale-balanced mr-2"></i> Status, Retensi & Digitalisasi
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Retensi Aktif (Thn)</label>
                                    <input type="number" class="form-control-modern" name="retensi_aktif" placeholder="Cth: 2">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Retensi Inaktif (Thn)</label>
                                    <input type="number" class="form-control-modern" name="retensi_inaktif" placeholder="Cth: 5">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Nasib Akhir</label>
                                    <select class="form-control-modern" name="nasib_akhir">
                                        <option value="" selected>-- Belum Ditentukan --</option>
                                        <option value="Musnah">Musnah</option>
                                        <option value="Permanen">Permanen</option>
                                        <option value="Dinilai Kembali">Dinilai Kembali</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label-modern">Warna Map</label>
                                    <input type="text" class="form-control-modern" name="warna_berkas" placeholder="Cth: Biru / Merah">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label-modern">Lokasi Fisik Berkas</label>
                                <select class="form-control-modern" name="lokasi_fisik">
                                    <option value="Internal Subbagian">Internal Subbagian</option>
                                    <option value="Diserahkan ke Umum">Diserahkan ke Bagian Umum</option>
                                </select>
                            </div>
                            
                            <div class="form-group mb-0 mt-4">
                                <label class="form-label-modern" style="color: #2563eb;">
                                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> File Digital (Maks 5MB)
                                </label>
                                <div class="file-upload-wrapper" style="padding: 20px 10px;">
                                    <input type="file" class="file-upload-input" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" onchange="updateFileName(this, 'fileNameDisplayNew')">
                                    <i class="fa-solid fa-file-arrow-up file-icon-large" style="font-size: 1.8rem;"></i>
                                    <div class="file-upload-text" id="fileNameDisplayNew">Pilih file atau seret ke sini</div>
                                    <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">Format: PDF, DOC, XLS, PNG, JPG</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="px-5 py-4 d-flex justify-content-between align-items-center" style="background: #f8fafc; border-top: 1px solid #f1f5f9; border-radius: 0 0 20px 20px;">
                    <div style="color: #94a3b8; font-size: 0.8rem; font-weight: 500;">
                        <i class="fa-solid fa-circle-check mr-1"></i> Pastikan data telah diisi dengan benar.
                    </div>
                    <div>
                        <a href="{{ route('arsip.index', $kategori->id) }}" class="btn-light-modern mr-2">Batal</a>
                        <button type="submit" class="btn-primary-modern">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Arsip
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFileName(input, displayId) {
        const display = document.getElementById(displayId);
        if (input.files && input.files.length > 0) {
            display.innerHTML = `<span class="text-primary font-weight-bold"><i class="fa-solid fa-check-circle mr-1"></i> ${input.files[0].name}</span>`;
        } else {
            display.innerHTML = 'Pilih file atau seret ke sini';
        }
    }

    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
</script>
@endsection