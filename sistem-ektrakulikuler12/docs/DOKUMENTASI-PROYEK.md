# DOKUMENTASI PROYEK — AKTIVIA

**Sistem Informasi Ekstrakurikuler Berbasis Web**

| Keterangan | Nilai |
|---|---|
| Nama proyek | AKTIVIA |
| Nama folder | `sistem-ektrakulikuler12` |
| Framework | Laravel 12 (12.72.0 saat dokumentasi dibuat) |
| Bahasa pemrograman | PHP 8.2 |
| Database | MySQL (`.env` aktif), SQLite didukung oleh `.env.example` |
| Frontend | Blade, HTML5, CSS3, JavaScript, Vite 6, Tailwind CSS 4 |
| Pola arsitektur | Model–View–Controller (MVC) |
| Autentikasi | Web: session-based login; API: bearer token dengan role `admin`, `guru`, `siswa` |
| REST API | `/api/v1` — 45 endpoint JSON (lihat [API-DOCS.md](API-DOCS.md)) |
| Akses lokal | `http://127.0.0.1:8000` |
| Diagram | [use-case-diagram.png](use-case-diagram.png) / [use-case-diagram.html](use-case-diagram.html) |

---

## 1. Latar Belakang

Pengelolaan kegiatan ekstrakurikuler di sekolah masih banyak dilakukan secara manual, mulai dari pendaftaran siswa, pencatatan absensi, penilaian, hingga dokumentasi foto kegiatan. Hal ini menyebabkan data tersebar, sulit direkap, dan tidak mudah diakses oleh pihak yang membutuhkan.

AKTIVIA dibuat untuk menyatukan seluruh proses tersebut dalam satu aplikasi web dengan pembagian hak akses yang jelas antara Admin, Guru, dan Siswa.

## 2. Tujuan

1. Mendigitalisasi proses pendaftaran dan pengelolaan ekstrakurikuler.
2. Memberikan guru alat bantu untuk mengelola jadwal, absensi, dan penilaian.
3. Memberikan siswa akses untuk melihat kegiatan, jadwal, nilai, dan foto kegiatan.
4. Memberikan admin kontrol penuh atas data sekolah dan laporan.
5. Menerapkan keamanan dasar pada proses login, session, dan unggahan file.

## 3. Ruang Lingkup Fitur

### 3.1 Admin

| Fitur | Keterangan |
|---|---|
| Dashboard | Ringkasan statistik ekskul, guru, siswa, dan pendaftaran |
| Ekstrakurikuler | Tambah, ubah, hapus, dan lihat detail ekskul beserta galeri foto |
| Data guru & siswa | Lihat daftar pengguna dan sebaran kelas |
| Penerimaan siswa | Filter status pendaftaran, terima atau tolak pendaftar |
| Akun guru | Buat akun guru, reset password, hapus akun |
| Permintaan password | Setujui reset password dan kirim password baru via email |
| Penilaian & absensi | Lihat rekap seluruh siswa |
| Laporan | Laporan lengkap dengan agregat `COUNT`, `SUM`, `AVG` |
| Profil | Lihat profil dan ganti foto profil |

### 3.2 Guru

| Fitur | Keterangan |
|---|---|
| Dashboard | Ringkasan kegiatan binaan |
| Ekstrakurikuler | Kelola ekskul binaan, termasuk unggah/hapus foto kegiatan |
| Jadwal | Tambah, ubah, hapus jadwal kegiatan (wajib/gabungan) |
| Absensi | Catat kehadiran siswa per kegiatan dan tanggal |
| Penilaian | Input, ubah, dan hapus nilai siswa |
| Laporan | Lihat laporan terkait kegiatan binaan |
| Profil | Lihat profil dan ganti foto profil |

### 3.3 Siswa

| Fitur | Keterangan |
|---|---|
| Registrasi | Daftar sebagai siswa dengan email `@gmail.com`; status awal `menunggu` |
| Dashboard | Ringkasan pilihan ekskul dan informasi akun |
| Ekstrakurikuler | Lihat daftar ekskul, pilih maksimal 2, atau batalkan pilihan |
| Detail ekskul | Lihat deskripsi dan **galeri foto tanpa tombol kelola** |
| Jadwal | Lihat jadwal kegiatan |
| Penilaian | Lihat nilai milik sendiri beserta predikat |
| Profil | Lihat profil dan ganti foto profil |

---

## 4. Teknologi yang Digunakan

| Lapisan | Teknologi |
|---|---|
| Backend | PHP 8.2, Laravel 12 |
| Database | MySQL / MariaDB (SQLite untuk testing lokal) |
| Templating | Blade |
| Frontend | HTML5, CSS3, JavaScript, Font Awesome, Bootstrap/mobile helper |
| Build asset | Vite 6, Tailwind CSS 4, Axios |
| Testing | PHPUnit 11 |
| Tool pendukung | Composer, npm, Git, Laravel Tinker, Pail, Pint |

Dependensi utama tercantum di `composer.json`; dependensi frontend di `package.json`.

---

## 5. Instalasi

### 5.1 Prasyarat

- PHP minimal 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`).
- Composer.
- MySQL/MariaDB atau SQLite.
- Node.js dan npm.
- Web server atau PHP built-in server.

### 5.2 Langkah Instalasi

```bash
# 1. Clone / masuk ke direktori proyek
cd sistem-ektrakulikuler12

# 2. Install dependensi PHP
composer install

# 3. Salin file environment
copy .env.example .env        # Windows PowerShell
# cp .env.example .env        # Linux/macOS

# 4. Generate APP_KEY
php artisan key:generate

# 5. Buat database MySQL
#    CREATE DATABASE sistem-ektrakulikuler12;

# 6. Edit .env sesuai database
```

Contoh konfigurasi `.env` untuk MySQL lokal:

```env
APP_NAME="AKTIVIA"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem-ektrakulikuler12
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
QUEUE_CONNECTION=database
CACHE_STORE=database
FILESYSTEM_DISK=local
```

```bash
# 7. Migrasi database
php artisan migrate

# 8. Install & build frontend
npm install
npm run build

# 9. Jalankan aplikasi
php artisan serve
```

Aplikasi dapat diakses di `http://127.0.0.1:8000`.

### 5.3 Catatan XAMPP

Jika menggunakan XAMPP, pastikan:

- Modul PHP `fileinfo`, `mbstring`, dan `pdo_mysql` aktif.
- `upload_max_filesize` dan `post_max_size` minimal 10 MB (batas unggah aplikasi adalah 10 MB per foto).
- Server dijalankan dengan `php artisan serve`, bukan dengan membuka folder `public` langsung melalui `localhost`, agar route Blade dan storage privat bekerja.

### 5.4 Catatan Produksi

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda
SESSION_SECURE_COOKIE=true
```

- Salin `.env.example` menjadi `.env` (file `.env` tidak ikut di Git), lalu jalankan `php artisan key:generate`.
- Untuk SQLite, buat file `database/database.sqlite` terlebih dahulu. Untuk MySQL, buat database dan isi `DB_*`.
- Jalankan `php artisan migrate --force` — ini membuat tabel `users`, `cache`, dan `sessions` (tabel `sessions` dibuat di dalam migrasi `create_users_table`).
- Jalankan `php artisan storage:link` agar foto kegiatan bisa diakses.
- Jalankan `php artisan optimize:clear` setelah mengubah `.env`, baru `php artisan config:cache && php artisan route:cache && php artisan view:cache`.
- Pastikan folder `storage/` dan `bootstrap/cache/` dapat ditulis oleh web server.
- Document root mengarah ke folder `public/`.
- Gunakan HTTPS karena `SESSION_SECURE_COOKIE` wajib aktif pada produksi.
- Jika login menghasilkan 500, lihat [TROUBLESHOOTING.md §12](TROUBLESHOOTING.md#12-error-500-saat-login-setelah-deploy).

---

## 6. Konfigurasi Lingkungan

| Variabel | Default `.env.example` | Keterangan |
|---|---|---|
| `DB_CONNECTION` | `sqlite` | Aktif di lokal: `mysql` |
| `SESSION_DRIVER` | `database` | Aktif di lokal: `file` |
| `QUEUE_CONNECTION` | `database` | Antrean jobs |
| `CACHE_STORE` | `database` | Cache aplikasi |
| `FILESYSTEM_DISK` | `local` | Disk default |
| `MAIL_MAILER` | `log` | Aktif di lokal: `smtp` (untuk reset password) |
| `SESSION_SECURE_COOKIE` | `false` | Wajib `true` bila HTTPS |
| `APP_DEBUG` | `true` | Matikan di produksi |

> **Penting:** `.env` aktif berisi kredensial lokal dan tidak boleh dimasukkan ke repository. Gunakan `.env.example` sebagai template.

---

## 7. Struktur Direktori

```text
sistem-ektrakulikuler12/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controller aplikasi
│   │   └── Middleware/           # RoleMiddleware, SecurityHeaders
│   ├── Mail/                     # PasswordBaruMail
│   ├── Models/                   # Model Eloquent
│   └── Providers/
├── bootstrap/
│   ├── app.php                   # Registrasi middleware & routing
│   └── cache/
├── config/                       # Konfigurasi Laravel
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── docs/                         # Dokumentasi & diagram use case
├── public/
│   ├── index.php
│   └── storage/                  # Symlink ke storage/app/public
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── guru/
│       ├── siswa/
│       ├── ekstrakurikuler/
│       ├── partials/
│       └── ...
├── routes/
│   ├── web.php
│   └── console.php
├── storage/
│   ├── app/
│   │   ├── private/foto-profil/  # Foto profil (tidak publik)
│   │   └── public/foto-kegiatan/ # Foto kegiatan (publik via symlink)
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Unit/
│   └── Feature/
├── .env.example
├── composer.json
├── package.json
├── phpunit.xml
└── README.md
```

---

## 8. Database

### 8.1 Tabel Utama

| Tabel | Fungsi | Kolom penting |
|---|---|---|
| `users` | Akun admin, guru, siswa | `username` (unique), `email`, `password`, `role`, `status_pendaftaran`, `kelas`, `tahun_masuk`, `nama_sekolah` |
| `ekstrakurikuler` | Data ekskul (nama tabel singular) | `nama_ekstrakurikuler` (unique), `pembina`, `jadwal`, `deskripsi`, `ikon`, `tempat` |
| `pendaftaran_ekstrakurikulers` | Pilihan ekskul siswa | `username`, `ekstrakurikuler_id` (FK cascade), unique `(username, ekstrakurikuler_id)` |
| `profile_photos` | Foto profil per username+role | `username`, `role`, `photo_path`, unique `(username, role)` |
| `ekstrakurikuler_fotos` | Galeri foto kegiatan | `ekstrakurikuler_id` (FK cascade), `foto_path`, `keterangan`, `diunggah_oleh` |
| `penilaians` | Nilai siswa | `username`, `nama_kegiatan`, `nilai`, `keterangan`, `dicatat_oleh`, unique `penilaian_unik` |
| `absensi_siswas` | Absensi siswa | `username`, `nama_kegiatan`, `tanggal`, `status`, `dicatat_oleh`, unique `absensi_unik` |
| `jadwal_ekstrakurikulers` | Jadwal kegiatan | `nama_kegiatan`, `jenis`, `tanggal`, `jam_mulai`, `jam_selesai`, `lokasi`, unique `jadwal_unik` |
| `password_requests` | Permintaan reset password | `username`, `role`, `status` |
| `sessions`, `cache`, `jobs` | Tabel bawaan Laravel | — |

### 8.2 Relasi Penting

- `User` → `hasMany(PendaftaranEkstrakurikuler::class, 'username', 'username')`
- `Ekstrakurikuler` → `hasMany(PendaftaranEkstrakurikuler::class)`
- `Ekstrakurikuler` → `hasMany(EkstrakurikulerFoto::class, 'ekstrakurikuler_id')`
- `EkstrakurikulerFoto` → `belongsTo(Ekstrakurikuler::class)`

### 8.3 Index Unik (pencegahan duplikat)

| Nama index | Tabel | Kolom |
|---|---|---|
| `penilaian_unik` | `penilaians` | `username`, `nama_kegiatan` |
| `absensi_unik` | `absensi_siswas` | `username`, `nama_kegiatan`, `tanggal` |
| `jadwal_unik` | `jadwal_ekstrakurikulers` | `nama_kegiatan`, `tanggal`, `jam_mulai` |
| — | `profile_photos` | `username`, `role` |
| — | `pendaftaran_ekstrakurikulers` | `username`, `ekstrakurikuler_id` |
| `ekstrakurikuler_nama_unique` | `ekstrakurikuler` | `nama_ekstrakurikuler` |

---

## 9. Autentikasi dan Hak Akses

### 9.1 Proses Login

1. Pengguna membuka `/login`.
2. `EkstrakurikulerController@prosesLogin`memeriksa kredensial.
3. Rate limit diterapkan: **5 percobaan/menit per username + IP** dan **30 percobaan/menit per IP**.
4. Untuk siswa, status pendaftaran harus `diterima`; selain itu ditolak dengan pesan sesuai status.
5. Session disimpan: `login`, `username`, `name`, `role`.
6. Redirect ke dashboard sesuai role.

### 9.2 Middleware

| Middleware | Jenis | Fungsi |
|---|---|---|
| `RoleMiddleware` | Alias `role` | Cek login, normalisasi role, validasi status siswa, redirect bila role tidak sesuai |
| `SecurityHeaders` | Global | Menambahkan header keamanan pada semua respons |

Pendaftaran ada di `bootstrap/app.php`:

```php
$middleware->append(\App\Http\Middleware\SecurityHeaders::class);

$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

Contoh pemakaian:

```php
Route::middleware('role:admin')->group(function () { ... });
Route::middleware('role:admin,guru')->group(function () { ... });
```

### 9.3 Logout

- `GET /logout` → halaman konfirmasi (`logout.confirm`).
- `POST /logout` → invalidate session + regenerate CSRF token.
- Form logout memakai `@csrf` melalui partial `partials/logout-form.blade.php`.

### 9.4 Autentikasi REST API

- `POST /api/v1/login` menerbitkan token plain yang hanya tampil sekali.
- Database menyimpan `hash('sha256', token)` pada kolom `users.api_token`.
- Header yang diterima: `Authorization: Bearer <token>` atau `X-API-Token: <token>`.
- Middleware `api.token` memvalidasi token dan status siswa; `api.role` membatasi role.
- `POST /api/v1/logout` mencabut token yang sedang dipakai.
- Token tidak memakai cookie/session sehingga tidak memerlukan CSRF.

---

## 10. Daftar Rute

### 10.1 Umum

| Method | URI | Nama | Keterangan |
|---|---|---|---|
| GET | `/` | `home` | Redirect ke login |
| GET | `/login` | `login` | Form login |
| POST | `/login` | `login.process` | Proses login |
| GET | `/register` | `register` | Form registrasi siswa |
| POST | `/register` | `register.store` | Simpan pendaftar (throttle 6/menit) |
| GET | `/dashboard` | `dashboard` | Redirect ke dashboard sesuai role |
| GET | `/dashboard-admin` | `dashboard.admin` | Dashboard admin (`role:admin`) |
| GET | `/dashboard-guru` | `dashboard.guru` | Dashboard guru (`role:guru`) |
| GET | `/dashboard-siswa` | `dashboard.siswa` | Dashboard siswa (`role:siswa`) |
| GET | `/laporan` | `laporan` | Redirect ke dashboard |
| GET | `/lupa-password` | `password.request` | Form lupa password |
| POST | `/lupa-password` | `password.email` | Buat permintaan reset (throttle 5/menit) |
| GET | `/hubungi-admin` | `hubungi.admin` | Halaman kontak admin |
| GET | `/logout` | `logout.confirm` | Konfirmasi logout |
| POST | `/logout` | `logout` | Proses logout |
| GET | `/tes-error-500` | — | Uji error 500 (hanya di environment `local`) |

### 10.2 Admin — prefix `/admin`, middleware `role:admin`

| Method | URI | Nama | Keterangan |
|---|---|---|---|
| GET | `/admin/ekstrakurikuler` | `admin.ekstrakurikuler` | Daftar ekskul |
| GET | `/admin/ekstrakurikuler/tambah` | `admin.ekstrakurikuler.create` | Form tambah |
| POST | `/admin/ekstrakurikuler` | `admin.ekstrakurikuler.store` | Simpan ekskul |
| GET | `/admin/ekstrakurikuler/{id}/edit` | `admin.ekstrakurikuler.edit` | Form edit + galeri |
| PUT | `/admin/ekstrakurikuler/{id}` | `admin.ekstrakurikuler.update` | Update ekskul |
| DELETE | `/admin/ekstrakurikuler/{id}` | `admin.ekstrakurikuler.destroy` | Hapus ekskul + folder foto |
| GET | `/admin/ekstrakurikuler/{id}` | `admin.ekstrakurikuler.show` | Detail + galeri |
| GET | `/admin/data-guru` | `admin.data.guru` | Data guru |
| GET | `/admin/data-siswa` | `admin.data.siswa` | Data siswa |
| GET | `/admin/penerimaan-siswa` | `admin.penerimaan-siswa.index` | Status pendaftaran |
| PUT | `/admin/penerimaan-siswa/{id}/terima` | `admin.penerimaan-siswa.terima` | Terima siswa |
| PUT | `/admin/penerimaan-siswa/{id}/tolak` | `admin.penerimaan-siswa.tolak` | Tolak siswa |
| GET | `/admin/guru` | `admin.guru.index` | Daftar akun guru |
| POST | `/admin/guru` | `admin.guru.store` | Buat akun guru |
| PUT | `/admin/guru/{id}/reset-password` | `admin.guru.reset` | Reset password guru |
| DELETE | `/admin/guru/{id}` | `admin.guru.destroy` | Hapus guru |
| GET | `/admin/penilaian` | `admin.penilaian` | Rekap penilaian |
| GET | `/admin/laporan` | `admin.laporan` | Laporan admin |
| GET | `/admin/profil` | `admin.profil` | Profil admin |
| GET | `/admin/password-requests` | `admin.password.requests` | Permintaan reset |
| PUT | `/admin/password-requests/{id}/reset` | `admin.password.requests.reset` | Reset & kirim password |
| DELETE | `/admin/password-requests/{id}` | `admin.password.requests.destroy` | Hapus permintaan |
| GET | `/admin/absensi` | `admin.absensi` | Rekap absensi |
| POST | `/admin/absensi` | `admin.absensi.simpan` | Simpan absensi |

### 10.3 Guru — prefix `/guru`, middleware `role:guru`

| Method | URI | Nama | Keterangan |
|---|---|---|---|
| GET | `/guru/profil` | `guru.profil` | Profil guru |
| GET | `/guru/ekstrakurikuler` | `guru.ekstrakurikuler.index` | Daftar ekskul |
| GET | `/guru/ekstrakurikuler/create` | `guru.ekstrakurikuler.create` | Form tambah |
| POST | `/guru/ekstrakurikuler` | `guru.ekstrakurikuler.store` | Simpan ekskul |
| GET | `/guru/ekstrakurikuler/{id}/edit` | `guru.ekstrakurikuler.edit` | Form edit + galeri |
| PUT | `/guru/ekstrakurikuler/{id}` | `guru.ekstrakurikuler.update` | Update ekskul |
| DELETE | `/guru/ekstrakurikuler/{id}` | `guru.ekstrakurikuler.destroy` | Hapus ekskul + foto |
| GET | `/guru/kegiatan` | `guru.kegiatan` | Redirect ke daftar ekskul |
| GET | `/guru/penilaian` | `guru.penilaian` | Input penilaian |
| POST | `/guru/penilaian` | `guru.penilaian.simpan` | Simpan nilai |
| PUT | `/guru/penilaian/{id}` | `guru.penilaian.update` | Update nilai (pemilik saja) |
| DELETE | `/guru/penilaian/{id}` | `guru.penilaian.hapus` | Hapus nilai (pemilik saja) |
| GET | `/guru/laporan` | `guru.laporan` | Laporan guru |
| GET | `/guru/absensi` | `guru.absensi` | Rekap absensi |
| POST | `/guru/absensi` | `guru.absensi.simpan` | Simpan absensi |
| GET | `/guru/jadwal` | `guru.jadwal.index` | Kelola jadwal |
| POST | `/guru/jadwal` | `guru.jadwal.store` | Tambah jadwal |
| PUT | `/guru/jadwal/{id}` | `guru.jadwal.update` | Update jadwal |
| DELETE | `/guru/jadwal/{id}` | `guru.jadwal.destroy` | Hapus jadwal |

### 10.4 Siswa — middleware `role:siswa`

| Method | URI | Nama | Keterangan |
|---|---|---|---|
| GET | `/ekstrakurikuler` | `ekstrakurikuler` | Daftar & pilihan ekskul |
| POST | `/ekstrakurikuler/pilih` | `ekstrakurikuler.simpan` | Simpan pilihan (transaksi DB) |
| POST | `/ekstrakurikuler/batal` | `ekstrakurikuler.batal` | Batalkan pilihan |
| GET | `/ekstrakurikuler/{id}` | `ekstrakurikuler.detail` | Detail + galeri (lihat saja) |
| GET | `/profil` | `profil` | Profil siswa |
| GET | `/siswa/profil` | `siswa.profil` | Profil siswa (view alternatif) |
| GET | `/penilaian` | `penilaian` | Nilai milik sendiri |
| GET | `/penilaian/{id}` | `penilaian.detail` | Detail nilai |

### 10.5 Foto & Lainnya

| Method | URI | Nama | Middleware | Keterangan |
|---|---|---|---|---|
| GET | `/profil/foto/{filename}` | `profil.foto` | `role:admin,guru,siswa` | Sajikan foto profil privat |
| POST | `/profil/foto/upload` | `profil.foto.upload` | `role:admin,guru,siswa` | Upload/ganti foto profil |
| POST | `/ekstrakurikuler/{id}/foto` | `ekstrakurikuler.foto.store` | `role:admin,guru` | Upload galeri ekskul |
| DELETE | `/ekstrakurikuler/{id}/foto/{foto}` | `ekstrakurikuler.foto.hapus` | `role:admin,guru` | Hapus foto galeri |
| GET | `/jadwal-ekstrakurikuler` | `jadwal.ekstrakurikuler` | Cek manual di controller | Jadwal wajib/gabungan |

### 10.6 REST API v1 — `/api/v1`

Seluruh rute API didefinisikan di `routes/api.php` (45 rute). Autentikasi memakai `api.token`, pembatasan role memakai `api.role`. Respons JSON seragam: `success`, `message`, `data`, `errors`.

| Grup | Method & URI ringkas | Role |
|---|---|---|
| Publik | `POST /register`, `POST /login`, `POST /forgot-password` | Publik |
| Akun | `POST /logout`, `GET /me`, `GET /dashboard`, `GET /profil`, `GET|POST /profil/foto` | Semua |
| Ekskul | `GET /ekstrakurikuler`, `GET /ekstrakurikuler/{id}`, `POST|PUT|DELETE /ekstrakurikuler/{id}` | Semua (tulis: admin,guru) |
| Galeri | `POST /ekstrakurikuler/{id}/foto`, `DELETE /ekstrakurikuler/{id}/foto/{foto}` | Admin, Guru |
| Pilihan | `GET|POST|DELETE /pilihan-ekstrakurikuler` (+ alias `/ekstrakurikuler/pilih`, `/ekstrakurikuler/batal`) | Siswa |
| Jadwal | `GET /jadwal`, `POST|PUT|DELETE /jadwal/{id}` | Semua (tulis: guru) |
| Absensi | `GET|POST /absensi` | Admin, Guru |
| Penilaian | `GET /penilaian`, `GET /penilaian/{id}`, `POST|PUT|DELETE /penilaian/{id}` | Semua (tulis: guru) |
| Laporan | `GET /laporan` | Semua |
| Admin | `/admin/data-guru`, `/admin/data-siswa`, `/admin/penerimaan-siswa`, `/admin/guru`, `/admin/password-requests` | Admin |

Daftar lengkap beserta contoh request/respons ada di [`API-DOCS.md`](API-DOCS.md).

---

## 11. Alur Fitur Utama

### 11.1 Pendaftaran Ekstrakurikuler (Siswa)

1. Siswa login dengan status `diterima`.
2. Buka `/ekstrakurikuler`.
3. Pilih maksimal 2 ekskul melalui `POST /ekstrakurikuler/pilih`.
4. Controller menyimpan dalam transaksi database; index unik mencegah duplikat.
5. `POST /ekstrakurikuler/batal` menghapus semua pilihan siswa tersebut.

### 11.2 Absensi dan Penilaian (Guru/Admin)

1. Guru membuka `/guru/absensi` atau `/guru/penilaian`.
2. Pilih kegiatan siswa, lalu kirim data.
3. `AbsensiController@simpan` memakai `updateOrCreate` berdasarkan `username + nama_kegiatan + tanggal`.
4. `PenilaianController@simpan` menolak duplikat dan membatasi perubahan hanya pada data milik guru bersangkutan (`pastikanPemilik()`).
5. Predikat nilai dihitung model `Penilaian`: ≥90 Sangat Baik, ≥80 Baik, ≥70 Cukup, selainnya Perlu Bimbingan.

### 11.3 Laporan

`EkstrakurikulerController@laporanGuru` dan `@laporanAdmin` mengagregasi data ekskul, pendaftaran, absensi, dan penilaian. Tampilan guru ada di `resources/views/laporan.blade.php`, tampilan admin di `admin/laporan.blade.php`.

### 11.4 Foto Profil (Privat)

| Aspek | Keterangan |
|---|---|
| Role | Admin, guru, siswa |
| Upload | `POST /profil/foto/upload` |
| Validasi | `required`, `image`, `mimes:jpg,jpeg,png,webp`, `max:10240` (10 MB) |
| Penyimpanan | `storage/app/private/foto-profil/` (disk `local`) |
| Tampilan | `GET /profil/foto/{filename}` dengan `basename()` + pengecekan exists |
| Database | `ProfilePhoto` di-`updateOrCreate` berdasarkan `username + role` |
| Update | File lama dihapus dari disk `local` dan `public` |
| Cache | URL gambar ditambahkan `?v={{ updated_at->timestamp }}` |

Foto profil **tidak bisa** diakses langsung melalui `/storage/foto-profil/...`; route mengharuskan login.

### 11.5 Galeri Foto Kegiatan (Publik)

| Aspek | Keterangan |
|---|---|
| Role upload/hapus | Admin dan guru saja |
| Siswa | Hanya melihat (partial menerima `bisaKelola => false`) |
| Validasi | Maksimal 10 foto per unggahan, tiap foto maksimal 10 MB, format JPG/JPEG/PNG/WEBP, keterangan opsional maksimal 150 karakter |
| Penyimpanan | `storage/app/public/foto-kegiatan/{id}/` (disk `public`) |
| Akses | Melalui symlink `public/storage` → `Storage::disk('public')->url()` |
| Hapus | `destroy($id, $fotoId)` memastikan foto benar-benar milik ekskul yang bersangkutan |
| Hapus ekskul | Folder `foto-kegiatan/{id}/` ikut dihapus |

Partial yang dipakai: `resources/views/partials/foto-kegiatan.blade.php`, di-include oleh halaman detail siswa, admin, dan guru.

---

## 12. Penyimpanan File

| Disk | Lokasi | Dipakai untuk | Akses |
|---|---|---|---|
| `local` | `storage/app/private` | Foto profil | Route terautentikasi `/profil/foto/{filename}` |
| `public` | `storage/app/public` | Foto kegiatan ekskul | Symlink `public/storage` (URL `/storage/...`) |

Jalankan `php artisan storage:link` bila symlink belum ada.

---

## 13. Keamanan

| Mekanisme | Implementasi |
|---|---|
| CSRF | Semua form POST/PUT/DELETE memakai `@csrf`; logout juga POST + CSRF |
| Rate limit | Login 5/menit per username+IP & 30/menit per IP; register 6/menit; lupa password 5/menit |
| Role access | Web: `RoleMiddleware`; API: `ApiTokenAuth` + `ApiRole` + pengecekan status siswa |
| Token API | Hash SHA-256 di `users.api_token`, dikirim via Bearer, dicabut saat logout |
| Header keamanan | `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`, `Cross-Origin-Opener-Policy`, HSTS saat HTTPS |
| Path traversal | `basename()` pada nama file foto profil |
| Duplikat data | Index unik di database + validasi controller |
| File privat | Foto profil tidak bisa diakses langsung lewat `/storage` |
| Validasi upload | Tipe MIME, ekstensi, ukuran, dan jumlah foto dibatasi |
| Sandbox test | `/tes-error-500` hanya aktif di environment `local` |

---

## 14. Pengujian

Perintah:

```bash
php artisan test
```

### 14.1 Daftar Test

| File | Fokus |
|---|---|
| `tests/Unit/ExampleTest.php` | Test dasar PHPUnit |
| `tests/Feature/LoginRouteTest.php` | Halaman login tersedia & rute POST login ada |
| `tests/Feature/KeamananDasarTest.php` | Header keamanan, rate limit register, foto profil butuh login, dan `routes/web.php` harus diawali `<?php` |
| `tests/Feature/FotoKegiatanTest.php` | Upload banyak foto, penolakan file bukan gambar, hapus file + DB, isolasi antar ekskul, larangan siswa upload, galeri tampil di halaman siswa/admin/guru |
| `tests/Feature/Api/V1ApiTest.php` | Login/token, logout, role, CRUD ekskul, pilihan ekskul, jadwal, absensi, penilaian, penerimaan siswa, laporan, profil |
| `tests/Feature/ExampleTest.php` | Redirect tamu ke `/login` dan halaman login dapat diakses |
| `tests/Feature/CsrfProtectionTest.php` | Uji penolakan request tanpa CSRF |

### 14.2 Hasil Terakhir

```text
Tests: 25 passed, 0 failed (145 assertions)
Tests: 8 passed, 78 assertions   (php artisan test --filter=V1ApiTest)
```

Dua test yang dulu gagal sudah diperbaiki pada sesi final:

- `ExampleTest`: kini memeriksa bahwa `GET /` me-redirect ke `/login` (302), lalu halaman login mengembalikan 200.
- `CsrfProtectionTest`: kini memaksa middleware `ValidateCsrfToken` aktif di mode test, sehingga POST tanpa token benar-benar menghasilkan 419.

Detail lengkap ada di [`BUG-FIXING.md`](BUG-FIXING.md).

---

## 15. Perubahan dan Perbaikan Terbaru

| Tanggal | Perubahan |
|---|---|
| 2026-11-18 | Batas upload foto profil dan foto kegiatan dinaikkan dari 2 MB menjadi 10 MB, termasuk teks validasi dan petunjuk UI |
| 2026-11-18 | Cache-buster `?v=timestamp` ditambahkan pada tampilan foto profil di halaman siswa, guru, admin, dashboard, dan laporan |
| 2026-11-18 | Galeri foto ekskul pada halaman siswa disederhanakan: tidak menampilkan tombol/kelola admin; sidebar cukup bertuliskan `SISWA` |
| 2026-11-18 | **Perbaikan kritis:** baris kosong sebelum `<?php` di `routes/web.php` dihapus. Baris tersebut menyisipkan byte newline ke semua respons dan membuat gambar rusak di browser |
| 2026-11-18 | Tes regresi ditambahkan untuk memastikan `routes/web.php` diawali `<?php` |
| 2026-11-19 | **Perbaikan kritis:** `RoleMiddleware.php` dan `SecurityHeaders.php` dikembalikan ke `app/Http/Middleware/` setelah sempat berada di folder yang salah, menyebabkan error 500 |
| 2026-11-19 | Penambahan REST API v1 (`routes/api.php`, 45 endpoint), migrasi `users.api_token`, middleware `api.token`/`api.role`, 11 controller di `Api/V1/`, 8 test API, dan dokumentasi `docs/API-DOCS.md` |
| 2026-11-19 | Bug fixing final: typo `kelas_saat_i` → `kelas_saat_ini` di 5 file API, perbaikan `ExampleTest` & `CsrfProtectionTest`, test regresi, dan `docs/BUG-FIXING.md` |

---

## 16. Catatan Teknis dan Utang Teknik

1. **Middleware perlu di-commit.** Setelah pemindahan folder, `git status` masih menampilkan penghapusan file lama di `app/Http/Controllers/Middleware/` dan folder baru `app/Http/Middleware/` sebagai untracked. Jalankan `git add -A` dan commit agar perbaikan tidak hilang saat deploy.
2. **Controller legacy.** `app/Http/Controllers/sistemekstrakulikulerControler.php` mendeklarasikan ulang class `EkstrakurikulerController` dengan data hard-coded. File ini tidak dipakai rute manapun dan sebaiknya dihapus setelah dipastikan tidak diperlukan.
3. **Migration duplikat.** Beberapa migration lama menambahkan kolom yang sama tanpa pengecekan `hasColumn()`. Aman pada database yang sudah termigrasi bertahap, tetapi berisiko bila migrasi dijalankan dari kosong. Disarankan konsolidasi migration sebelum produksi bersih.
4. **Seeder belum lengkap.** `DatabaseSeeder`/`UserFactory` belum mengisi `username`, `role`, dan `status_pendaftaran`, sehinggaUser hasil `db:seed` belum bisa dipakai login. Buat seeder khusus untuk akun awal admin/guru/siswa.
5. **Tabel tidak terpakai.** `presensis` dan `ekstrakurikulers` (plural) adalah sisa pengembangan lama; yang dipakai adalah `absensi_siswas` dan `ekstrakurikuler` (singular).
6. **phpunit.xml** masih mengomentari `DB_CONNECTION=sqlite` dan `DB_DATABASE=:memory:`, sehingga test memakai database dari `.env`. Untuk test yang benar-benar isolasi, aktifkan dua baris tersebut.
7. Beberapa file migration serta `resources/views/siswa/profil.blade.php` masih memiliki baris kosong sebelum `<?php`. Tidak memengaruhi gambar karena bukan file yang disajikan langsung, tetapi sebaiknya dibersihkan.

---

## 17. Referensi

- `README.md` — ringkasan dan quick start.
- `docs/API-DOCS.md` — referensi lengkap REST API v1.
- `docs/BUG-FIXING.md` — catatan perbaikan bug dan test regresi.
- `docs/TECH-DOCS.md` — dokumentasi teknis.
- `docs/PANDUAN-PENGGUNAAN.md` — panduan end-user.
- `docs/TROUBLESHOOTING.md` — solusi masalah umum.
- `docs/use-case-diagram.png` — diagram use case sistem.
- `docs/use-case-diagram.html` — versi diagram interactif.
- `routes/web.php` — sumber kebenaran daftar rute web.
- `routes/api.php` — sumber kebenaran daftar rute REST API.
- `database/migrations/` — sumber kebenaran struktur database.

---

*Dokumentasi disusun berdasarkan kondisi kode pada 19 November 2026.*
