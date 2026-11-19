# AKTIVIA — REST API v1

**Dokumentasi referensi REST API AKTIVIA**

| Field | Keterangan |
|---|---|
| Dokumen | REST API Reference |
| Versi API | `v1` |
| Base URL | `http://127.0.0.1:8000/api/v1` |
| Format | JSON (UTF-8) |
| Autentikasi | Bearer token (token login) |
| Sumber kebenaran | `routes/api.php` |
| Jumlah endpoint | 45 rute |
| Tanggal | 19 November 2026 |

---

## Daftar Isi

1. [Ringkasan](#1-ringkasan)
2. [Format Respons](#2-format-respons)
3. [Autentikasi](#3-autentikasi)
4. [Matriks Hak Akses](#4-matriks-hak-akses)
5. [Daftar Endpoint](#5-daftar-endpoint)
6. [Contoh Request dan Respons](#6-contoh-request-dan-respons)
7. [Validasi dan Kode Error](#7-validasi-dan-kode-error)
8. [Rate Limiting](#8-rate-limiting)
9. [Catatan Implementasi](#9-catatan-implementasi)
10. [Pengujian](#10-pengujian)

---

## 1. Ringkasan

API v1 adalah **cermin lengkap** fitur aplikasi web AKTIVIA. Setiap fitur yang tersedia di antarmuka web (dashboard, ekstrakurikuler, pilihan ekskul, jadwal, absensi, penilaian, galeri foto, profil, penerimaan siswa, kelola akun guru, reset password, dan laporan) memiliki endpoint API yang setara.

Karakteristik:

- Berjalan di prefix `/api/v1`, terpisah dari rute web Blade.
- Seluruh respons memakai satu wrapper JSON yang konsisten.
- Autentikasi memakai token, bukan session/cookie, sehingga cocok untuk mobile, SPA, atau integrasi pihak ketiga.
- Tidak memerlukan CSRF token karena autentikasi tidak berbasis session.
- Hak akses mengikuti role yang sama dengan aplikasi web: `admin`, `guru`, `siswa`.

### Arsitektur Singkat

```text
Client (mobile/SPA/postman)
        ↓  Authorization: Bearer <token>
routes/api.php  →  middleware api.token / api.role
        ↓
Controller Api\V1\*  →  Model Eloquent (sama seperti web)
        ↓
JSON { success, message, data, errors }
```

---

## 2. Format Respons

Semua endpoint mengembalikan struktur berikut:

```json
{
  "success": true,
  "message": "Berhasil.",
  "data": {},
  "errors": null
}
```

| Field | Tipe | Keterangan |
|---|---|---|
| `success` | boolean | `true` bila operasi berhasil, `false` bila gagal |
| `message` | string | Pesan untuk pengguna, dalam bahasa Indonesia |
| `data` | any | Payload hasil operasi; `null` bila tidak ada data |
| `errors` | object/null | Detail validasi per field; hanya ada saat HTTP 422 |

Contoh respons gagal validasi:

```json
{
  "success": false,
  "message": "Validasi gagal.",
  "data": null,
  "errors": {
    "nama_ekstrakurikuler": ["Nama ekstrakurikuler wajib diisi."],
    "deskripsi": ["Deskripsi wajib diisi."]
  }
}
```

Contoh respons gagal autentikasi:

```json
{
  "success": false,
  "message": "Token API tidak ditemukan. Kirim header Authorization: Bearer <token>.",
  "data": null
}
```

---

## 3. Autentikasi

### 3.1 Mendapatkan Token

Token diperoleh lewat `POST /api/v1/login` dengan kredensial yang sama seperti login web.

```bash
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "{\"username\":\"admin\",\"password\":\"password_admin\"}"
```

Respons sukses:

```json
{
  "success": true,
  "message": "Login berhasil.",
  "data": {
    "token": "NcKAsg7uvwwzm2XCVlu9bK0DGivC7iGy6HaPD8eG9SG21xCxqGDhAQo0AvKCjbJC",
    "token_type": "Bearer",
    "user": {
      "id": 3,
      "name": "Administrator",
      "username": "admin",
      "email": "admin@gmail.com",
      "role": "admin",
      "status_pendaftaran": "diterima",
      "kelas": null,
      "kelas_saat_ini": "-",
      "tahun_masuk": null,
      "nama_sekolah": null
    }
  }
}
```

> **Penting:** string `token` hanya dikembalikan **sekali** saat login. Simpan di sisi klien (misalnya `localStorage` atau secure storage). Database hanya menyimpan hash SHA-256 dari token.

### 3.2 Mengirim Token

Sertakan header pada setiap request yang butuh autentikasi:

```text
Authorization: Bearer <token>
```

Alternatif (untuk klien yang sulit mengirim header `Authorization`):

```text
X-API-Token: <token>
```

Contoh:

```bash
curl http://127.0.0.1:8000/api/v1/me \
  -H "Authorization: Bearer NcKAsg7uvwwzm2XCVlu9bK0DGivC7iGy6HaPD8eG9SG21xCxqGDhAQo0AvKCjbJC" \
  -H "Accept: application/json"
```

### 3.3 Masa Berlaku dan Logout

- Token tidak memiliki masa kedaluwarsa otomatis.
- Token dicabut saat `POST /api/v1/logout` dipanggil, atau diganti saat akun login lagi (token lama ikut tidak valid).
- Akun siswa dengan status `menunggu` atau `ditolak` tidak bisa login.
- Jika akun dinonaktifkan/dihapus, token tidak lagi berlaku.

### 3.4 Endpoint Publik

Tiga endpoint berikut **tidak memerlukan token**:

| Method | URI | Keterangan |
|---|---|---|
| POST | `/register` | Registrasi siswa baru, status awal `menunggu` |
| POST | `/login` | Login + terbitkan token |
| POST | `/forgot-password` | Ajukan permintaan ubah password |

---

## 4. Matriks Hak Akses

| Grup Fitur | Publik | Siswa | Guru | Admin |
|---|---|---|---|---|
| Register, login, lupa password | ✓ | ✓ | ✓ | ✓ |
| Me, dashboard, profil, logout | — | ✓ | ✓ | ✓ |
| Lihat ekstrakurikuler & detail | — | ✓ | ✓ | ✓ |
| Pilih/batalkan pilihan ekskul | — | ✓ | — | — |
| Tambah/ubah/hapus ekskul | — | — | ✓ | ✓ |
| Upload/hapus galeri foto ekskul | — | — | ✓ | ✓ |
| Lihat & catat absensi | — | — | ✓ | ✓ |
| Lihat jadwal | — | ✓ | ✓ | ✓ |
| Tambah/ubah/hapus jadwal | — | — | ✓ | — |
| Lihat penilaian | nilai sendiri | nilai sendiri | semua | rekap + predikat |
| Tambah/ubah/hapus penilaian | — | — | ✓ | — |
| Lihat laporan | — | ✓ | ✓ | ✓ + detail nilai |
| Data guru/siswa, penerimaan, akun guru, password request | — | — | — | ✓ |

Keterangan: tanda `—` berarti endpoint mengembalikan HTTP 403.

---

## 5. Daftar Endpoint

### 5.1 Autentikasi & Profil

| Method | URI | Role | Keterangan |
|---|---|---|---|
| POST | `/register` | Publik | Registrasi siswa baru |
| POST | `/login` | Publik | Login + terbitkan token |
| POST | `/forgot-password` | Publik | Ajukan ubah password |
| POST | `/logout` | Semua | Cabut token aktif |
| GET | `/me` | Semua | Data akun yang sedang login |
| GET | `/dashboard` | Semua | Ringkasan dashboard sesuai role |
| GET | `/profil` | Semua | Profil + info foto profil |
| GET | `/profil/foto` | Semua | Stream file foto profil privat |
| POST | `/profil/foto` | Semua | Upload/ganti foto profil |

### 5.2 Ekstrakurikuler & Pilihan

| Method | URI | Role | Keterangan |
|---|---|---|---|
| GET | `/ekstrakurikuler` | Semua | Daftar ekskul; siswa mendapat field `pilihan` |
| GET | `/ekstrakurikuler/{id}` | Semua | Detail ekskul + galeri foto |
| POST | `/ekstrakurikuler` | Admin, Guru | Tambah ekskul |
| PUT | `/ekstrakurikuler/{id}` | Admin, Guru | Ubah ekskul |
| DELETE | `/ekstrakurikuler/{id}` | Admin, Guru | Hapus ekskul + folder fotonya |
| POST | `/ekstrakurikuler/{id}/foto` | Admin, Guru | Upload maksimal 10 foto kegiatan |
| DELETE | `/ekstrakurikuler/{id}/foto/{foto}` | Admin, Guru | Hapus satu foto galeri |
| GET | `/pilihan-ekstrakurikuler` | Siswa | Daftar pilihan siswa |
| POST | `/pilihan-ekstrakurikuler` | Siswa | Simpan pilihan, menggantikan pilihan lama |
| DELETE | `/pilihan-ekstrakurikuler` | Siswa | Batalkan seluruh pilihan |
| POST | `/ekstrakurikuler/pilih` | Siswa | Alias `POST /pilihan-ekstrakurikuler` |
| POST | `/ekstrakurikuler/batal` | Siswa | Alias `DELETE /pilihan-ekstrakurikuler` |

### 5.3 Jadwal, Absensi, Penilaian, Laporan

| Method | URI | Role | Keterangan |
|---|---|---|---|
| GET | `/jadwal` | Semua | Jadwal wajib & gabungan akan datang |
| POST | `/jadwal` | Guru | Tambah jadwal |
| PUT | `/jadwal/{id}` | Guru | Ubah jadwal |
| DELETE | `/jadwal/{id}` | Guru | Hapus jadwal |
| GET | `/absensi` | Admin, Guru | Rekap absensi, siswa, dan ekskul |
| POST | `/absensi` | Admin, Guru | Simpan/perbarui absensi |
| GET | `/penilaian` | Semua | Nilai sesuai role |
| GET | `/penilaian/{id}` | Semua | Detail nilai; siswa hanya nilai sendiri |
| POST | `/penilaian` | Guru | Catat penilaian baru |
| PUT | `/penilaian/{id}` | Guru | Ubah nilai & keterangan |
| DELETE | `/penilaian/{id}` | Guru | Hapus penilaian |
| GET | `/laporan` | Semua | Laporan kegiatan; admin mendapat detail nilai |

### 5.4 Admin

| Method | URI | Role | Keterangan |
|---|---|---|---|
| GET | `/admin/data-guru` | Admin | Daftar akun guru |
| GET | `/admin/data-siswa` | Admin | Daftar siswa + jumlah per kelas |
| GET | `/admin/penerimaan-siswa` | Admin | Siswa berdasarkan status; query `status` |
| PUT | `/admin/penerimaan-siswa/{id}/terima` | Admin | Terima pendaftaran siswa |
| PUT | `/admin/penerimaan-siswa/{id}/tolak` | Admin | Tolak pendaftaran siswa |
| GET | `/admin/guru` | Admin | Daftar akun guru |
| POST | `/admin/guru` | Admin | Buat akun guru |
| PUT | `/admin/guru/{id}/reset-password` | Admin | Reset password guru |
| DELETE | `/admin/guru/{id}` | Admin | Hapus akun guru |
| GET | `/admin/password-requests` | Admin | Daftar permintaan ubah password |
| PUT | `/admin/password-requests/{id}/reset` | Admin | Reset password + kirim email |
| DELETE | `/admin/password-requests/{id}` | Admin | Hapus permintaan |

> Semua parameter `{id}` dan `{foto}` hanya menerima angka (`whereNumber`).

---

## 6. Contoh Request dan Respons

### 6.1 Registrasi Siswa

```json
{
  "name": "Siswa Baru",
  "nama_sekolah": "SMK Negeri 1 Contoh",
  "username": "siswabaru",
  "email": "siswabaru@gmail.com",
  "kelas": "X",
  "password": "rahasia123",
  "password_confirmation": "rahasia123"
}
```

Sarat: email harus berakhir `@gmail.com`, kelas salah satu dari `X`, `XI`, `XII`, password minimal 8 karakter. Status awal akun adalah `menunggu`.

### 6.2 Tambah Ekstrakurikuler

```json
{
  "nama_ekstrakurikuler": "Robotika",
  "deskripsi": "Ekstrakurikuler robotika dan otomasi.",
  "ikon": "R",
  "pembina": "Pak Ahmad",
  "jadwal": "Kamis",
  "tempat": "Lab Elektronika"
}
```

Nama field `nama` juga diterima sebagai alias `nama_ekstrakurikuler`. Respons sukses mengembalikan data ekskul dengan HTTP 201.

### 6.3 Simpan Pilihan Ekskul (Siswa)

```json
{
  "pilihan": [1, 3]
}
```

Minimal 1 dan maksimal 2 ID ekskul yang valid. Seluruh pilihan lama dihapus dan diganti dalam satu transaksi database.

### 6.4 Tambah Jadwal (Guru)

```json
{
  "nama_kegiatan": "Latihan Futsal",
  "jenis": "gabungan",
  "tanggal": "2026-11-25",
  "jam_mulai": "15:00",
  "jam_selesai": "16:30",
  "lokasi": "Lapangan Sekolah",
  "keterangan": "Latihan rutin"
}
```

`jenis` harus `wajib` atau `gabungan`; jam selesai harus lebih lambat dari jam mulai. Duplikat nama kegiatan pada tanggal dan jam yang sama ditolak.

### 6.5 Catat Absensi (Guru/Admin)

```json
{
  "username": "pahad",
  "nama_kegiatan": "Latihan Futsal",
  "tanggal": "2026-11-25",
  "status": "hadir"
}
```

Status valid: `hadir`, `izin`, `sakit`, `alpa`. Kombinasi username + kegiatan + tanggal bersifat unik; mengirim ulang akan memperbarui data yang ada.

### 6.6 Catat Penilaian (Guru)

```json
{
  "username": "pahad",
  "nama_kegiatan": "Latihan Futsal",
  "nilai": 85,
  "keterangan": "Teknik bagus, perlu latihan stamina"
}
```

Nilai 0–100. Respons menyertakan `predikat` (`Sangat Baik`, `Baik`, `Cukup`, `Kurang`) dan `nilai` yang sudah diformat.

### 6.7 Upload Foto Profil

Request `multipart/form-data` dengan field `foto` (JPG, JPEG, PNG, WEBP; maksimal 10 MB). Respons:

```json
{
  "success": true,
  "message": "Foto profil berhasil diperbarui!",
  "data": {
    "id": 4,
    "photo_path": "foto-profil/abc123.jpg",
    "url": "http://127.0.0.1:8000/api/v1/profil/foto"
  }
}
```

### 6.8 Upload Galeri Foto Kegiatan

Request `multipart/form-data` ke `/ekstrakurikuler/{id}/foto` dengan field `foto[]` (maksimal 10 file, tiap file 10 MB) dan opsional `keterangan` (maksimal 150 karakter).

### 6.9 Reset Password oleh Admin

```json
{
  "password": "PasswordBaru123"
}
```

Kirim ke `PUT /admin/password-requests/{id}/reset`. Jika `password` kosong, sistem membangkitkan password acak 10 karakter. Password baru dikirim lewat email bila SMTP aktif; pada lingkungan `local` tanpa SMTP, password ditampilkan di pesan respons untuk keperluan pengujian.

### 6.10 Contoh JavaScript (fetch)

```javascript
const BASE = 'http://127.0.0.1:8000/api/v1';
let token = null;

async function login(username, password) {
  const res = await fetch(`${BASE}/login`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    body: JSON.stringify({ username, password }),
  });
  const json = await res.json();
  if (!json.success) throw new Error(json.message);
  token = json.data.token;
  return json.data.user;
}

async function api(path, options = {}) {
  const res = await fetch(`${BASE}${path}`, {
    ...options,
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`,
      ...(options.headers || {}),
    },
  });
  return res.json();
}

await login('admin', 'password_admin');
console.log(await api('/dashboard'));
```

---

## 7. Validasi dan Kode Error

| HTTP | Makna | Penyebab umum |
|---|---|---|
| 200 | Berhasil | Operasi baca/update berhasil |
| 201 | Dibuat | Registrasi, tambah ekskul, jadwal, penilaian, upload foto berhasil |
| 401 | Tidak terautentikasi | Token tidak ada, salah, atau sudah dicabut; username/password salah |
| 403 | Tidak diizinkan | Role tidak sesuai; status siswa bukan `diterima`; akun sedang dipakai tidak bisa dihapus |
| 404 | Tidak ditemukan | ID tidak ada; foto profil tidak ada; username tidak ditemukan saat reset |
| 422 | Validasi gagal | Field wajib kosong, format salah, nilai di luar batas, data duplikat |
| 429 | Terlalu banyak request | Rate limit login, register, atau lupa password terlampaui |
| 500 | Error server | Lihat `storage/logs/laravel.log` |

Respons 422 selalu menyertakan objek `errors` berisi pesan per field.

---

## 8. Rate Limiting

| Endpoint | Batas | Kunci |
|---|---|---|
| `POST /login` | 5 percobaan/menit | username + IP |
| `POST /login` | 30 percobaan/menit | IP |
| `POST /register` | 6 percobaan/menit | IP |
| `POST /forgot-password` | 5 percobaan/menit | IP |

Saat batas terlampaui, respons HTTP 429 disertai pesan estimasi waktu tunggu dalam detik.

---

## 9. Catatan Implementasi

| Komponen | File | Fungsi |
|---|---|---|
| Definisi rute | `routes/api.php` | Seluruh 45 endpoint v1 |
| Registrasi | `bootstrap/app.php` | Prefix `api`, alias `api.token` & `api.role`, renderer exception JSON |
| Autentikasi | `app/Http/Middleware/ApiTokenAuth.php` | Cek token Bearer/X-API-Token + status siswa |
| Otorisasi | `app/Http/Middleware/ApiRole.php` | Pembatasan akses berdasarkan role |
| Controller dasar | `app/Http/Controllers/Api/V1/ApiController.php` | Helper `sukses()` & `gagal()` (wrapper JSON) |
| Controller | `app/Http/Controllers/Api/V1/` | 11 controller sesuai grup fitur |
| Kolom token | `database/migrations/2026_11_19_000001_add_api_token_to_users_table.php` | `users.api_token` |
| Model | `app/Models/User.php` | `api_token` disembunyikan dari serialisasi |
| Test | `tests/Feature/Api/V1ApiTest.php` | 8 test API |

Detail teknis:

- `users.api_token` menyimpan `hash('sha256', $token)`; token plain tidak pernah disimpan.
- Middleware `api.token` mengembalikan 401 bila header tidak ada atau hash tidak cocok.
- Middleware `api.role:admin,guru` menerima beberapa role yang dipisahkan koma.
- Exception handler di `bootstrap/app.php` merender semua error di bawah `api/*` sebagai JSON, termasuk `ModelNotFoundException` menjadi 404.
- Foto profil tetap disimpan privat di `storage/app/private/foto-profil`; endpoint `GET /profil/foto` melakukan stream setelah autentikasi.
- Nama kegiatan dinormalkan memakai trait `RapikanNama`, sama seperti aplikasi web, agar rekap laporan konsisten.

---

## 10. Pengujian

### 10.1 Test Otomatis

```bash
php artisan test --filter=V1ApiTest
```

Cakupan `tests/Feature/Api/V1ApiTest.php`:

| Test | Yang diverifikasi |
|---|---|
| `login me dan token tidak valid` | Login, struktur token, `/me`, token salah, token tidak ada, password salah |
| `kelas saat ini dihitung benar` | Field `kelas_saat_ini` pada `/me` sesuai accessor model (test regresi bug typo) |
| `logout mencabut token` | Token tidak berlaku setelah logout |
| `pembatasan role` | Admin boleh akses admin; guru & siswa ditolak 403 |
| `ekstrakurikuler dan validasi` | List, detail, create, update, validasi 422, delete |
| `siswa pilih dan batalkan ekskul` | Simpan, lihat, validasi, hapus pilihan |
| `guru jadwal absensi dan penilaian` | Create jadwal, absensi, penilaian, update, hapus |
| `admin penerimaan laporan dan profil` | Penerimaan siswa, laporan, profil, validasi upload |

Hasil terakhir: **8 test lulus (78 assertions)**.

### 10.2 Uji Manual Cepat

```bash
# Login
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d "{\"username\":\"admin\",\"password\":\"password_admin\"}"

# Ganti <TOKEN> dengan nilai data.token dari respons di atas
curl http://127.0.0.1:8000/api/v1/me \
  -H "Authorization: Bearer <TOKEN>"
```

### 10.3 Daftar Rute

```bash
php artisan route:list --path=api
```

---

*AKTIVIA — REST API v1*
