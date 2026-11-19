# AKTIVIA — USER MANUAL

**Sistem Informasi Ekstrakurikuler Berbasis Web**

| Field | Keterangan |
|---|---|
| Dokumen | User Manual / Panduan Pengguna Akhir |
| Aplikasi | AKTIVIA — Sistem Informasi Ekstrakurikuler |
| Versi | 1.0 |
| Tanggal | 19 November 2026 |
| Audiens | Admin, Guru, Siswa |
| Status | Final untuk penggunaan lokal |

---

## Riwayat Revisi

| Versi | Tanggal | Keterangan | Penulis |
|---|---|---|---|
| 1.0 | 19 November 2026 | Penyusunan manual penggunaan akhir | Tim Pengembang |

---

## Daftar Isi

1. [Pendahuluan](#1-pendahuluan)
2. [Akses Aplikasi](#2-akses-aplikasi)
3. [Alur Umum Penggunaan](#3-alur-umum-penggunaan)
4. [Modul Admin](#4-modul-admin)
5. [Modul Guru](#5-modul-guru)
6. [Modul Siswa](#6-modul-siswa)
7. [Pengelolaan Foto](#7-pengelolaan-foto)
8. [Pesan dan Penanganan Masalah](#8-pesan-dan-penanganan-masalah)
9. [Glosarium](#9-glosarium)
10. [Bantuan](#10-bantuan)

---

## 1. Pendahuluan

### 1.1 Tujuan Dokumen

Dokumen ini membantu pengguna memahami cara menggunakan AKTIVIA sesuai dengan peran (role) masing-masing. Setiap prosedur ditulis langkah demi langkah agar dapat diikuti tanpa pengetahuan teknis khusus.

### 1.2 Audiens

| Peran | Deskripsi |
|---|---|
| Admin | Pengelola seluruh data dan pengguna sistem |
| Guru | Pengelola kegiatan, absensi, penilaian, dan jadwal |
| Siswa | Peserta ekstrakurikuler yang melihat informasi dan mengirim pilihan |

### 1.3 Ruang Lingkup

Manual ini mencakup:

- Proses login dan logout.
- Pengelolaan data ekstrakurikuler.
- Penerimaan pendaftar siswa.
- Pengelolaan jadwal, absensi, dan penilaian.
- Pendaftaran ekstrakurikuler oleh siswa.
- Pengelolaan foto profil dan galeri foto kegiatan.

---

## 2. Akses Aplikasi

### 2.1 Alamat Aplikasi

```text
http://127.0.0.1:8000
```

Halaman awal akan otomatis dialihkan ke halaman login.

### 2.2 Persyaratan Browser

- Chrome, Edge, atau Firefox versi terbaru.
- JavaScript aktif.
- Izinkan penyimpanan cookie/session.

### 2.3 Prosedur Login

1. Buka alamat aplikasi di browser.
2. Masukkan **Username**.
3. Masukkan **Password**.
4. Klik tombol **Masuk ke Sistem**.
5. Sistem akan mengalihkan ke dashboard sesuai role.

> [Gambar 1: Halaman Login AKTIVIA]

Jika login gagal, periksa kembali username dan password. Untuk siswa, pastikan status pendaftaran sudah **diterima** oleh admin.

Gunakan akun yang sudah terdaftar di sistem (admin, guru, dan siswa). Aplikasi **tidak membuat akun baru** saat deploy dan tidak mengubah akun yang sudah ada. Hubungi admin jika username atau password belum diketahui.

### 2.4 Prosedur Logout

1. Klik menu **Logout** pada sidebar.
2. Halaman konfirmasi logout akan muncul.
3. Klik **Ya, Keluar**.
4. Anda akan kembali ke halaman login.

> [Gambar 2: Halaman Konfirmasi Logout]

### 2.5 Lupa Password

1. Pada halaman login, klik **Lupa password**.
2. Isi data yang diminta.
3. Kirim permintaan.
4. Admin akan memproses permintaan melalui menu **Password Requests**.
5. Password baru akan dikirim ke email terdaftar.

---

## 3. Alur Umum Penggunaan

```text
Login
  ↓
Dashboard sesuai role
  ↓
Pilih menu modul
  ↓
Lakukan operasi (tambah/ubah/hapus/lihat)
  ↓
Simpan → sistem menampilkan pesan hasil
  ↓
Logout
```

| Role | Dashboard | Menu Utama |
|---|---|---|
| Admin | `/dashboard-admin` | Ekstrakurikuler, Data Guru, Data Siswa, Penerimaan, Penilaian, Laporan, Profil |
| Guru | `/dashboard-guru` | Ekstrakurikuler, Jadwal, Absensi, Penilaian, Laporan, Profil |
| Siswa | `/dashboard-siswa` | Daftar Ekstrakurikuler, Jadwal, Penilaian Saya, Profil |

---

## 4. Modul Admin

### 4.1 Dashboard Admin

Dashboard menampilkan ringkasan jumlah ekskul, guru, siswa, dan pendaftaran.

> [Gambar 3: Dashboard Admin]

### 4.2 Mengelola Ekstrakurikuler

**Menambah ekskul**

1. Buka menu **Ekstrakurikuler**.
2. Klik **Tambah Ekstrakurikuler**.
3. Isi field berikut:
   - Nama ekstrakurikuler
   - Pembina
   - Jadwal
   - Deskripsi
   - Ikon
   - Tempat
4. Klik **Simpan**.
5. Pesan sukses akan muncul jika data tersimpan.

**Mengubah ekskul**

1. Pada daftar ekskul, klik **Edit**.
2. Ubah data yang diperlukan.
3. Klik **Simpan Perubahan**.

**Menghapus ekskul**

1. Klik **Hapus** pada baris ekskul.
2. Konfirmasi penghapusan.
3. Data ekskul dan folder foto kegiatan akan ikut terhapus.

> [Gambar 4: Daftar Ekstrakurikuler Admin]

### 4.3 Penerimaan Siswa

1. Buka menu **Penerimaan Siswa**.
2. Gunakan filter status: `menunggu`, `diterima`, atau `ditolak`.
3. Untuk pendaftar baru, klik **Terima** atau **Tolak**.
4. Siswa yang diterima dapat login dan menggunakan fitur siswa.

> [Gambar 5: Halaman Penerimaan Siswa]

### 4.4 Mengelola Data Guru

1. Buka menu **Data Guru** atau **Akun Guru**.
2. Klik **Tambah Guru** untuk membuat akun baru.
3. Isi username, nama, email, dan password.
4. Klik **Simpan**.
5. Gunakan **Reset Password** jika guru lupa password.
6. Akun guru dapat dihapus, kecuali akun yang sedang digunakan sendiri.

### 4.5 Mengelola Permintaan Password

1. Buka menu **Password Requests**.
2. Lihat daftar permintaan dengan status `menunggu`.
3. Klik **Reset** untuk membuatkan password baru.
4. Sistem mengirim password ke email pengguna.
5. Permintaan yang selesai dapat dihapus.

### 4.6 Melihat Laporan dan Rekap

| Menu | Fungsi |
|---|---|
| Data Siswa | Daftar siswa dan sebaran kelas |
| Absensi | Rekap kehadiran seluruh siswa |
| Penilaian | Rekap nilai seluruh siswa |
| Laporan | Laporan lengkap kegiatan ekstrakurikuler |

---

## 5. Modul Guru

### 5.1 Dashboard Guru

Menampilkan ringkasan ekskul binaan dan aktivitas terbaru.

> [Gambar 6: Dashboard Guru]

### 5.2 Mengelola Ekstrakurikuler Binaan

Prosedur sama seperti admin, tetapi hanya untuk ekskul yang dikelola guru. Menu tersedia di **Ekstrakurikuler**.

### 5.3 Mengelola Jadwal Kegiatan

1. Buka menu **Jadwal**.
2. Klik **Tambah Jadwal**.
3. Isi:
   - Nama kegiatan
   - Jenis (`wajib` atau `gabungan`)
   - Nama ekstrakurikuler / sekolah mitra
   - Tanggal
   - Jam mulai dan jam selesai
   - Lokasi
   - Keterangan
4. Klik **Simpan**.
5. Jadwal dengan kombinasi nama kegiatan, tanggal, dan jam mulai yang sama tidak boleh duplikat.

### 5.4 Mencatat Absensi

1. Buka menu **Absensi**.
2. Pilih kegiatan dan tanggal.
3. Tentukan status kehadiran setiap siswa (Hadir / Sakit / Izin / Alpa).
4. Klik **Simpan Absensi**.
5. Jika data untuk siswa, kegiatan, dan tanggal yang sama sudah ada, sistem akan memperbaruinya.

> [Gambar 7: Halaman Absensi]

### 5.5 Input Penilaian

1. Buka menu **Penilaian**.
2. Pilih siswa dan nama kegiatan.
3. Masukkan nilai dan keterangan.
4. Klik **Simpan**.
5. Nilai dapat diubah atau dihapus melalui tombol pada baris data.

**Predikat nilai:**

| Nilai | Predikat |
|---|---|
| 90 – 100 | Sangat Baik |
| 80 – 89 | Baik |
| 70 – 79 | Cukup |
| < 70 | Perlu Bimbingan |

### 5.6 Melihat Laporan

Buka menu **Laporan** untuk melihat rekap kegiatan dan hasil penilaian ekskul binaan.

---

## 6. Modul Siswa

### 6.1 Dashboard Siswa

Menampilkan informasi akun, kelas, dan pilihan ekstrakurikuler.

> [Gambar 8: Dashboard Siswa]

### 6.2 Mendaftar Ekstrakurikuler

1. Buka menu **Daftar Ekstrakurikuler**.
2. Lihat daftar ekskul yang tersedia.
3. Pilih maksimal **2 ekskul** sesuai minat.
4. Klik **Simpan Pilihan**.
5. Jika ingin membatalkan, klik **Batalkan Pilihan**.

> [Gambar 9: Daftar Ekstrakurikuler Siswa]

### 6.3 Melihat Detail dan Foto Kegiatan

1. Klik nama ekskul atau tombol **Detail**.
2. Halaman detail menampilkan deskripsi, pembina, jadwal, tempat, dan galeri foto.
3. Siswa hanya dapat **melihat** foto; tombol unggah dan hapus tidak tersedia.

> [Gambar 10: Detail Ekstrakurikuler dengan Galeri Foto]

### 6.4 Melihat Jadwal

Buka menu **Jadwal Kegiatan** untuk melihat jadwal ekskul wajib dan gabungan.

### 6.5 Melihat Penilaian

1. Buka menu **Penilaian Saya**.
2. Lihat daftar nilai per kegiatan.
3. Klik **Detail** untuk melihat keterangan nilai.

---

## 7. Pengelolaan Foto

### 7.1 Foto Profil

Berlaku untuk Admin, Guru, dan Siswa.

1. Buka menu **Profil**.
2. Pada bagian **Foto Profil**, klik **Choose file**.
3. Pilih foto dengan ketentuan:
   - Format: JPG, JPEG, PNG, WEBP
   - Ukuran maksimal: **10 MB**
4. Klik **Simpan Foto Profil**.
5. Jika berhasil, pesan **"Foto profil berhasil diperbarui!"** muncul.
6. Foto tampil pada sidebar dan kartu profil.

> [Gambar 11: Halaman Profil dengan Form Upload Foto]

> Jika foto belum tampil, tekan **Ctrl + F5** untuk menyegarkan halaman.

### 7.2 Galeri Foto Kegiatan

Berlaku untuk Admin dan Guru. Siswa hanya melihat.

**Menambah foto**

1. Buka halaman edit/detail ekskul.
2. Scroll ke bagian **Foto Kegiatan**.
3. Klik **Choose files**.
4. Pilih maksimal **10 foto** sekaligus, masing-masing maksimal **10 MB**.
5. Isi keterangan opsional.
6. Klik **Unggah Foto**.

**Menghapus foto**

1. Temukan foto yang ingin dihapus.
2. Klik tombol **Hapus**.
3. Konfirmasi penghapusan.

> [Gambar 12: Galeri Foto Kegiatan]

### 7.3 Format yang Tidak Didukung

Foto dari iPhone berformat **HEIC/HEIF** belum didukung. Ubah ke JPG terlebih dahulu melalui pengaturan kamera atau aplikasi konversi.

---

## 8. Pesan dan Penanganan Masalah

| Pesan | Penyebab | Tindakan |
|---|---|---|
| `Silakan pilih foto terlebih dahulu.` | Belum memilih file | Pilih file sebelum menyimpan |
| `File harus berupa gambar.` | File bukan gambar | Pilih JPG/PNG/WEBP |
| `Format foto harus JPG, JPEG, PNG, atau WEBP.` | Format tidak didukung | Konversi ke JPG/PNG |
| `Ukuran foto maksimal 10 MB.` | File terlalu besar | Kompres atau resize foto |
| `Pendaftaran Anda masih menunggu persetujuan admin.` | Status siswa belum diterima | Hubungi admin |
| `Pendaftaran Anda telah ditolak.` | Status siswa ditolak | Hubungi admin |
| `Page expired (419)` | Token CSRF habis | Refresh halaman dan isi ulang form |
| `Halaman tidak ditemukan (404)` | Alamat salah / data terhapus | Periksa kembali alamat |

Untuk masalah teknis lebih lanjut, lihat [TROUBLESHOOTING.md](TROUBLESHOOTING.md).

---

## 9. Glosarium

| Istilah | Arti |
|---|---|
| Ekstrakurikuler | Kegiatan di luar pelajaran wajib yang diikuti siswa |
| Absensi | Catatan kehadiran siswa pada suatu kegiatan |
| Penilaian | Nilai yang diberikan guru untuk siswa |
| Predikat | Kategori nilai (Sangat Baik, Baik, Cukup, Perlu Bimbingan) |
| Role | Peran pengguna: admin, guru, atau siswa |
| Session | Data login yang tersimpan selama pengguna aktif |
| CSRF | Token keamanan untuk mencegah pengiriman form dari situs lain |
| Galeri | Kumpulan foto kegiatan suatu ekskul |

---

## 10. Bantuan

Jika mengalami kendala:

1. Periksa pesan error yang muncul.
2. Coba segarkan halaman dengan **Ctrl + F5**.
3. Pastikan browser dan koneksi lokal berfungsi.
4. Hubungi admin sekolah atau tim pengembang.

Dokumen terkait:

- [Technical Documentation](TECH-DOCS.md)
- [Dokumentasi Proyek Lengkap](DOKUMENTASI-PROYEK.md)
- [Troubleshooting](TROUBLESHOOTING.md)

---

*AKTIVIA — User Manual v1.0*
