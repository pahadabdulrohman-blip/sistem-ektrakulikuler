# Deploy AKTIVIA ke EthioDeploy

Panduan khusus untuk alamat produksi `https://sistem-ektrakulikuler.ethiodeploy.app`.

---

## 1. Kenapa koneksi database "tidak tersimpan"

EthioDeploy **tidak membaca file `.env` dari repository**. File `.env` memang masuk `.gitignore`, jadi tidak pernah dikirim ke GitHub dan tidak sampai ke server.

| Fakta EthioDeploy | Dampak |
|---|---|
| Environment variable diset lewat **Settings → Environment Variables** dan di-inject saat deploy | Mengedit `.env` di komputer/local tidak ada efek di produksi |
| `config:cache` dijalankan **saat container start**, setelah env var dimuat | Setelah mengubah env var, **harus redeploy** agar nilai baru dipakai |
| SQLite dibuat ulang dan **dihapus setiap deploy** | Jangan pakai SQLite untuk data produksi — data login dan ekskul akan hilang |
| Start script bawaan hanya menjalankan `migrate` untuk SQLite | Untuk MySQL/Postgres tabel `users`/`cache`/`sessions` bisa tidak ada → login 500 |

Sejak commit ini, dua hal sudah diperbaiki di kode:

- `config/database.php` otomatis memakai `mysql` ketika `DATABASE_URL` dari addon tersedia.
- `AutoMigrateProvider` membuat tabel otomatis pada request web pertama bila belum ada.

Yang masih perlu diperhatikan:

1. Mengubah `.env` lokal lalu `git push` tetap tidak berpengaruh — env var harus diset di dashboard.
2. Setelah mengubah env var di dashboard, **tetap wajib redeploy** karena config di-cache saat start.
3. Jangan memaksa `DB_CONNECTION=sqlite` di produksi — datanya hilang tiap deploy.

---

## 2. Langkah deploy yang benar

### 2.1 Pasang addon database

1. Buka project di dashboard EthioDeploy.
2. **Addons → New → MySQL** (atau Postgres), lalu attach ke project.
3. Platform otomatis menyuntik connection string sebagai `DATABASE_URL`.
4. `config/database.php` proyek ini **sudah** membacanya untuk koneksi `mysql`:

```php
'mysql' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL', env('DB_URL')),
    // ...
],
```

Jadi **tidak perlu** mengisi `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` manual. Bahkan `DB_CONNECTION` juga bisa dikosongkan: `config/database.php` sudah otomatis memilih `mysql` saat `DATABASE_URL` tersedia.

> Untuk Postgres, tambahkan fallback `env('DATABASE_URL')` pada blok `pgsql` di `config/database.php` lalu set `DB_CONNECTION=pgsql`.

### 2.2 Isi Environment Variables di Settings

```env
APP_NAME=AKTIVIA
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sistem-ektrakulikuler.ethiodeploy.app
SESSION_SECURE_COOKIE=true
LOG_CHANNEL=stderr
```

`DB_CONNECTION` tidak wajib diisi — aplikasi otomatis memakai `mysql` saat addon menyuntik `DATABASE_URL`.

Catatan:

- `APP_KEY`: jika belum ada, EthioDeploy membuat otomatis pada deploy pertama dan menyimpannya sebagai env var. Jangan menggantinya setelah ada pengguna, karena sesi dan data terenkripsi akan rusak. Untuk set manual, jalankan `php artisan key:generate --show` lalu tempel **nilai lengkap termasuk prefix `base64:`**.
- `LOG_CHANNEL=stderr` membuat exception muncul di tab **Logs** (platform sudah mengaturnya secara default).
- Biarkan `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database` — semua sudah didukung setelah migrasi.

### 2.3 Migrasi otomatis (tanpa Start command)

Mulai commit ini, aplikasi **menjalankan migrasi sendiri** saat request web pertama kali tiba jika tabel `users`, `cache`, atau `sessions` belum ada. Logikanya ada di `app/Providers/AutoMigrateProvider.php`:

- hanya jalan di request web (tidak mengganggu `artisan` dan test);
- hanya sekali per konfigurasi database (penanda di `storage/framework/.db-siap-*`);
- gagalnya migrasi tidak menggantikan error aplikasi, hanya dicatat di log.

Jadi Start command bawaan EthioDeploy bisa dibiarkan kosong. Tetap disarankan mengisi:

```bash
php artisan migrate --force && ethiodeploy-start
```

sebagai Lapisan tambahan, tetapi **tidak lagi wajib**.

Biarkan **Build command** kosong — platform otomatis menjalankan `composer install --no-dev --optimize-autoloader` dan `npm run build`.

### 2.4 Redeploy

Setiap perubahan env var atau Start command **wajib diikuti redeploy**. Config di-cache saat container start, jadi tanpa redeploy aplikasi masih memakai nilai lama.

---

## 3. Verifikasi

1. Buka tab **Logs** saat aplikasi start — tidak boleh ada `SQLSTATE` atau `No application encryption key`.
2. Buka `https://sistem-ektrakulikuler.ethiodeploy.app/login`.
3. Coba login dengan akun admin/guru/siswa.
4. Cek endpoint API: `GET https://.../api/v1/...` dengan header `Authorization: Bearer <token>`.

---

## 4. Tabel masalah umum

| Gejala | Penyebab | Solusi |
|---|---|---|
| Env var sudah diisi tapi masih memakai DB lama | Config di-cache saat start | **Redeploy** setelah ubah env var |
| Edit `.env` lokal tapi tidak berubah di produksi | `.env` tidak di-deploy | Set di Settings → Environment Variables |
| `SQLSTATE[HY000] [2002] Connection refused` | Addon belum attached / config lama | Pasang addon MySQL, lalu redeploy |
| `Base table or view not found: ...users/cache/sessions` | Migrasi belum jalan | `AutoMigrateProvider` akan mencoba otomatis; pastikan addon terpasang lalu redeploy. Opsi manual ada di §2.3 |
| Data hilang setelah deploy | Masih memakai SQLite | Hapus `DB_CONNECTION=sqlite` dari dashboard agar terdeteksi `DATABASE_URL` |
| `No application encryption key has been specified.` | `APP_KEY` kosong | Set `APP_KEY` di Settings atau redeploy agar di-generate |
| `Vite manifest not found` | Build tidak jalan | Biarkan Build command kosong agar platform menjalankan `npm run build` |
| Link/asset masih `http://` | Proxy HTTPS tidak dipercaya | Sudah ditambahkan `$middleware->trustProxies(at: '*')` di `bootstrap/app.php` + set `APP_URL` HTTPS |

---

## 5. Catatan penting penyimpanan file

EthioDeploy memakai container baru pada setiap deploy, sehingga **file di `storage/app/` ikut hilang**. Aplikasi ini menyimpan foto profil dan foto kegiatan di `storage/app/`, jadi:

- Untuk produksi jangka panjang, pindahkan disk `public`/`local` ke S3-compatible storage.
- Setidaknya, jangan menganggap file upload di `storage/` sebagai cadangan permanen.

---

Lihat juga [TROUBLESHOOTING.md](TROUBLESHOOTING.md#12-error-500-saat-login-setelah-deploy), [TECH-DOCS.md](TECH-DOCS.md#15-deployment), dan [API-DOCS.md](API-DOCS.md).
