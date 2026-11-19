# TROUBLESHOOTING — AKTIVIA

Kumpulan masalah yang pernah ditemui beserta cara mengatasinya.

---

## 1. Aplikasi Menampilkan Error 500 di Semua Halaman

### Gejala

- `/login` dan `/` menghasilkan HTTP 500.
- Log `storage/logs/laravel.log` berisi:

```text
Target class [App\Http\Middleware\SecurityHeaders] does not exist.
```

atau

```text
Target class [App\Http\Middleware\RoleMiddleware] does not exist.
```

### Penyebab

File middleware berada di folder yang salah, misalnya:

```text
app/Http/Controllers/Middleware/SecurityHeaders.php
app/Http/Controllers/Middleware/RoleMiddleware.php
```

padahal namespace dan `bootstrap/app.php` mengharapkan:

```text
app/Http/Middleware/SecurityHeaders.php
app/Http/Middleware/RoleMiddleware.php
```

### Solusi

```bash
# Pastikan folder tujuan ada, lalu pindahkan filenya
mkdir -p app/Http/Middleware
mv app/Http/Controllers/Middleware/SecurityHeaders.php app/Http/Middleware/
mv app/Http/Controllers/Middleware/RoleMiddleware.php app/Http/Middleware/
rmdir app/Http/Controllers/Middleware

# Bersihkan cache
php artisan optimize:clear
php artisan view:cache
```

Verifikasi:

```bash
php -r "require 'vendor/autoload.php'; var_dump(class_exists('App\\Http\\Middleware\\SecurityHeaders'));"
curl -I http://127.0.0.1:8000/login
```

Pastikan menghasilkan `bool(true)` dan HTTP `200`.

---

## 2. Foto Profil Tersimpan tetapi Tidak Tampil / Rusak

### Gejala

- Upload berhasil, muncul pesan **"Foto profil berhasil diperbarui!"**.
- Database `profile_photos` berubah.
- Gambar di halaman profil kosong atau rusak, padahal URL gambar menghasilkan HTTP 200.

### Penyebab yang Sudah Ditemukan

`routes/web.php` diawali baris kosong sebelum `<?php`:

```php
          ← newline ini ikut tercetak
<?php
```

Byte newline tersebut ikut dikirim bersama gambar sehingga file JPEG bergeser satu byte:

```text
0A FF D8 FF E1 ...   ← rusak
FF D8 FF E1 ...      ← benar
```

### Solusi

Pastikan **baris pertama** `routes/web.php` adalah `<?php` tanpa baris kosong atau spasi di atasnya.

Tes regresi sudah tersedia di `tests/Feature/KeamananDasarTest.php`:

```bash
php artisan test --filter=KeamananDasarTest
```

### Cara Cepat Mendiagnosis

Bandingkan hash file storage dengan respons route:

```powershell
curl.exe -s -b cookie.txt "http://127.0.0.1:8000/profil/foto/NAMA.jpg" -o respons.jpg
Get-FileHash respons.jpg -Algorithm SHA256
Get-FileHash storage\app\private\foto-profil\NAMA.jpg -Algorithm SHA256
```

Kedua hash harus sama. Jika berbeda kemungkinan ada byte tambahan dari file PHP.

---

## 3. Error "Ukuran foto maksimal 2 MB"

### Penyebab

Batas lama masih tersimpan di cache view/browser, atau file masih melebihi batas saat kode belum diperbarui.

### Solusi

1. Pastikan validasi di `ProfilePhotoController.php` dan `FotoKegiatanController.php` memakai `max:10240`.
2. Pastikan teks di view sudah `Maksimal 10 MB`.
3. Bersihkan cache:

```bash
php artisan view:clear
php artisan view:cache
```

4. Refresh halaman dengan **Ctrl + F5**.
5. Pastikan ekstensi PHP mengizinkan unggah 10 MB:

```bash
php -i | Select-String 'upload_max_filesize|post_max_size'
```

---

## 4. Foto HEIC dari iPhone Tidak Bisa Diunggah

Aplikasi hanya menerima **JPG, JPEG, PNG, dan WEBP**. HEIC/HEIF belum didukung.

**Solusi:** konversi foto ke JPG terlebih dahulu (melalui pengaturan kamera iPhone: *Settings → Camera → Format → Most Compatible*, atau menggunakan aplikasi konversi).

---

## 5. Foto Kegiatan Tidak Tampil

### Kemungkinan dan Solusi

| Penyebab | Solusi |
|---|---|
| Symlink storage belum ada | `php artisan storage:link` |
| File tidak ada di `storage/app/public/foto-kegiatan/{id}/` | Cek hasil upload di folder tersebut |
| Izin folder tidak memadai | Pastikan web server bisa menulis ke `storage/` |
| Cache browser | Hard refresh (`Ctrl + F5`) |

---

## 6. Error 419 Page Expired

### Penyebab

Token CSRF habis karena halaman terlalu lama dibuka atau cookie session berganti.

### Solusi

1. Refresh halaman.
2. Isi form kembali dan submit.
3. Pastikan form memakai `@csrf`.
4. Pastikan domain di `APP_URL` sesuai alamat yang dipakai.

---

## 7. Login Gagal Padahal Password Benar

### Hal yang Dicek

1. Status siswa harus `diterima`, bukan `menunggu`/`ditolak`.
2. Rate limit login: maksimal 5 percobaan per menit per username+IP dan 30 per menit per IP. Tunggu satu menit bila terkena limit.
3. Pastikan aplikasi yang dibuka adalah `http://127.0.0.1:8000`, bukan salinan lama di port lain.
4. Cek session driver di `.env`.

---

## 8. Test Gagal

### Test Bawaan yang Dulu Gagal (Sudah Diperbaiki)

| Test | Masalah lama | Perbaikan |
|---|---|---|
| `Feature\ExampleTest` | Mengharapkan `GET /` = 200, padahal rute `/` redirect ke login (302) | Test kini memeriksa redirect ke `/login`, lalu halaman login 200 |
| `Feature\CsrfProtectionTest` | Laravel melewati CSRF saat mode test, sehingga tidak pernah 419 | Middleware `ValidateCsrfToken` dipaksa aktif di test |

Sekarang seluruh test lulus: `Tests: 25 passed (145 assertions)`. Detail ada di [`BUG-FIXING.md`](BUG-FIXING.md). Test fitur foto dan keamanan juga lolos:

```bash
php artisan test --filter=FotoKegiatan
php artisan test --filter=KeamananDasarTest
```

Jika test memakai database `.env` (MySQL), pastikan database tersedia. Untuk isolasi, aktifkan di `phpunit.xml`:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

---

## 9. Server Tidak Merespons

```bash
# Cek port
Get-NetTCPConnection -State Listen | Where-Object LocalPort -eq 8000

# Jalankan ulang
php artisan serve --host=127.0.0.1 --port=8000
```

Jika port dipakai proses lain, hentikan proses tersebut atau gunakan port lain:

```bash
php artisan serve --port=8001
```

---

## 10. Perubahan Kode Tidak Muncul

```bash
php artisan optimize:clear
php artisan view:cache
php artisan route:cache     # hanya bila rute sudah final
php artisan config:cache    # hanya bila .env sudah final
```

Lalu lakukan hard refresh di browser.

> **Catatan:** setelah menjalankan `route:cache` atau `config:cache`, perubahan pada `routes/*.php` atau `.env` tidak langsung terbaca. Jalankan `php artisan route:clear` / `config:clear` terlebih dahulu.

---

## 11. Catatan Repository

Setelah perbaikan middleware, jalankan:

```bash
git status
git add -A
git commit -m "Perbaiki struktur middleware dan dokumentasi proyek"
```

Pastikan tidak ada file temporary (`temp_*.php`) atau file uji di `public/` yang tertinggal.

---

Lihat juga [Dokumentasi Proyek](DOKUMENTASI-PROYEK.md) dan [Panduan Penggunaan](PANDUAN-PENGGUNAAN.md).
