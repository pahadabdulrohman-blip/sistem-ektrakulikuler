# AKTIVIA — Catatan Bug Fixing

**Rekam perbaikan bug akhir — 19 November 2026**

| Field | Keterangan |
|---|---|
| Dokumen | Bug Fixing Log |
| Versi | 1.1 (final + catatan deploy) |
| Status | Semua test lulus: **25 passed, 145 assertions** |
| Perintah verifikasi | `php artisan test` |

---

## 1. Ringkasan

| No | Bug | Dampak | Status |
|---|---|---|---|
| 1 | Nama accessor kelas ditulis `kelas_saat_i` (harus `kelas_saat_ini`) di 5 tempat API | Field `kelas_saat_ini` selalu bernilai `"-"` pada respons API, termasuk untuk siswa aktif | Diperbaiki |
| 2 | `ExampleTest` mengharapkan `GET /` mengembalikan 200 | Test gagal karena rute `/` memang me-redirect ke `/login` (302) | Diperbaiki |
| 3 | `CsrfProtectionTest` mengharapkan 419 | Test gagal karena Laravel sengaja melewati CSRF saat mode test, dan Laravel 12 memakai `ValidateCsrfToken` | Diperbaiki |
| 4 | File Word ditolak Word dengan pesan "file appears to be corrupted" (riwayat) | `.docx` tidak bisa dibuka | Diperbaiki |
| 5 | Middleware berada di folder yang salah (riwayat) | Error 500 pada aplikasi web | Diperbaiki |
| 6 | Baris kosong sebelum `<?php` di `routes/web.php` (riwayat) | Semua respons gambar rusak karena ada byte newline | Diperbaiki |

---

## 2. Detail Perbaikan Sesi Ini

### 2.1 Bug: `kelas_saat_ini` selalu `"-"` di REST API

**Gejala**

Endpoint `/api/v1/me`, `/api/v1/laporan`, `/api/v1/penilaian`, dan `/api/v1/admin/data-siswa` mengembalikan `kelas_saat_ini` atau `kelas` bernilai `"-"` walaupun siswa memiliki kelas `X` dan `tahun_masuk` yang valid.

**Penyebab**

Model `App\Models\User` mendefinisikan accessor:

```php
public function getKelasSaatIniAttribute(): ?string
```

Artinya nama atributnya adalah `kelas_saat_ini`. Kode API membaca `kelas_saat_i` (tanpa `ni`), sehingga `data_get()` tidak menemukan kunci dan memakai nilai default `"-"`.

**Perbaikan**

Mengganti seluruh kemunculan `kelas_saat_i` menjadi `kelas_saat_ini`:

| File | Fungsi |
|---|---|
| `app/Http/Controllers/Api/V1/ApiController.php` | `formatUser()` |
| `app/Http/Controllers/Api/V1/PenilaianController.php` | rekap nilai admin |
| `app/Http/Controllers/Api/V1/LaporanController.php` | detail penilaian & rekap siswa |
| `app/Http/Controllers/Api/V1/PenggunaController.php` | jumlah siswa per kelas |

**Test regresi**

Ditambahkan `test_kelas_saat_ini_dihitung_benar()` di `tests/Feature/Api/V1ApiTest.php`:

```php
$this->withHeaders($this->header('siswa'))
    ->getJson('/api/v1/me')
    ->assertOk()
    ->assertJsonPath('data.kelas', 'X')
    ->assertJsonPath('data.kelas_saat_ini', 'X');
```

---

### 2.2 Bug: `ExampleTest` salah ekspektasi

**Gejala**

```text
Expected response status code [200] but received 302.
```

**Penyebab**

Test bawaan Laravel mengira `GET /` mengembalikan 200. Padahal `routes/web.php` sengaja melakukan `redirect()->route('login')` untuk tamu.

**Perbaikan**

Test diubah untuk memeriksa perilaku yang sebenarnya:

```php
$this->get('/')->assertRedirect('/login');
$this->get('/login')->assertOk();
```

File: `tests/Feature/ExampleTest.php`.

---

### 2.3 Bug: `CsrfProtectionTest` tidak pernah menghasilkan 419

**Gejala**

```text
Expected response status code [419] but received 302.
```

**Penyebab**

Ada dua lapisan:

1. Laravel secara sengaja **melewati validasi CSRF** ketika `app()->runningUnitTests()` bernilai `true`, supaya test tidak perlu mengirim token.
2. Laravel 12 tidak lagi memakai `Illuminate\Foundation\Http\Middleware\VerifyCsrfToken` langsung di grup `web`, melainkan `Illuminate\Foundation\Http\Middleware\ValidateCsrfToken` (subclass-nya). Mengikat class lama tidak berpengaruh.

**Perbaikan**

Test mengganti instance middleware `ValidateCsrfToken` dengan subclass yang meng-override `runningUnitTests()` menjadi `false`, sehingga validasi CSRF benar-benar jalan seperti di produksi:

```php
$this->app->instance(ValidateCsrfToken::class, new class($this->app, $this->app['encrypter']) extends ValidateCsrfToken
{
    protected function runningUnitTests(): bool
    {
        return false;
    }
});
```

Lalu POST tanpa `_token` ke `/admin/ekstrakurikuler` diverifikasi menghasilkan 419.

File: `tests/Feature/CsrfProtectionTest.php`.

> Catatan: `withMiddleware(ValidateCsrfToken::class)` tidak dipakai karena metode itu justru menghapus binding kustom dari container.

---

## 3. Riwayat Perbaikan Sebelumnya

| Tanggal | Masalah | Perbaikan |
|---|---|---|
| 2026-11-18 | File `.docx` ditolak Word ("file appears to be corrupted") | Timestamp core properties memakai `InvariantCulture` dengan format `yyyy-MM-ddTHH\:mm\:ss\Z` |
| 2026-11-18 | Baris kosong sebelum `<?php` di `routes/web.php` merusak semua gambar | Baris kosong dihapus; test regresi ditambahkan di `KeamananDasarTest` |
| 2026-11-18 | Galeri foto ekskul siswa masih menampilkan kontrol admin | Diubah menjadi view-only |
| 2026-11-19 | `RoleMiddleware.php` & `SecurityHeaders.php` salah folder menyebabkan error 500 | Keduanya dikembalikan ke `app/Http/Middleware/` |
| 2026-11-19 | Aplikasi belum memiliki rute API | Ditambahkan REST API v1 (45 endpoint) + dokumentasi |

---

## 4. Hasil Verifikasi Akhir

```text
Tests: 25 passed (145 assertions)
```

Rincian:

| Grup | Jumlah test |
|---|---|
| Unit | 1 |
| REST API v1 | 8 |
| CSRF | 1 |
| Example (web) | 1 |
| Foto kegiatan | 6 |
| Keamanan dasar | 5 |
| Rute login | 2 |

Pemeriksaan tambahan:

```bash
php artisan route:list --path=api     # 45 rute
php -l <file yang diubah>             # tidak ada syntax error
```

---

## 5. Pencegahan

- Seluruh perbaikan disertai test regresi sehingga tidak muncul kembali.
- `php artisan test` dijalankan sebelum commit.
- Sumber kebenaran: `routes/api.php` untuk endpoint, `app/Models/` untuk nama accessor/relasi.

---

## 6. Catatan Deploy: Error 500 Saat Login

Laporan: aplikasi normal di lokal, tetapi menghasilkan 500 saat tombol Login ditekan di server deploy.

Ini **bukan bug kode** melainkan konfigurasi server. `GET /login` hanya merender view, sedangkan `POST /login` menyentuh tabel `cache` (RateLimiter), tabel `users`, tabel `sessions`, dan enkripsi cookie dengan `APP_KEY`. Penyebab paling umum:

| Penyebab | Perbaikan |
|---|---|
| `.env` tidak ikut ter-upload (file ini di-`.gitignore`), sehingga `APP_KEY` kosong | `cp .env.example .env && php artisan key:generate` |
| File `database/database.sqlite` belum ada | `touch database/database.sqlite`, lalu `php artisan migrate --force` |
| Migrasi belum dijalankan → tabel `users` / `cache` / `sessions` tidak ada | `php artisan migrate --force` |
| Kredensial MySQL salah | Perbaiki `DB_*`, lalu `php artisan config:clear` |
| `storage/` atau `bootstrap/cache/` tidak writable | Beri izin tulis untuk web server |

Checklist deploy sudah diperbarui di `docs/TECH-DOCS.md` §15 dan `docs/DOKUMENTASI-PROYEK.md` §5.4. Tata cara membaca log dan verifikasi ada di [`TROUBLESHOOTING.md`](TROUBLESHOOTING.md#12-error-500-saat-login-setelah-deploy).

### 6.1 Perbaikan tambahan (commit `c8cc1d0+`)

Karena Start command tidak bisa diubah lewat kode, aplikasi dibuat mandiri:

| File | Perubahan |
|---|---|
| `config/database.php` | Default connection otomatis `mysql` saat `DATABASE_URL` (addon EthioDeploy) tersedia dan `DB_CONNECTION` tidak diset |
| `app/Providers/AutoMigrateProvider.php` | Menjalankan `migrate --force` pada request web pertama bila tabel `users`/`cache`/`sessions` belum ada; hanya sekali per konfigurasi DB, gagalnya dicatat di log |
| `bootstrap/providers.php` | Mendaftarkan provider tersebut |
| `bootstrap/app.php` | `trustProxies(at: '*')` agar URL/asset tetap HTTPS di balik proxy |

Dengan ini login 500 akibat tabel belum ada tidak terjadi lagi tanpa Set Start command manual. Panduan lengkap: [`DEPLOY-ETHIODEPLOY.md`](DEPLOY-ETHIODEPLOY.md).

### 6.2 Akar 500 `POST /login` terkonfirmasi — `RateLimiter` vs tabel `cache`

Reproduksi lokal: dengan `CACHE_STORE=database` dan database tanpa tabel `cache`, `RateLimiter::tooManyAttempts()` melempar `QueryException: no such table: cache`. Di MySQL pesannya `Base table or view not found: 1146 Table '...cache' doesn't exist`. Ini cocok dengan gejala produksi: `GET /login 200` (session memakai tabel `sessions` yang ada) tetapi `POST /login 500` (throttle memakai tabel `cache` yang belum ada).

| File | Perubahan |
|---|---|
| `config/cache.php` | Default `CACHE_STORE` diubah dari `database` ke `file`, sehingga throttle tidak bergantung pada tabel SQL |
| `app/Providers/AppServiceProvider.php` | Jika `CACHE_STORE=database` tetap dipaksa dan tabel `cache`/`cache_locks` belum ada, otomatis fallback ke driver `array` |
| `app/Providers/AutoMigrateProvider.php` | Migrasi juga memastikan tabel `cache_locks` ikut terbuat |
| `app/Http/Middleware/SecurityHeaders.php` | Header `X-AKTIVIA-BUILD: 20261119-fix-cache` untuk verifikasi build produksi |
| `bootstrap/app.php` | Hook diagnostik sementara memakai `\Throwable` (menghilangkan warning `use statement has no effect`) |

Verifikasi lokal: probe dengan `CACHE_STORE=database` + SQLite `:memory:` kini menghasilkan `cache.default = array` dan `RATELIMITER AMAN`; `php artisan test` tetap **25 passed (145 assertions)**.

---

*AKTIVIA — Bug Fixing Log v1.1*
