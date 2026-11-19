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
| Mode autentikasi | Web: session login (`session('login')`, `username`, `role`); API: bearer token |
| REST API | `/api/v1` — 45 endpoint JSON, cermin lengkap fitur web |
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

### REST API v1
- 45 endpoint JSON untuk seluruh fitur di atas (prefix `/api/v1`).
- Login bearer token sederhana; token dicabut saat logout.
- Hak akses per role mengikuti aplikasi web (`admin`, `guru`, `siswa`).
- Format respons konsisten: `success`, `message`, `data`, `errors`.

## 📚 Dokumentasi

| Dokumen | Format | Isi |
|---|---|---|
| [AKTIVIA User Manual](docs/AKTIVIA-User-Manual.docx) | **Word (.docx)** | Manual pengguna akhir — siap dibuka di Microsoft Word dan dicetak (9 halaman) |
| [AKTIVIA Technical Documentation](docs/AKTIVIA-Technical-Documentation.docx) | **Word (.docx)** | Dokumentasi teknis lengkap — siap dibuka di Word (17 halaman) |
| [AKTIVIA REST API](docs/AKTIVIA-REST-API.docx) | **Word (.docx)** | Referensi REST API v1 — siap dibuka di Word (12 halaman) |
| [REST API Docs](docs/API-DOCS.md) | Markdown | Sumber referensi API: autentikasi, 45 endpoint, contoh request/respons, error, rate limit |
| [User Manual](docs/MANUAL.md) | Markdown | Sumber manual: prosedur Admin, Guru, Siswa, pengelolaan foto, glosarium |
| [Technical Docs](docs/TECH-DOCS.md) | Markdown | Sumber tech docs: arsitektur, database, model, controller, middleware, rute, REST API, keamanan, deployment |
| [Dokumentasi Proyek](docs/DOKUMENTASI-PROYEK.md) | Markdown | Dokumentasi lengkap gabungan (arsitektur, fitur, rute, database, pengujian) |
| [Panduan Penggunaan](docs/PANDUAN-PENGGUNAAN.md) | Markdown | Panduan ringkas cara pakai aplikasi |
| [Troubleshooting](docs/TROUBLESHOOTING.md) | Markdown | Masalah umum dan solusinya |
| [Diagram Use Case](docs/use-case-diagram.png) | Gambar | Diagram use case sistem (versi HTML: `docs/use-case-diagram.html`) |

> File `.docx` dihasilkan dari sumber Markdown oleh [`docs/generate-docx.ps1`](docs/generate-docx.ps1). Untuk memperbarui setelah mengedit Markdown, jalankan: `powershell -ExecutionPolicy Bypass -File docs\generate-docx.ps1`

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

Buka `http://127.0.0.1:8000` untuk aplikasi web, atau `http://127.0.0.1:8000/api/v1` untuk REST API.

> Migrasi `add_api_token_to_users_table` ikut berjalan dalam `php artisan migrate` dan diperlukan agar login API bisa menerbitkan token.

> Detail lengkap (termasuk catatan untuk XAMPP dan produksi) ada di [Dokumentasi Proyek](docs/DOKUMENTASI-PROYEK.md#5-instalasi).

## 🧪 Pengujian

```bash
php artisan test
php artisan test --filter=V1ApiTest   # khusus REST API
```

Terakhir dijalankan: **22 test lulus** (termasuk 7 test REST API), 2 test bawaan masih gagal (`ExampleTest` dan `CsrfProtectionTest`) — lihat [catatan pengujian](docs/DOKUMENTASI-PROYEK.md#14-pengujian).

## 🔐 Catatan Keamanan

- Login dibatasi **5 percobaan/menit per username+IP** dan **30 percobaan/menit per IP**.
- Registrasi dibatasi **6 percobaan/menit**, lupa password **5 percobaan/menit**.
- Logout wajib **POST + CSRF**; GET hanya menampilkan halaman konfirmasi.
- Foto profil disimpan **privat** di `storage/app/private/foto-profil` dan hanya bisa diakses lewat route terautentikasi.
- Header keamanan ditambahkan global oleh `SecurityHeaders`.
- Batas unik diterapkan di database untuk penilaian, absensi, jadwal, dan pendaftaran.
- Token API disimpan sebagai hash SHA-256 di `users.api_token`; token plain hanya muncul sekali saat login.
- Endpoint API dilindungi middleware `api.token` dan `api.role`; error API dirender JSON (bukan halaman web).

## 📂 Struktur Singkat

```text
app/
├── Http/
│   ├── Controllers/       # Controller web + Api/V1/ (REST API)
│   └── Middleware/        # RoleMiddleware, SecurityHeaders, ApiTokenAuth, ApiRole
├── Mail/                  # PasswordBaruMail
├── Models/                # User, Ekstrakurikuler, dll.
database/
├── migrations/
├── seeders/
└── factories/
docs/                      # Dokumentasi & diagram use case
resources/views/           # Blade: admin/, guru/, siswa/, partials/
routes/
├── web.php                # Rute aplikasi web (Blade)
└── api.php                # 45 rute REST API v1
tests/
├── Unit/
└── Feature/
    └── Api/               # V1ApiTest.php
```

## 🌐 Deployment

Contoh alamat deployment proyek: `https://sistem-ektrakulikuler.ethiodeploy.app`

Untuk produksi, pastikan `APP_ENV=production`, `APP_DEBUG=false`, dan `SESSION_SECURE_COOKIE=true` bila memakai HTTPS.

---

**AKTIVIA — Kelola Ekstrakurikuler Lebih Mudah, Terstruktur, dan Digital.**
