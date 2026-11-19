# PANDUAN PENGGUNAAN — AKTIVIA

Panduan ini ditujukan untuk pengguna aplikasi: **Admin**, **Guru**, dan **Siswa**.

## 1. Masuk ke Aplikasi

1. Buka browser dan kunjungi `http://127.0.0.1:8000`.
2. Halaman utama akan otomatis mengarahkan ke halaman **Login**.
3. Masukkan **Username** dan **Password**.
4. Klik **Masuk ke Sistem**.
5. Anda akan diarahkan ke dashboard sesuai role:

| Role | Dashboard |
|---|---|
| Admin | `/dashboard-admin` |
| Guru | `/dashboard-guru` |
| Siswa | `/dashboard-siswa` |

> Untuk siswa, akun harus berstatus **diterima**. Jika masih `menunggu` atau `ditolak`, login akan ditolak dengan pesan yang sesuai.

### Lupa password

1. Klik **Lupa password** di halaman login.
2. Isi username/email yang terdaftar.
3. Admin akan menerima permintaan reset di menu **Password Requests**.
4. Setelah admin mereset, password baru dikirim ke email (atau ke log saat mailer masih `log`).

### Keluar

1. Klik menu **Logout**.
2. Akan muncul halaman konfirmasi.
3. Klik **Ya, Keluar** untuk mengakhiri sesi.

---

## 2. Panduan Admin

### 2.1 Dashboard

Dashboard admin menampilkan ringkasan jumlah ekskul, guru, siswa, dan pendaftaran.

### 2.2 Mengelola Ekstrakurikuler

1. Buka menu **Ekstrakurikuler**.
2. Klik **Tambah Ekstrakurikuler** untuk membuat data baru.
3. Isi nama, pembina, jadwal, deskripsi, ikon, dan tempat.
4. Klik **Simpan**.
5. Untuk mengubah, klik tombol **Edit** pada baris ekskul.
6. Untuk menghapus, klik **Hapus** dan konfirmasi. Folder foto kegiatan ekskul tersebut ikut terhapus.

### 2.3 Menerima atau Menolak Siswa

1. Buka menu **Penerimaan Siswa**.
2. Gunakan filter status untuk melihat pendaftar `menunggu`, `diterima`, atau `ditolak`.
3. Klik **Terima** atau **Tolak** pada siswa yang bersangkutan.
4. Siswa yang diterima dapat login dan memakai fitur siswa.

### 2.4 Mengelola Guru

1. Buka menu **Data Guru** atau **Akun Guru**.
2. Tambah akun guru dengan username, nama, email, dan password.
3. Gunakan **Reset Password** jika guru lupa password.
4. Hapus akun guru bila diperlukan (akun sendiri tidak bisa dihapus).

### 2.5 Melihat Data dan Laporan

- **Data Siswa**: melihat daftar siswa dan sebaran kelas.
- **Absensi**: rekap kehadiran seluruh siswa.
- **Penilaian**: rekap nilai seluruh siswa.
- **Laporan**: laporan lengkap kegiatan ekstrakurikuler.

### 2.6 Foto Profil

1. Buka menu **Profil**.
2. Klik **Choose file** / **Pilih foto**.
3. Pilih foto JPG, JPEG, PNG, atau WEBP dengan ukuran maksimal **10 MB**.
4. Klik **Simpan Foto Profil**.
5. Jika berhasil, muncul pesan **"Foto profil berhasil diperbarui!"**.

---

## 3. Panduan Guru

### 3.1 Dashboard

Dashboard guru menampilkan ringkasan kegiatan dan ekskul binaan.

### 3.2 Mengelola Ekstrakurikuler dan Foto Kegiatan

1. Buka menu **Ekstrakurikuler**.
2. Tambah atau edit ekskul binaan.
3. Pada halaman edit/detail tersedia bagian **Foto Kegiatan**.
4. Untuk menambah foto:
   - Klik **Choose files**.
   - Pilih maksimal **10 foto** sekaligus (JPG/JPEG/PNG/WEBP, maksimal 10 MB per foto).
   - Isi keterangan opsional.
   - Klik **Unggah Foto**.
5. Untuk menghapus foto, klik tombol **Hapus** pada foto yang bersangkutan dan konfirmasi.

### 3.3 Mengelola Jadwal

1. Buka menu **Jadwal**.
2. Isi nama kegiatan, jenis (`wajib` atau `gabungan`), nama ekskul/mitra, tanggal, jam mulai, jam selesai, dan lokasi.
3. Klik **Simpan**.
4. Jadwal dengan nama kegiatan, tanggal, dan jam mulai yang sama tidak boleh duplikat.

### 3.4 Absensi

1. Buka menu **Absensi**.
2. Pilih kegiatan dan tanggal.
3. Tentukan status kehadiran tiap siswa.
4. Klik **Simpan Absensi**.
5. Data yang sudah ada akan diperbarui otomatis untuk kombinasi siswa + kegiatan + tanggal yang sama.

### 3.5 Penilaian

1. Buka menu **Penilaian**.
2. Pilih siswa dan kegiatan.
3. Masukkan nilai dan keterangan.
4. Klik **Simpan**.
5. Nilai bisa diubah atau dihapus, tetapi hanya untuk data yang dicatat oleh guru yang bersangkutan.

### 3.6 Laporan dan Profil

- **Laporan**: lihat rekap kegiatan dan hasil penilaian.
- **Profil**: ubah foto profil dengan cara yang sama seperti admin (maksimal 10 MB).

---

## 4. Panduan Siswa

### 4.1 Dashboard

Dashboard siswa menampilkan informasi akun, kelas, dan pilihan ekstrakurikuler.

### 4.2 Mendaftar Ekstrakurikuler

1. Buka menu **Daftar Ekstrakurikuler**.
2. Lihat daftar ekskul yang tersedia.
3. Pilih maksimal **2 ekskul** sesuai minat.
4. Klik **Simpan Pilihan**.
5. Jika ingin membatalkan, klik **Batalkan Pilihan**.

### 4.3 Melihat Detail dan Foto Kegiatan

1. Pada daftar ekskul, klik **Detail** / nama ekskul.
2. Halaman detail menampilkan deskripsi, pembina, jadwal, tempat, dan **galeri foto kegiatan**.
3. Siswa **hanya bisa melihat** foto. Tombol unggah dan hapus tidak tersedia.

### 4.4 Jadwal dan Penilaian

- **Jadwal Kegiatan**: melihat daftar jadwal ekskul wajib dan gabungan.
- **Penilaian Saya**: melihat nilai beserta predikat:

| Nilai | Predikat |
|---|---|
| ≥ 90 | Sangat Baik |
| ≥ 80 | Baik |
| ≥ 70 | Cukup |
| < 70 | Perlu Bimbingan |

### 4.5 Foto Profil

1. Buka menu **Profil**.
2. Klik **Choose file** pada bagian **Foto Profil**.
3. Pilih foto JPG/JPEG/PNG/WEBP maksimal **10 MB**.
4. Klik **Simpan Foto Profil**.
5. Foto akan tampil di sidebar dan kartu profil setelah halaman dimuat ulang.

> Jika foto tidak langsung tampil, lakukan **Ctrl + F5** (hard refresh). Aplikasi sudah menambahkan penanda cache otomatis pada URL gambar.

---

## 5. Format File yang Diterima

| Jenis unggahan | Format | Ukuran | Jumlah |
|---|---|---|---|
| Foto profil | JPG, JPEG, PNG, WEBP | Maksimal 10 MB | 1 file |
| Foto kegiatan ekskul | JPG, JPEG, PNG, WEBP | Maksimal 10 MB per foto | Maksimal 10 foto per unggahan |

Foto berformat HEIC/HEIF (umumnya dari iPhone) **belum didukung**. Konversi terlebih dahulu ke JPG.

---

## 6. Pesan Umum

| Pesan | Arti | Solusi |
|---|---|---|
| `Silakan pilih foto terlebih dahulu.` | Belum ada file yang dipilih | Pilih file sebelum menekan simpan |
| `File harus berupa gambar.` | File bukan gambar | Pilih file JPG/PNG/WEBP |
| `Format foto harus JPG, JPEG, PNG, atau WEBP.` | Ekstensi tidak didukung | Konversi gambar ke JPG/PNG |
| `Ukuran foto maksimal 10 MB.` | File terlalu besar | Kompres/resize foto |
| `Pendaftaran Anda masih menunggu persetujuan admin.` | Status siswa belum diterima | Hubungi admin |
| `Halaman ini tidak tersedia untuk akun Anda.` | Role tidak sesuai hak akses | Login dengan akun yang tepat |

---

Lihat juga [Dokumentasi Proyek](DOKUMENTASI-PROYEK.md) dan [Troubleshooting](TROUBLESHOOTING.md).
