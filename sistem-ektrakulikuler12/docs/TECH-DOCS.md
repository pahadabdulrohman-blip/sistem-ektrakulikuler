# AKTIVIA — TECHNICAL DOCUMENTATION

**Sistem Informasi Ekstrakurikuler Berbasis Web**

| Field | Keterangan |
|---|---|
| Dokumen | Technical Documentation / Dokumentasi Teknis |
| Aplikasi | AKTIVIA — Sistem Informasi Ekstrakurikuler |
| Versi | 1.0 |
| Tanggal | 19 November 2026 |
| Framework | Laravel 12 |
| Audiens | Developer, maintainer, tim IT sekolah |
| Status | Final untuk kondisi kode saat ini |

---

## Riwayat Revisi

| Versi | Tanggal | Keterangan | Penulis |
|---|---|---|---|
| 1.0 | 19 November 2026 | Penyusunan dokumentasi teknis sistem | Tim Pengembang |

---

## Daftar Isi

1. [Ringkasan Sistem](#1-ringkasan-sistem)
2. [Persyaratan Sistem](#2-persyaratan-sistem)
3. [Instalasi dan Konfigurasi](#3-instalasi-dan-konfigurasi)
4. [Struktur Direktori](#4-struktur-direktori)
5. [Arsitektur Aplikasi](#5-arsitektur-aplikasi)
6. [Database](#6-database)
7. [Model dan Relasi](#7-model-dan-relasi)
8. [Controller](#8-controller)
9. [Middleware dan Otorisasi](#9-middleware-dan-otorisasi)
10. [Rute Aplikasi](#10-rute-aplikasi)
11. [Manajemen File dan Storage](#11-manajemen-file-dan-storage)
12. [Keamanan](#12-keamanan)
13. [Penanganan Error dan Logging](#13-penanganan-error-dan-logging)
14. [Pengujian](#14-pengujian)
15. [Deployment](#15-deployment)
16. [Pemeliharaan](#16-pemeliharaan)
17. [Perubahan Terbaru](#17-perubahan-terbaru)
18. [Utang Teknis](#18-utang-teknis)
19. [Lampiran](#19-lampiran)

---

## 1. Ringkasan Sistem

AKTIVIA adalah aplikasi web berbasis Laravel 12 yang digunakan untuk mengelola kegiatan ekstrakurikuler sekolah. Sistem melibatkan tiga peran dengan hak akses berbeda: **Admin**, **Guru**, dan **Siswa**.

### 1.1 Teknologi Stack

| Lapisan | Teknologi |
|---|---|
| Backend | PHP 8.2, Laravel 12.72.0 |
| Database | MySQL (aktif), SQLite (opsional/testing) |
| Template | Blade |
| Frontend | HTML5, CSS3, JavaScript, Font Awesome, Vite 6, Tailwind CSS 4 |
| Testing | PHPUnit 11 |
| Tool | Composer, npm, Git, Laravel Tinker, Pail, Pint |

### 1.2 Fitur Teknis Utama

- Autentikasi berbasis session dengan tiga role.
- Middleware `role` untuk pembatasan akses.
- Rate limiting pada login, registrasi, dan permintaan password.
- Upload foto profil ke storage privat.
- Galeri foto ekskul ke storage publik dengan symlink.
- Index unik pada database untuk mencegah duplikat transaksi.
- Header keamanan global melalui middleware.

---

## 2. Persyaratan Sistem

### 2.1 Lingkungan Pengembangan

| Komponen | Versi Minimum |
|---|---|
| PHP | 8.2 |
| Composer | 2.x |
| MySQL / MariaDB | 5.7 / 10.x |
| Node.js | 18 LTS |
| npm | 9 |
| Web server | PHP built-in server / Apache / Nginx |

### 2.2 Ekstensi PHP yang Diperlukan

- `pdo_mysql`
- `mbstring`
- `fileinfo`
- `openssl`
- `tokenizer`
- `ctype`
- `json`
- `gd` atau `imagick` (opsional untuk pemrosesan gambar lanjutan)

### 2.3 Konfigurasi Upload

```ini
upload_max_filesize = 10M
post_max_size = 10M
```

Batas aplikasi adalah 10 MB per file. Pastikan batas PHP minimal sama atau lebih besar.

---

## 3. Instalasi dan Konfigurasi

### 3.1 Langkah Instalasi

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

### 3.2 Konfigurasi Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem-ektrakulikuler12
DB_USERNAME=root
DB_PASSWORD=
```

### 3.3 Konfigurasi Penting Lainnya

| Variabel | Nilai Lokal | Catatan |
|---|---|---|
| `APP_ENV` | `local` | `production` saat deploy |
| `APP_DEBUG` | `true` | Matikan di produksi |
| `APP_URL` | `http://127.0.0.1:8000` | Sesuaikan domain produksi |
| `SESSION_DRIVER` | `file` | Bisa `database` untuk produksi |
| `QUEUE_CONNECTION` | `database` | Antrean email reset password |
| `CACHE_STORE` | `database` | Cache aplikasi |
| `FILESYSTEM_DISK` | `local` | Foto profil privat |
| `MAIL_MAILER` | `smtp` | `log` untuk debugging |
| `SESSION_SECURE_COOKIE` | `false` | Wajib `true` bila HTTPS |

### 3.4 Storage Link

```bash
php artisan storage:link
```

Diperlukan agar foto kegiatan pada disk `public` dapat diakses melalui URL `/storage/...`.

---

## 4. Struktur Direktori

```text
app/
├── Http/
│   ├── Controllers/       # Logika bisnis aplikasi
│   └── Middleware/        # RoleMiddleware, SecurityHeaders
├── Mail/                  # PasswordBaruMail
├── Models/                # Model Eloquent
├── Providers/
bootstrap/
├── app.php                # Registrasi middleware & routing
└── cache/
config/
database/
├── migrations/
├── factories/
└── seeders/
docs/
├── MANUAL.md              # User manual
├── TECH-DOCS.md           # Dokumen ini
├── DOKUMENTASI-PROYEK.md
├── PANDUAN-PENGGUNAAN.md
├── TROUBLESHOOTING.md
├── use-case-diagram.png
└── use-case-diagram.html
public/
├── index.php
└── storage/               # Symlink → storage/app/public
resources/
├── css/
├── js/
└── views/
    ├── admin/
    ├── guru/
    ├── siswa/
    ├── ekstrakurikuler/
    ├── partials/
    └── ...
routes/
├── web.php
└── console.php
storage/
├── app/
│   ├── private/foto-profil/
│   └── public/foto-kegiatan/
├── framework/
└── logs/
tests/
├── Unit/
└── Feature/
```

---

## 5. Arsitektur Aplikasi

### 5.1 Pola MVC

```text
Request (HTTP)
    ↓
routes/web.php
    ↓
Middleware (SecurityHeaders → role)
    ↓
Controller
    ↓
Model (Eloquent)  ←→  Database
    ↓
View (Blade)
    ↓
Response (HTML / redirect / file)
```

### 5.2 Alur Request

1. Request masuk melalui `public/index.php`.
2. `bootstrap/app.php` memuat aplikasi dan middleware.
3. `SecurityHeaders` ditambahkan ke semua respons.
4. `RoleMiddleware` memeriksa login dan role bila rute memakai alias `role`.
5. Controller memproses input, memanggil model, dan mengembalikan view/redirect.
6. View Blade dirender dengan data dari controller.

### 5.3 Session

Data session yang digunakan:

| Key | Fungsi |
|---|---|
| `login` | Penanda pengguna sudah login |
| `username` | Identitas unik pengguna |
| `name` | Nama tampilan |
| `role` | `admin`, `guru`, atau `siswa` |

---

## 6. Database

### 6.1 Tabel Utama

| Tabel | Fungsi | Kolom penting |
|---|---|---|
| `users` | Akun pengguna | `username` (unique), `email`, `password`, `role`, `status_pendaftaran`, `kelas`, `tahun_masuk`, `nama_sekolah` |
| `ekstrakurikuler` | Data ekskul | `nama_ekstrakurikuler` (unique), `pembina`, `jadwal`, `deskripsi`, `ikon`, `tempat` |
| `pendaftaran_ekstrakurikulers` | Pilihan ekskul siswa | `username`, `ekstrakurikuler_id` |
| `profile_photos` | Foto profil | `username`, `role`, `photo_path` |
| `ekstrakurikuler_fotos` | Galeri foto kegiatan | `ekstrakurikuler_id`, `foto_path`, `keterangan`, `diunggah_oleh` |
| `penilaians` | Nilai siswa | `username`, `nama_kegiatan`, `nilai`, `keterangan`, `dicatat_oleh` |
| `absensi_siswas` | Absensi siswa | `username`, `nama_kegiatan`, `tanggal`, `status`, `dicatat_oleh` |
| `jadwal_ekstrakurikulers` | Jadwal | `nama_kegiatan`, `jenis`, `tanggal`, `jam_mulai`, `jam_selesai`, `lokasi` |
| `password_requests` | Reset password | `username`, `role`, `status` |
| `sessions`, `cache`, `jobs` | Tabel bawaan Laravel | — |

### 6.2 Relasi

```text
User ──< PendaftaranEkstrakurikuler >── Ekstrakurikuler
                                            │
                                            └──< EkstrakurikulerFoto
```

| Model | Relasi |
|---|---|
| `User` | `hasMany(PendaftaranEkstrakurikuler::class, 'username', 'username')` |
| `Ekstrakurikuler` | `hasMany(PendaftaranEkstrakurikuler::class)` |
| `Ekstrakurikuler` | `hasMany(EkstrakurikulerFoto::class, 'ekstrakurikuler_id')` |
| `EkstrakurikulerFoto` | `belongsTo(Ekstrakurikuler::class)` |

### 6.3 Index Unik

| Nama index | Tabel | Kolom |
|---|---|---|
| `penilaian_unik` | `penilaians` | `username`, `nama_kegiatan` |
| `absensi_unik` | `absensi_siswas` | `username`, `nama_kegiatan`, `tanggal` |
| `jadwal_unik` | `jadwal_ekstrakurikulers` | `nama_kegiatan`, `tanggal`, `jam_mulai` |
| — | `profile_photos` | `username`, `role` |
| — | `pendaftaran_ekstrakurikulers` | `username`, `ekstrakurikuler_id` |
| `ekstrakurikuler_nama_unique` | `ekstrakurikuler` | `nama_ekstrakurikuler` |

---

## 7. Model dan Relasi

| Model | Tanggung Jawab | Catatan Penting |
|---|---|---|
| `User` | Akun dan identitas | `getKelasSaatIniAttribute()` menghitung kenaikan kelas otomatis; `password` di-hash |
| `Ekstrakurikuler` | Data ekskul | Memakai tabel `ekstrakurikuler` (singular); punya helper normalisasi nama |
| `PendaftaranEkstrakurikuler` | Pilihan siswa | FK `ekstrakurikuler_id` dengan `cascadeOnDelete` |
| `ProfilePhoto` | Foto profil | Accessor `$url` → `route('profil.foto', basename($photo_path))` |
| `EkstrakurikulerFoto` | Foto kegiatan | Accessor `$url` → `Storage::disk('public')->url($foto_path)` |
| `Penilaian` | Nilai | `predikatDariNilai()`, `formatNilai()`, trait `RapikanNama` |
| `AbsensiSiswa` | Kehadiran | Trait `RapikanNama` |
| `JadwalEkstrakurikuler` | Jadwal | Validasi jam dan duplikat di controller |
| `PasswordRequest` | Permintaan reset | Status `menunggu` / selesai |
| `Presensi` | Model legacy | Tidak dipakai; tabel `presensis` juga tidak aktif |

Trait `App\Models\Concerns\RapikanNama` digunakan untuk menormalkan spasi, NBSP, dan huruf kecil pada nama kegiatan.

---

## 8. Controller

| Controller | Method utama | Tanggung jawab |
|---|---|---|
| `EkstrakurikulerController` | `login`, `prosesLogin`, `ekstrakurikuler`, `simpanPilihan`, `batalkanPilihan`, `detail`, `profil`, `penilaian`, `laporanGuru`, `laporanAdmin` | Autentikasi, pilihan ekskul, detail, profil, laporan |
| `AdminEkstrakurikulerController` | `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` | CRUD ekskul admin + seed 6 data awal |
| `GuruEkstrakurikulerController` | `index`, `create`, `store`, `edit`, `update`, `destroy` | CRUD ekskul guru |
| `AdminDataController` | `guru`, `siswa` | Data pengguna |
| `AdminPenerimaanSiswaController` | `index`, `terima`, `tolak` | Status pendaftaran siswa |
| `AdminGuruController` | `index`, `store`, `resetPassword`, `destroy` | Kelola akun guru |
| `AdminPasswordRequestController` | `index`, `reset`, `destroy` | Reset password + email |
| `JadwalEkstrakurikulerController` | `index`, `store`, `update`, `destroy` | Jadwal kegiatan |
| `AbsensiController` | `index`, `simpan` | Rekap & simpan absensi |
| `PenilaianController` | `index`, `adminIndex`, `simpan`, `update`, `hapus` | Penilaian + pembatasan kepemilikan |
| `RegisterController` | `index`, `store` | Registrasi siswa |
| `ProfilePhotoController` | `upload` | Upload/ganti foto profil |
| `FotoKegiatanController` | `store`, `destroy` | Galeri foto ekskul |

> `sistemekstrakulikulerControler.php` adalah file legacy yang mendeklarasikan ulang class `EkstrakurikulerController` dengan data hard-coded. Tidak dipakai rute aktif.

---

## 9. Middleware dan Otorisasi

### 9.1 Pendaftaran (`bootstrap/app.php`)

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

### 9.2 RoleMiddleware

- Memeriksa `session('login')`; jika tidak ada → redirect ke `login`.
- Menormalkan role menjadi huruf kecil.
- Untuk siswa: memastikan `User` ada dan `status_pendaftaran === 'diterima'`.
- Jika role tidak sesuai → redirect ke dashboard role yang bersangkutan.

### 9.3 SecurityHeaders

Menambahkan header:

| Header | Nilai |
|---|---|
| `X-Content-Type-Options` | `nosniff` |
| `X-Frame-Options` | `SAMEORIGIN` |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |
| `Permissions-Policy` | `camera=(), microphone=(), geolocation=()` |
| `Cross-Origin-Opener-Policy` | `same-origin` |
| `Strict-Transport-Security` | Hanya saat HTTPS |

---

## 10. Rute Aplikasi

### 10.1 Ringkasan Berdasarkan Grup

| Grup | Prefix | Middleware | Jumlah rute (approx.) |
|---|---|---|---|
| Umum | — | — | 16 |
| Admin | `/admin` | `role:admin` | 23 |
| Guru | `/guru` | `role:guru` | 19 |
| Siswa | — | `role:siswa` | 8 |
| Foto | — | `role:...` | 4 |
| Utilitas | — | — | 2 |

### 10.2 Rute Penting

| Method | URI | Nama | Keterangan |
|---|---|---|---|
| GET | `/login` | `login` | Form login |
| POST | `/login` | `login.process` | Proses login |
| GET | `/dashboard` | `dashboard` | Redirect per role |
| POST | `/profil/foto/upload` | `profil.foto.upload` | Upload foto profil |
| GET | `/profil/foto/{filename}` | `profil.foto` | Sajikan foto privat |
| POST | `/ekstrakurikuler/{id}/foto` | `ekstrakurikuler.foto.store` | Upload galeri |
| DELETE | `/ekstrakurikuler/{id}/foto/{foto}` | `ekstrakurikuler.foto.hapus` | Hapus galeri |
| POST | `/ekstrakurikuler/pilih` | `ekstrakurikuler.simpan` | Simpan pilihan siswa |
| POST | `/logout` | `logout` | Logout (CSRF) |

Daftar lengkap 72 rute ada di [`DOKUMENTASI-PROYEK.md`](DOKUMENTASI-PROYEK.md#10-daftar-rute) dan sumber kebenarannya adalah `routes/web.php`.

---

## 11. Manajemen File dan Storage

| Fitur | Disk | Lokasi | Akses |
|---|---|---|---|
| Foto profil | `local` | `storage/app/private/foto-profil/` | Route `/profil/foto/{filename}` (login required) |
| Foto kegiatan | `public` | `storage/app/public/foto-kegiatan/{id}/` | URL `/storage/...` via symlink |

### 11.1 Foto Profil

- Validasi: `required|image|mimes:jpg,jpeg,png,webp|max:10240`.
- `updateOrCreate` berdasarkan `username + role`.
- File lama dihapus dari disk `local` dan `public`.
- `basename()` digunakan untuk mencegah path traversal.
- Cache-buster `?v={updated_at}` ditambahkan di view.

### 11.2 Foto Kegiatan

- Maksimal 10 foto per unggahan, tiap foto maksimal 10 MB.
- Keterangan opsional maksimal 150 karakter.
- Hanya admin/guru yang dapat mengunggah dan menghapus.
- Hapus ekskul juga menghapus folder `foto-kegiatan/{id}/`.

---

## 12. Keamanan

| Mekanisme | Implementasi |
|---|---|
| CSRF | `@csrf` pada semua form POST/PUT/DELETE |
| Rate limit login | 5/menit per username+IP; 30/menit per IP |
| Rate limit lain | Register 6/menit; lupa password 5/menit |
| Role access | `RoleMiddleware` + status siswa |
| Header keamanan | `SecurityHeaders` global |
| Path traversal | `basename()` pada nama file foto |
| Duplikat data | Index unik database + validasi controller |
| File privat | Foto profil tidak bisa diakses langsung via `/storage` |
| Validasi upload | MIME, ekstensi, ukuran, jumlah file |
| Error route | `/tes-error-500` hanya di environment `local` |

---

## 13. Penanganan Error dan Logging

- Log aplikasi: `storage/logs/laravel.log`.
- Halaman error khusus: `resources/views/errors/403.blade.php`, `404.blade.php`, `500.blade.php`.
- `APP_DEBUG=true` menampilkan detail error di lokal; matikan di produksi.
- Route `/tes-error-500` tersedia hanya di lokal untuk menguji halaman 500.

---

## 14. Pengujian

### 14.1 Perintah

```bash
php artisan test
php artisan test --filter=FotoKegiatan
php artisan test --filter=KeamananDasarTest
```

### 14.2 Cakupan

| File | Fokus |
|---|---|
| `tests/Unit/ExampleTest.php` | Test dasar |
| `tests/Feature/LoginRouteTest.php` | Rute login |
| `tests/Feature/KeamananDasarTest.php` | Header, rate limit, foto privat, penjaga newline `routes/web.php` |
| `tests/Feature/FotoKegiatanTest.php` | Upload, validasi, hapus, isolasi ekskul, akses siswa, tampilan galeri |
| `tests/Feature/ExampleTest.php` | Test bawaan (belum disesuaikan) |
| `tests/Feature/CsrfProtectionTest.php` | Uji CSRF (belum sesuai ekspektasi) |

### 14.3 Hasil Terakhir

```text
Tests: 15 passed, 2 failed (65 assertions)
```

Dua kegagalan bersifat bawaan:

- `ExampleTest`: `GET /` menghasilkan 302, bukan 200.
- `CsrfProtectionTest`: tidak menghasilkan 419 seperti yang diharapkan.

> `phpunit.xml` saat ini tidak mengaktifkan `sqlite :memory:`, sehingga test memakai database dari `.env`.

---

## 15. Deployment

### 15.1 Checklist

```bash
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 15.2 Environment Produksi

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda
SESSION_SECURE_COOKIE=true
```

### 15.3 Izin Folder

Pastikan writable:

- `storage/`
- `bootstrap/cache/`

---

## 16. Pemeliharaan

### 16.1 Command Rutin

| Command | Fungsi |
|---|---|
| `php artisan optimize:clear` | Bersihkan semua cache |
| `php artisan view:cache` | Kompilasi ulang Blade |
| `php artisan queue:work` | Proses email reset password |
| `php artisan storage:link` | Pastikan symlink storage ada |

### 16.2 Backup

- Backup database MySQL secara berkala.
- Backup folder `storage/app/private/foto-profil/`.
- Backup folder `storage/app/public/foto-kegiatan/`.
- Simpan `.env` di tempat aman (jangan di repository).

### 16.3 Monitoring

- Pantau `storage/logs/laravel.log`.
- Pantau kegagalan job pada tabel `failed_jobs`.
- Pantau kapasitas storage untuk foto.

---

## 17. Perubahan Terbaru

| Tanggal | Perubahan |
|---|---|
| 2026-11-18 | Batas upload foto profil & kegiatan 2 MB → 10 MB |
| 2026-11-18 | Cache-buster `?v=timestamp` pada tampilan foto profil |
| 2026-11-18 | Galeri siswa dibuat view-only, sidebar cukup `SISWA` |
| 2026-11-18 | Perbaikan kritis: baris kosong sebelum `<?php` di `routes/web.php` dihapus karena merusak semua respons gambar |
| 2026-11-18 | Tes regresi penjaga awalan file route ditambahkan |
| 2026-11-19 | Perbaikan kritis: middleware dikembalikan ke `app/Http/Middleware/` setelah sempat salah folder (error 500) |
| 2026-11-19 | Penyusunan `MANUAL.md` dan `TECH-DOCS.md` |

---

## 18. Utang Teknis

1. **Commit perubahan middleware.** Folder `app/Http/Middleware/` masih perlu dipastikan masuk repository; penghapusan folder lama di `app/Http/Controllers/Middleware/` belum tentu tercatat bila belum di-commit.
2. **Controller legacy.** `sistemekstrakulikulerControler.php` duplication class dan sebaiknya dihapus.
3. **Migration duplikat.** Beberapa migration menambahkan kolom yang sama tanpa `hasColumn()`; aman pada database yang sudah termigrasi, berisiko untuk instalasi dari kosong.
4. **Seeder belum lengkap.** `UserFactory` belum mengisi `username`, `role`, dan `status_pendaftaran`.
5. **Tabel tidak aktif.** `presensis` dan `ekstrakurikulers` (plural) adalah sisa pengembangan lama.
6. **phpunit.xml** masih mengomentari konfigurasi SQLite in-memory.
7. **Baris kosong sebelum `<?php`** masih ada di beberapa file migration dan `siswa/profil.blade.php`; tidak memengaruhi gambar, tetapi sebaiknya dibersihkan.

---

## 19. Lampiran

| Dokumen | Path |
|---|---|
| User Manual | [`MANUAL.md`](MANUAL.md) |
| Dokumentasi Proyek | [`DOKUMENTASI-PROYEK.md`](DOKUMENTASI-PROYEK.md) |
| Panduan Penggunaan | [`PANDUAN-PENGGUNAAN.md`](PANDUAN-PENGGUNAAN.md) |
| Troubleshooting | [`TROUBLESHOOTING.md`](TROUBLESHOOTING.md) |
| Diagram Use Case (PNG) | [`use-case-diagram.png`](use-case-diagram.png) |
| Diagram Use Case (HTML) | [`use-case-diagram.html`](use-case-diagram.html) |
| Sumber kebenaran rute | `routes/web.php` |
| Sumber kebenaran schema | `database/migrations/` |

---

*AKTIVIA — Technical Documentation v1.0*
