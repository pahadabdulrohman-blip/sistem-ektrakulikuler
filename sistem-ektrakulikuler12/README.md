# AKTIVIA — Sistem Informasi Ekstrakurikuler

**AKTIVIA** adalah aplikasi web berbasis Laravel 12 untuk mengelola kegiatan ekstrakurikuler sekolah secara digital. Aplikasi ini melibatkan tiga peran: **Admin**, **Guru**, dan **Siswa**, dengan hak akses dan tampilan yang berbeda.

## 📌 Ringkasan

| Item | Keterangan |
|---|---|
| Nama aplikasi | AKTIVIA — Sistem Informasi Ekstrakurikuler |
| Framework | Laravel 12 |
| Bahasa | PHP 8.2 |
| Database | MySQL (aktif), SQLite didukung via `.env.example` |
| Frontend | Blade, CSS, JavaScript, Vite, Tailwind CSS 4 |
| Arsitektur | MVC dengan middleware berbasis role |
| Mode autentikasi | Session login (`session('login')`, `username`, `role`) |
| Alamat lokal | `http://127.0.0.1:8000` |

## 🎯 Tujuan

- Mendigitalisasi pengelolaan ekstrakurikuler.
- Mempermudah siswa mendaftar dan melihat jadwal, nilai, serta foto kegiatan.
- Mempermudah guru mencatat absensi, penilaian, dan mengelola ekskul.
- Memberikan admin kendali penuh atas data, penerimaan siswa, dan laporan.
- Menyediakan sistem hak akses dan keamanan dasar.

## ✨ Fitur Utama

### Admin
- Dashboard dan rekap statistik.
- CRUD ekstrakurikuler (termasuk galeri foto kegiatan).
- Kelola data guru dan siswa.
- Terima / tolak pendaftaran siswa.
- Kelola akun guru dan permintaan reset password.
- Rekap absensi, penilaian, dan laporan.
- Profil dan foto profil.

### Guru
- Dashboard guru.
- Kelola ekstrakurikuler binaan dan galeri fotonya.
- Kelola jadwal kegiatan.
- Input absensi dan penilaian siswa.
- Lihat laporan.
- Profil dan foto profil.

### Siswa
- Registrasi dan login (status pendaftaran diverifikasi).
- Lihat daftar ekskul, pilih maksimal 2 ekskul, atau batalkan pilihan.
- Lihat detail ekskul beserta **galeri foto (hanya lihat)**.
- Lihat jadwal kegiatan dan nilai.
- Profil dan foto profil.

## 📚 Dokumentasi

| Dokumen | Isi |
|---|---|
| [Dokumentasi Proyek](docs/DOKUMENTASI-PROYEK.md) | Arsitektur, struktur, database, daftar rute, alur fitur, keamanan, pengujian |
| [Panduan Penggunaan](docs/PANDUAN-PENGGUNAAN.md) | Cara pakai aplikasi untuk Admin, Guru, dan Siswa |
| [Troubleshooting](docs/TROUBLESHOOTING.md) | Masalah umum dan solusinya |
| [Diagram Use Case](docs/use-case-diagram.png) | Diagram use case sistem (versi HTML: `docs/use-case-diagram.html`) |

## 🚀 Quick Start

```bash
# 1. Masuk ke folder proyek
cd sistem-ektrakulikuler12

# 2. Install dependency PHP
composer install

# 3. Salin environment
copy .env.example .env          # Windows
# cp .env.example .env          # Linux/macOS

# 4. Generate kunci aplikasi
php artisan key:generate

# 5. Buat database MySQL: sistem-ektrakulikuler12
#    lalu sesuaikan DB_* di .env

# 6. Migrasi
php artisan migrate

# 7. Dependency & build frontend
npm install
npm run build

# 8. Jalankan server
php artisan serve
```

Buka `http://127.0.0.1:8000`.

> Detail lengkap (termasuk catatan untuk XAMPP dan produksi) ada di [Dokumentasi Proyek](docs/DOKUMENTASI-PROYEK.md#5-instalasi).

## 🧪 Pengujian

```bash
php artisan test
```

Terakhir dijalankan: **15 test lulus**, 2 test bawaan masih gagal (`ExampleTest` dan `CsrfProtectionTest`) — lihat [catatan pengujian](docs/DOKUMENTASI-PROYEK.md#14-pengujian).

## 🔐 Catatan Keamanan

- Login dibatasi **5 percobaan/menit per username+IP** dan **30 percobaan/menit per IP**.
- Registrasi dibatasi **6 percobaan/menit**, lupa password **5 percobaan/menit**.
- Logout wajib **POST + CSRF**; GET hanya menampilkan halaman konfirmasi.
- Foto profil disimpan **privat** di `storage/app/private/foto-profil` dan hanya bisa diakses lewat route terautentikasi.
- Header keamanan ditambahkan global oleh `SecurityHeaders`.
- Batas unik diterapkan di database untuk penilaian, absensi, jadwal, dan pendaftaran.

## 📂 Struktur Singkat

```text
app/
├── Http/
│   ├── Controllers/       # Logika aplikasi
│   └── Middleware/        # RoleMiddleware, SecurityHeaders
├── Mail/                  # PasswordBaruMail
├── Models/                # User, Ekstrakurikuler, dll.
database/
├── migrations/
├── seeders/
└── factories/
docs/                      # Dokumentasi & diagram use case
resources/views/           # Blade: admin/, guru/, siswa/, partials/
routes/web.php             # Seluruh rute aplikasi
tests/                     # Unit & Feature test
```

## 🌐 Deployment

Contoh alamat deployment proyek: `https://sistem-ektrakulikuler.ethiodeploy.app`

Untuk produksi, pastikan `APP_ENV=production`, `APP_DEBUG=false`, dan `SESSION_SECURE_COOKIE=true` bila memakai HTTPS.

---

**AKTIVIA — Kelola Ekstrakurikuler Lebih Mudah, Terstruktur, dan Digital.**
