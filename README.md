# 🏛️ SIKANTI (Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi)

SIKANTI adalah sistem informasi kearsipan digital berbasis web yang dikembangkan khusus untuk mengelola, menyimpan, dan melacak status retensi dokumen di lingkungan pemerintahan (BPK RI Perwakilan Provinsi Jambi). 

Aplikasi ini mendigitalkan tata kelola ordner fisik menjadi direktori virtual yang terstruktur, lengkap dengan sistem keamanan berbasis pemindaian QR Code untuk melacak keluarnya dokumen rahasia.

## Fitur Unggulan
* **Gudang Klasifikasi:** Manajemen direktori folder tak terbatas berdasarkan nomenklatur arsip (Contoh: KP.00, KP.01).
* **JRA (Jadwal Retensi Arsip) Otomatis:** Perhitungan otomatis masa retensi aktif, inaktif, dan penentuan Nasib Akhir (Musnah/Permanen).
* **Verifikasi Akses QR Code:** Dokumen fisik dilindungi oleh stiker QR. Pemindai harus meminta izin akses secara *real-time* kepada Admin untuk membuka kunci file digital.
* **Pratinjau Cerdas (Smart Preview):** Terintegrasi dengan `PDF.js` untuk merender dokumen PDF langsung di peramban *smartphone* tanpa memicu paksaan unduh, serta mendukung jaringan intranet lokal (*Localhost*).
* **Manajemen Tim Terpusat:** Registrasi publik ditutup (*closed-loop*). Seluruh akun dikelola secara otoritatif oleh Administrator.
* **Riwayat Aktivitas (Audit Trail):** Merekam setiap jejak operasional pengguna di dalam sistem untuk kebutuhan pengawasan.

## Spesifikasi Teknologi (Tech Stack)
* **Framework:** Laravel (PHP)
* **Database:** MySQL
* **Frontend:** Blade Templating, Bootstrap 4, FontAwesome 6
* **Library Ekstra:** * `simplesoftwareio/simple-qrcode` (Generator QR)
  * `SweetAlert2` (Notifikasi UI)
  * `PDF.js` (Viewer PDF Client-side)

## Panduan Instalasi (Untuk Tim IT)

Ikuti langkah-langkah di bawah ini untuk menjalankan SIKANTI di peladen (*server*) atau komputer lokal Anda.

### Persyaratan Sistem
* PHP >= 7.4 / 8.x
* Composer v2
* MySQL / MariaDB

### Langkah Instalasi
1. **Kloning Repositori**
   ```bash
   git clone [https://github.com/farhanrmdh77/sikanti-earsip.git](https://github.com/farhanrmdh77/sikanti-earsip.git)
   cd sikanti-earsip

1. Instalasi Dependensi
Bash
composer install

2. Konfigurasi Environment
Salin file konfigurasi bawaan dan sesuaikan dengan kredensial database Anda.
Bash
cp .env.example .env
Buka file .env dan atur DB_DATABASE, DB_USERNAME, dan DB_PASSWORD Anda.

3. Generate Application Key
Bash
php artisan key:generate

4. Migrasi Database
(Pastikan Anda telah mengimpor file db_sikanti_final.sql ke dalam database Anda melalui phpMyAdmin).

5. Tautkan Storage (Sangat Penting!)
Agar gambar, logo, dan file PDF dapat diakses oleh publik/sistem:
Bash
php artisan storage:link

6. Jalankan Aplikasi
Bash
php artisan serve --host=0.0.0.0 --port=8000
Aplikasi kini dapat diakses melalui browser di http://localhost:8000 atau via IP lokal jaringan Anda.

🔒 Catatan Keamanan
Direktori .env dan file .sql sengaja diabaikan (.gitignore) dari repositori ini demi menjaga kerahasiaan kredensial dan data instansi. Silakan hubungi Administrator/Pengembang untuk mendapatkan file dump database awal.

Pengembang: Farhan | 2026