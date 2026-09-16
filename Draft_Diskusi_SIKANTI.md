# Gambaran Umum Sistem: SIKANTI (Sistem Informasi Katalog Arsip dan Naskah TerIntegrasi)

## 1. Pendahuluan
SIKANTI adalah sistem informasi kearsipan digital berbasis web yang dikembangkan khusus untuk mengelola, menyimpan, dan melacak status retensi dokumen di lingkungan pemerintahan (BPK RI Perwakilan Provinsi Jambi). Sistem ini mendigitalkan tata kelola ordner fisik menjadi direktori virtual yang terstruktur dengan kontrol akses dan pengawasan ketat.

### Rencana Agenda Pertemuan:
1. **Pertemuan 1:** Diskusi terkait sistem, penentuan pengguna (aktor), dan asesmen kemungkinan aplikasi pada lingkungan kerja.
2. **Pertemuan 2:** Implementasi sistem ke server (Deployment).
3. **Pertemuan 3:** Acara puncak (Sosialisasi sistem kepada seluruh pengguna).

---

## 2. Spesifikasi Teknologi
Aplikasi ini dikembangkan menggunakan tumpukan teknologi (Tech Stack) berikut:
* **Framework:** Laravel 7.x
* **Bahasa Pemrograman:** PHP (>= 7.2.5)
* **Database:** MySQL / MariaDB
* **Frontend:** Blade Templating, Bootstrap 4, FontAwesome 6
* **Library Tambahan:** 
  * `simplesoftwareio/simple-qrcode` (Generator QR Code)
  * `PDF.js` (Viewer PDF cerdas tanpa paksaan unduh)
  * `SweetAlert2` (Notifikasi antarmuka pengguna)

---

## 3. Fitur Utama
* **Gudang Klasifikasi:** Manajemen direktori folder tanpa batas sesuai nomenklatur arsip.
* **JRA (Jadwal Retensi Arsip) Otomatis:** Sistem akan menghitung otomatis masa retensi aktif, inaktif, hingga status Nasib Akhir (Musnah/Permanen).
* **Gerbang Keamanan QR Code:** Melacak dan memvalidasi akses secara *real-time* untuk peminjaman/peninjauan dokumen fisik maupun digital.
* **Database & UI Isolation:** Pembatasan akses super ketat sehingga staf hanya dapat melihat data dan menu yang relevan dengan unit atau hak aksesnya.
* **Audit Trail & Soft Deletes:** Keamanan pengawasan dari perubahan ilegal dan kemampuan pemulihan data yang terhapus secara tidak sengaja.

---

## 4. Pengguna Sistem (Aktor)
Sistem ini menggunakan prinsip **Hardened Deployment** dan **Closed-Loop Registration**, di mana pendaftaran bersifat otoritatif.
1. **Admin Subbagian (Misal: Admin SDM):** Memiliki hak akses penuh untuk mendaftarkan akun staf, mengelola seluruh arsip di unitnya, memverifikasi akses dari pihak luar, serta mengawasi jejak aktivitas.
2. **Staf Pelaksana:** Pengguna di bawah naungan Admin Subbagian. Akses dibatasi (UI Isolation) hanya untuk operasional harian (melihat Dashboard dan Gudang Folder).
3. **Pihak Eksternal (Peminjam):** Pegawai dari luar subbagian yang hanya dapat mengakses dokumen melalui pemindaian QR Code dan wajib menunggu persetujuan (otorisasi) dari Admin pemilik arsip.

---

## 5. Alur Pengguna (User Flow)

### A. Alur Login dan Manajemen Tim (Tahap Awal)
* **Autentikasi Terisolasi:** Pengguna mengakses halaman login dan memasukkan email serta kata sandi. Karena sistem menggunakan *Hardened Deployment*, tidak ada tombol "Daftar" untuk publik demi mencegah pembuatan akun ilegal.
* **Manajemen Tim (Closed-Loop):** Jika yang masuk adalah Admin Subbagian (misal: Admin SDM), mereka akan diarahkan ke Dashboard utama. Admin kemudian masuk ke menu Manajemen Tim untuk mendaftarkan akun untuk staf pelaksana di unitnya, menentukan password awal, dan membagikannya ke staf tersebut.

### B. Alur Pembatasan Akses Staf (UI Isolation)
* Ketika Staf Pelaksana menggunakan akun yang baru dibuat tadi untuk login, sistem akan langsung membaca peran (role) mereka.
* Sistem mengeksekusi *UI Isolation*, di mana menu sensitif seperti Pengaturan Utama, Jejak Aktivitas, Kelola Sampah, dan Manajemen Tim **disembunyikan secara otomatis**. Staf hanya bisa melihat menu Dashboard dan Gudang Folder untuk fokus pada pekerjaan operasional mereka.

### C. Alur Registrasi dan Pengelolaan Arsip (Rutinitas Harian)
* **Navigasi Gudang Folder:** Admin atau Staf membuka menu Gudang Folder. Berkat *Database Isolation*, mereka hanya melihat folder milik unitnya sendiri (misalnya, Subbagian SDM hanya melihat folder KP.00, KP.01, dst).
* **Registrasi Naskah:** Untuk menambahkan arsip baru, pengguna mengklik tombol "Registrasi Arsip", lalu mengunggah file digital (PDF/Doc) dan mengisi metadata JRA (Jadwal Retensi Arsip) secara presisi, seperti tahun dokumen, masa aktif, dan status penyusutan.

### D. Alur Sirkulasi dan Peminjaman Arsip (Gerbang Verifikasi QR Code)
Ini adalah fitur keamanan paling krusial di SIKANTI untuk peminjaman dokumen internal/eksternal lintas subbagian:
* **Pemindaian (Scan):** Pegawai luar (peminjam) memindai QR Code yang tertempel di map fisik atau melihat pratinjau dokumen terkunci di layar seluler mereka.
* **Pengisian Formulir:** Peminjam diwajibkan mengisi nama, asal subbagian, dan tujuan meminjam/melihat arsip tersebut.
* **Notifikasi Real-Time:** Di saat yang sama, menu Verifikasi Akses di layar Admin pemilik arsip akan memunculkan angka notifikasi antrean merah.
* **Tindakan Admin (Otorisasi):**
  * **Jika Ditolak:** Admin wajib mengetikkan alasan penolakan, dan peminjam akan menerima status penolakan tersebut di layar mereka.
  * **Jika Disetujui:** Admin bisa memilih apakah peminjam hanya diberikan hak tinjau (*View-Only*) di tempat, atau diberikan kebebasan untuk mengunduh file digitalnya (*Download*).

### E. Alur Audit dan Pemulihan (Fungsi Pengawasan)
Sistem menjamin bahwa tidak ada satupun informasi rahasia BPK yang bisa beredar melintasi subbagian tanpa sepengetahuan dan persetujuan digital dari Admin pemilik dokumen.
* **Kelola Sampah (Recycle Bin):** Jika ada dokumen atau folder yang terhapus (*soft delete*), Admin dapat masuk ke menu Kelola Sampah untuk memulihkannya kembali (*restore*) atau memusnahkannya secara permanen sesuai instruksi JRA.
* **Jejak Aktivitas (Audit Trail):** Setiap klik, aksi upload, perubahan data, atau penghapusan yang dilakukan oleh siapapun (termasuk Staf) akan tercatat secara otomatis dan kronologis di menu Jejak Aktivitas. Admin bisa memantau siapa pelaku, jam kejadian, dan aksi apa yang dilakukan.

---
*Dokumen ini dibuat khusus sebagai bahan persiapan dan diskusi penerapan aplikasi SIKANTI.*
