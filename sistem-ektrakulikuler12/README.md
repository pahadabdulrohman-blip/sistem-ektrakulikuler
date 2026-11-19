# AKTIVIA – Sistem Informasi Ekstrakurikuler

**AKTIVIA** adalah aplikasi berbasis web yang dikembangkan menggunakan Laravel untuk membantu sekolah mengelola kegiatan ekstrakurikuler secara digital. Aplikasi ini menyediakan sistem pengelolaan data berdasarkan hak akses Admin, Guru, dan Siswa.

## 📌 Deskripsi Proyek

Aplikasi Sistem Informasi Ekstrakurikuler dibuat untuk mempermudah proses pengelolaan kegiatan ekstrakurikuler di lingkungan sekolah, mulai dari pengelolaan data ekstrakurikuler, pendaftaran siswa, jadwal kegiatan, absensi, penilaian, hingga laporan.

Dengan adanya aplikasi ini, proses administrasi kegiatan ekstrakurikuler menjadi lebih terstruktur, efektif, dan mudah diakses.

## 🎯 Tujuan

- Mendigitalisasi pengelolaan kegiatan ekstrakurikuler.
- Mempermudah pendaftaran siswa ke kegiatan ekstrakurikuler.
- Mempermudah guru dalam mengelola absensi dan penilaian.
- Membantu admin mengelola data dan laporan.
- Menyediakan informasi kegiatan ekstrakurikuler secara terpusat.

## ✨ Fitur Aplikasi

### 1. Admin
- Login Admin.
- Dashboard Admin.
- Mengelola data ekstrakurikuler.
- Mengelola pendaftaran siswa.
- Mengelola data guru dan siswa.
- Mengelola jadwal kegiatan.
- Melihat dan mengelola laporan.
- Mengelola permintaan dan data pengguna.

### 2. Guru
- Login Guru.
- Dashboard Guru.
- Melihat kegiatan ekstrakurikuler.
- Mengelola absensi siswa.
- Mengelola penilaian siswa.
- Melihat laporan kegiatan.
- Mengelola profil.

### 3. Siswa
- Registrasi dan login siswa.
- Dashboard Siswa.
- Melihat daftar ekstrakurikuler.
- Melakukan pendaftaran ekstrakurikuler.
- Melihat jadwal kegiatan.
- Melihat nilai ekstrakurikuler.
- Melihat laporan.
- Mengelola profil dan foto profil.

## 🛠️ Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP 8.2 | Bahasa pemrograman backend |
| Laravel 12 | Framework aplikasi |
| MySQL | Database |
| HTML5 | Struktur halaman |
| CSS3 | Desain tampilan |
| JavaScript | Interaksi halaman |
| Blade | Template Laravel |
| Vite | Pengelolaan aset frontend |
| Git & GitHub | Version control dan penyimpanan kode |

## 📋 Persyaratan Sistem

Pastikan perangkat sudah memiliki:

- PHP minimal 8.2.
- Composer.
- MySQL atau MariaDB.
- Node.js dan NPM.
- Git.
- Visual Studio Code (opsional).

## 🚀 Cara Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/sistem-ektrakulikuler12.git
```

### 2. Masuk ke Folder Proyek

```bash
cd sistem-ektrakulikuler12
```

### 3. Install Dependency Laravel

```bash
composer install
```

### 4. Salin File Environment

Windows:

```powershell
Copy-Item .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buat database MySQL dengan nama:

```sql
CREATE DATABASE `sistem-ektrakulikuler12`;
```

### 7. Konfigurasi Database

Sesuaikan konfigurasi berikut di file `.env`:

```env
APP_NAME="Sistem Ektrakulikuler12"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem-ektrakulikuler12
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password MySQL dengan konfigurasi komputer masing-masing.

### 8. Jalankan Migrasi Database

```bash
php artisan migrate
```

Jika proyek menyediakan seeder dan memang diperlukan:

```bash
php artisan db:seed
```

### 9. Install Dependency Frontend

```bash
npm install
```

### 10. Build Aset Frontend

```bash
npm run build
```

### 11. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser:

```text
http://127.0.0.1:8000
```

## 📂 Struktur Folder

```text
sistem-ektrakulikuler12/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── public/
│   ├── build/
│   └── storage/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   └── web.php
│
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

## 🔐 Sistem Hak Akses

Aplikasi menggunakan sistem hak akses berdasarkan role:

| Role | Hak Akses |
|---|---|
| Admin | Mengelola seluruh data aplikasi |
| Guru | Mengelola kegiatan, absensi, dan penilaian |
| Siswa | Melihat kegiatan, mendaftar, dan melihat nilai |

Setiap pengguna hanya dapat mengakses halaman sesuai dengan hak akses yang diberikan.

## 🗄️ Database

Database yang digunakan adalah MySQL.

Nama database:

```text
sistem-ektrakulikuler12
```

Struktur tabel mengikuti file migration yang tersedia di folder `database/migrations`.

## 🧪 Pengujian Aplikasi

Pengujian dilakukan untuk memastikan fitur aplikasi berjalan sesuai fungsinya.

Beberapa bagian yang dapat diuji:

- Login dan logout.
- Registrasi pengguna.
- Hak akses Admin, Guru, dan Siswa.
- Pengelolaan ekstrakurikuler.
- Pendaftaran ekstrakurikuler.
- Pengelolaan jadwal.
- Pengelolaan absensi.
- Pengelolaan penilaian.
- Pengelolaan laporan.

## 🌐 Demo Aplikasi

URL Deployment:

https://sistem-ektrakulikuler.ethiodeploy.app

## 👨‍💻 Pengembang

**Proyek:** AKTIVIA – Sistem Informasi Ekstrakurikuler

**Jenis Proyek:** Aplikasi Web

**Framework:** Laravel 12

**Bahasa:** PHP

**Database:** MySQL

**Tujuan Pengembangan:** Mendukung digitalisasi pengelolaan kegiatan ekstrakurikuler sekolah.

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan pembelajaran dan tugas pengembangan aplikasi sekolah.

---

**AKTIVIA – Kelola Ekstrakurikuler Lebih Mudah, Terstruktur, dan Digital.**