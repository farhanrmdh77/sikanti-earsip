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

    /* ================= SAAS CARD & FORM ELEMENTS ================= */
    .saas-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08); overflow: hidden; position: relative; height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .saas-card:hover { box-shadow: 0 15px 45px -10px rgba(15, 23, 42, 0.12); }
    
    .form-control-modern { border-radius: 12px; border: 1px solid #cbd5e1; padding: 12px 16px; font-family: 'Poppins'; color: #334155; transition: 0.3s; background: #f8fafc; font-size: 0.95rem; width: 100%; box-sizing: border-box;}
    .form-control-modern:focus { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15); outline: none; }
    
    .input-group-text.modern { background: #f1f5f9; border: 1px solid #cbd5e1; border-right: none; border-radius: 12px 0 0 12px; color: #94a3b8; transition: 0.3s; }
    .form-control-modern.with-icon { border-left: none; border-radius: 0 12px 12px 0; background: #f1f5f9; }
    .form-control-modern.with-icon:focus { background: #fff; }
    .form-control-modern.with-icon:focus + .input-group-prepend .input-group-text.modern { background: #fff; border-color: #2563eb; color: #2563eb; }

    .btn-primary-modern { background-color: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 12px 24px; font-size: 0.95rem; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);}
    .btn-primary-modern:hover { background-color: #1d4ed8; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35); }
    
    .btn-dark-modern { background-color: #0f172a; color: #fff; border: none; border-radius: 12px; font-weight: 600; padding: 12px 24px; font-size: 0.95rem; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);}
    .btn-dark-modern:hover { background-color: #1e293b; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(15, 23, 42, 0.35); }

    /* UPLOAD AREA */
    .upload-area { background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; transition: all 0.3s ease; }
    .upload-area:hover { border-color: #3b82f6; background: #eff6ff; }

    /* ================= TOAST NOTIFICATION MODERN ================= */
    .custom-toast-container { position: fixed; top: 30px; right: -400px; background-color: #ffffff; padding: 20px 45px 20px 25px; border-radius: 16px; box-shadow: 0 15px 40px -5px rgba(0,0,0,0.15); display: flex; align-items: center; width: 380px; z-index: 99999; transition: right 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); overflow: hidden; }
    .custom-toast-container.show { right: 30px; }
    .toast-icon-circle { width: 48px; height: 48px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.4rem; flex-shrink: 0; margin-right: 18px; }
    .toast-success .toast-icon-circle { background-color: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
    .toast-error .toast-icon-circle { background-color: #ef4444; color: white; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }
    .toast-text-area h4 { font-size: 1.1rem; font-weight: 800; margin: 0 0 3px 0; color: #1e293b; letter-spacing: 0.5px; }
    .toast-text-area p { font-size: 0.85rem; color: #64748b; margin: 0; line-height: 1.4; }
    .toast-close-btn { position: absolute; top: 15px; right: 15px; background: transparent; border: none; color: #94a3b8; font-size: 1rem; cursor: pointer; transition: 0.2s; }
    .toast-close-btn:hover { color: #475569; }
    .toast-progress-bar { position: absolute; bottom: 0; left: 0; height: 5px; width: 100%; background-color: #10b981; animation: toastProgress 3s linear forwards; }
    .toast-error .toast-progress-bar { background-color: #ef4444; }

    @keyframes toastProgress { 0% { width: 100%; } 100% { width: 0%; } }

    /* ================= RESPONSIVITAS MOBILE (SMARTPHONE) ================= */
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
        .top-navbar-sticky h3 { font-size: 1.15rem !important; }
        .top-navbar-sticky small { font-size: 0.7rem !important; }
        .saas-card { border-radius: 16px; margin-bottom: 20px; height: auto;}
        
        .user-profile-text { display: none !important; }
        .upload-area { flex-direction: column; text-align: center; }
        .upload-area .mr-4 { margin-right: 0 !important; margin-bottom: 15px; }
    }
</style>

@if(session('success'))
<div id="elegantToast" class="custom-toast-container toast-success">
    <button class="toast-close-btn" onclick="tutupToast()"><i class="fa-solid fa-xmark"></i></button>
    <div class="toast-icon-circle"><i class="fa-solid fa-check"></i></div>
    <div class="toast-text-area">
        <h4>SUKSES!</h4>
        <p>{{ session('success') }}</p>
    </div>
    <div class="toast-progress-bar"></div>
</div>
@endif

@if($errors->any())
<div id="elegantToast" class="custom-toast-container toast-error">
    <button class="toast-close-btn" onclick="tutupToast()"><i class="fa-solid fa-xmark"></i></button>
    <div class="toast-icon-circle"><i class="fa-solid fa-xmark"></i></div>
    <div class="toast-text-area">
        <h4>PERHATIAN!</h4>
        <p>{{ $errors->first() }}</p>
    </div>
    <div class="toast-progress-bar"></div>
</div>
@endif

<div class="dashboard-wrapper">
    <div class="sidebar">
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

        <div class="px-4 mb-3 mt-4" style="color: #475569; font-weight: 700; font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase;">Navigasi Utama</div>
        
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            <li><a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') || request()->routeIs('arsip.*') ? 'active' : '' }}"><i class="fa-solid fa-folder-open"></i> Gudang Folder</a></li>
            <li>
                <a href="{{ route('verifikasi.index') }}" class="d-flex align-items-center">
                    <i class="fa-solid fa-shield-halved"></i> Verifikasi Akses
                    <span id="badge-verifikasi-global" class="badge badge-danger ml-auto" style="display: none; border-radius: 8px; padding: 5px 8px; font-family: 'Poppins';">0</span>
                </a>
            </li>
            <li><a href="{{ route('pengguna.index') }}"><i class="fa-solid fa-users"></i> Manajemen Tim</a></li>
            <li><a href="{{ route('sampah.index') }}"><i class="fa-solid fa-trash-can"></i> Kelola Sampah</a></li>
            
            <div class="px-4 mb-3 mt-4" style="color: #475569; font-weight: 700; font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase;">Sistem</div>
            <li><a href="{{ route('riwayat.index') }}"><i class="fa-solid fa-clock-rotate-left"></i> Jejak Aktivitas</a></li>
            <li><a href="{{ route('pengaturan.index') }}" class="active"><i class="fa-solid fa-sliders"></i> Pengaturan Utama</a></li>
        </ul>

        <div class="mt-auto p-4 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
            <div style="background: rgba(255,255,255,0.03); border-radius: 16px; padding: 15px; margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.05);">
                <small style="color: #64748b; font-size: 0.65rem; font-weight: 600; display: block; margin-bottom: 2px;">
                    SEKTOR AKTIF • <span style="color: #fbbf24;">{{ Auth::user()->role == 'Staff' ? 'STAFF' : 'ADMIN' }}</span>
                </small>
                <strong style="color: #C8A35A; font-size: 0.9rem;">{{ Auth::user()->subbagian->nama_subbag ?? 'UMUM' }} ({{ Auth::user()->subbagian->kode_klasifikasi ?? 'XX' }})</strong>
            </div>
            
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-block" style="background: rgba(225, 29, 72, 0.1); color: #fb7185; border-radius: 12px; font-weight: 600; font-size: 0.9rem; padding: 12px; transition: 0.3s;">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Akhiri Sesi
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>

    <div class="main-content">
        
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <div class="top-navbar-sticky d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h3 class="font-weight-bold mb-0" style="color: #0f172a;">Pengaturan Sistem Terpusat</h3>
                    <small style="color: #64748b; font-weight: 500; font-size: 0.8rem;">BPK Perwakilan Provinsi Jambi</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="text-right mr-3 d-none d-md-block user-profile-text">
                    <div class="font-weight-bold" style="color: #0f172a; font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                    <div style="color: #64748b; font-size: 0.8rem; font-weight: 500;">{{ Auth::user()->email }}</div>
                </div>
                <div class="shadow-sm" style="width: 48px; height: 48px; font-size: 1.2rem; border-radius: 16px; display: flex; align-items: center; justify-content: center; background-color: #fff; color: #C8A35A; border: 1px solid #e2e8f0;">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/profil/'.Auth::user()->foto) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 16px;">
                    @else
                        <i class="fa-solid fa-user-shield"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-4">
            
            <div class="col-lg-7 mb-4">
                <div class="saas-card d-flex flex-column">
                    <div class="p-4 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                        <h5 class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-building-flag text-primary mr-2"></i>Identitas Instansi (Global)</h5>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">Perubahan logo dan nama ini akan merefleksikan seluruh tampilan aplikasi secara instan.</p>
                    </div>
                    
                    <div class="p-4 bg-white flex-grow-1">
                        <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="h-100 d-flex flex-column justify-content-between">
                            @csrf
                            
                            <div>
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">NAMA APLIKASI / BRAND</label>
                                    <input type="text" name="nama_aplikasi" class="form-control form-control-modern bg-white" value="{{ $pengaturan->nama_aplikasi ?? 'E-Arsip SIKANTI' }}" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">SUB JUDUL / SLOGAN</label>
                                    <input type="text" name="sub_judul" class="form-control form-control-modern bg-white" value="{{ $pengaturan->sub_judul ?? 'Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi' }}" placeholder="Contoh: Sistem Informasi Kearsipan Terintegrasi">
                                </div>

                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase d-block mb-2">LOGO APLIKASI (Opsional)</label>
                                    
                                    <div class="upload-area d-flex align-items-center p-3">
                                        <div class="mr-4 p-2 bg-white text-center shadow-sm flex-shrink-0" style="width: 100px; height: 100px; border-radius: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                            @if(isset($pengaturan) && $pengaturan->logo_aplikasi)
                                                <img id="previewLogo" src="{{ asset('storage/pengaturan/' . $pengaturan->logo_aplikasi) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                                                <i id="defaultIcon" class="fa-solid fa-image text-muted" style="font-size: 2.5rem; display: none;"></i>
                                            @else
                                                <img id="previewLogo" src="" alt="Belum Ada" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                                                <i id="defaultIcon" class="fa-solid fa-image" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-grow-1 w-100">
                                            <div class="custom-file mb-2">
                                                <input type="file" name="logo_aplikasi" class="custom-file-input" id="logoInput" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event, 'previewLogo', 'defaultIcon')">
                                                <label class="custom-file-label bg-white" for="logoInput" style="border-radius: 10px; font-size: 0.85rem; height: 42px; line-height: 28px; border-color: #cbd5e1; color: #64748b; font-weight: 500;">Pilih gambar logo...</label>
                                            </div>
                                            <small class="d-block" style="color: #64748b; font-size: 0.75rem;"><i class="fa-solid fa-circle-info mr-1 text-primary"></i>Format: PNG transparan (Rasio 1:1 direkomendasikan).</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <hr style="border-color: #e2e8f0; margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary-modern w-100"><i class="fa-solid fa-save mr-2"></i> Simpan Pengaturan Instansi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="saas-card d-flex flex-column">
                    <div class="p-4 bg-white" style="border-bottom: 1px solid #f1f5f9;">
                        <h5 class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-user-tie text-primary mr-2"></i>Profil Akun Saya</h5>
                        <p class="text-muted small mb-0" style="font-size: 0.85rem;">Sesuaikan identitas personal, kata sandi, dan foto profil Anda.</p>
                    </div>
                    
                    <div class="p-4 bg-white flex-grow-1">
                        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="h-100 d-flex flex-column justify-content-between">
                            @csrf @method('PUT')
                            
                            <div>
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img id="previewAvatar" src="{{ Auth::user()->foto ? asset('storage/profil/'.Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=e2e8f0&color=475569&size=150' }}" class="rounded-circle shadow" style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #fff; background: #f8fafc; transition: all 0.3s ease;">
                                        
                                        <button type="button" id="btnHapusFoto" class="btn btn-danger position-absolute shadow-sm" style="bottom: 0; left: 0; border-radius: 50%; width: 42px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff; z-index: 10; {{ Auth::user()->foto ? '' : 'display: none !important;' }}" onclick="hapusFotoProfil('{{ urlencode(Auth::user()->name) }}')" title="Hapus Foto Profil">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>

                                        <label for="fotoInput" class="btn btn-primary-modern position-absolute shadow-sm" style="bottom: 0; right: 0; border-radius: 50%; width: 42px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff; z-index: 10;" title="Ganti Foto Profil">
                                            <i class="fa-solid fa-camera"></i>
                                        </label>
                                        
                                        <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/png, image/jpeg, image/jpg" onchange="previewImageBaru(event)">
                                        
                                        <input type="hidden" name="hapus_foto" id="hapusFotoInput" value="0">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">NAMA LENGKAP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text modern"><i class="fa-solid fa-user"></i></span>
                                        </div>
                                        <input type="text" name="name" class="form-control form-control-modern with-icon" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">ALAMAT EMAIL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text modern"><i class="fa-solid fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control form-control-modern with-icon" value="{{ Auth::user()->email }}" readonly style="color: #94a3b8; cursor: not-allowed;">
                                    </div>
                                    <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;"><i class="fa-solid fa-lock mr-1 text-warning"></i> Email utama tidak dapat diubah secara sepihak.</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted small text-uppercase mb-2">UBAH SANDI (Opsional)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text modern"><i class="fa-solid fa-key"></i></span>
                                        </div>
                                        <input type="password" name="password" class="form-control form-control-modern with-icon" placeholder="Kosongkan jika tidak ingin mengubah...">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <hr style="border-color: #e2e8f0; margin-bottom: 20px;">
                                <button type="submit" class="btn btn-dark-modern w-100"><i class="fa-solid fa-user-check mr-2"></i> Perbarui Profil Saya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ========================================================
    // LOGIKA SIDEBAR MOBILE
    // ========================================================
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    // ========================================================
    // FUNGSI PREVIEW GAMBAR (LOGO & AVATAR)
    // ========================================================
    function previewImage(event, targetImgId, targetIconId) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById(targetImgId);
            output.src = reader.result;
            output.style.display = 'block';
            
            if(targetIconId) {
                var icon = document.getElementById(targetIconId);
                if(icon) icon.style.display = 'none';
            }
        };
        reader.readAsDataURL(event.target.files[0]);
        
        // Ubah text label file input khusus untuk Logo Instansi
        if(event.target.nextElementSibling && event.target.nextElementSibling.classList.contains('custom-file-label')) {
            let fileName = event.target.files[0].name;
            event.target.nextElementSibling.innerText = fileName;
        }
    }

    // ========================================================
    // FUNGSI HAPUS FOTO PROFIL (REAL-TIME UI)
    // ========================================================
    function hapusFotoProfil(userName) {
        // 1. Beri tahu sistem/backend bahwa user ingin menghapus foto
        document.getElementById('hapusFotoInput').value = '1';
        
        // 2. Kosongkan input file (berjaga-jaga jika user baru saja memilih gambar tapi batal)
        document.getElementById('fotoInput').value = '';
        
        // 3. Kembalikan gambar layar ke Avatar Inisial Abu-abu secara instan
        document.getElementById('previewAvatar').src = 'https://ui-avatars.com/api/?name=' + userName + '&background=e2e8f0&color=475569&size=150';
        
        // 4. Sembunyikan tombol hapus merah karena foto sudah kosong
        document.getElementById('btnHapusFoto').style.setProperty('display', 'none', 'important');
    }

    function previewImageBaru(event) {
        // Panggil fungsi preview gambar bawaan
        previewImage(event, 'previewAvatar', null);
        
        // Batalkan niat hapus (set value ke 0) karena user memilih foto baru
        document.getElementById('hapusFotoInput').value = '0';
        
        // Tampilkan kembali tombol hapus merah
        document.getElementById('btnHapusFoto').style.setProperty('display', 'flex', 'important');
    }

    // ========================================================
    // TOAST NOTIFICATION LOGIC
    // ========================================================
    function tutupToast() {
        const toast = document.getElementById('elegantToast');
        if(toast) {
            toast.classList.remove('show');
            setTimeout(() => { toast.remove(); }, 500);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('elegantToast');
        if(toast) {
            setTimeout(() => { toast.classList.add('show'); }, 100);
            setTimeout(() => { tutupToast(); }, 3100); 
        }
    });

    // ========================================================
    // POLLING NOTIFIKASI REAL-TIME (VERIFIKASI BADGE)
    // ========================================================
    document.addEventListener('DOMContentLoaded', function() {
        let lastKnownId = 0; 
        
        function updateBadge(count) {
            const badge = document.getElementById('badge-verifikasi-global');
            if(badge) {
                if(count > 0) { badge.innerText = count; badge.style.display = 'inline-block'; } 
                else { badge.style.display = 'none'; }
            }
        }

        fetch('{{ route("api.verifikasi.pending") }}').then(res => res.json()).then(data => {
            if(data.latest_id) lastKnownId = data.latest_id;
            updateBadge(data.jumlah_pending);
        });

        setInterval(function() {
            fetch('{{ route("api.verifikasi.pending") }}').then(res => res.json()).then(data => {
                updateBadge(data.jumlah_pending);
                if(data.has_new && data.latest_id > lastKnownId) {
                    lastKnownId = data.latest_id;
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true });
                    Toast.fire({ icon: 'info', title: 'Permintaan Akses Baru!', text: data.nama + ' menunggu persetujuan Anda.' });
                }
            });
        }, 3000);
    });
</script>
@endsection