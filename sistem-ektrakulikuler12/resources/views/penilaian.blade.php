
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Ekstrakurikuler</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #0d6efd, #084298);
            color: white;
            padding: 25px 18px;
            z-index: 10;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo i {
            font-size: 35px;
            margin-bottom: 8px;
        }

        .logo h2 {
            font-size: 18px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,0.2);
        }

        .menu i {
            width: 22px;
        }

        .content {
            margin-left: 250px;
            padding: 35px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 30px;
            color: #172554;
        }

        .header p {
            color: #6b7280;
            margin-top: 5px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
            overflow-x: auto;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-title i {
            color: #0d6efd;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 13px;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
        }

        textarea {
            resize: vertical;
            min-height: 75px;
        }

        .full {
            grid-column: 1 / -1;
        }

        .btn {
            border: none;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            padding: 9px 14px;
            border-radius: 7px;
            font-size: 12px;
            font-family: inherit;
            cursor: pointer;
            display: inline-block;
        }

        .btn:hover {
            background: #084298;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-danger:hover {
            background: #991b1b;
        }

        .btn-secondary {
            background: #64748b;
        }

        .message {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th {
            background: #0d6efd;
            color: white;
            padding: 14px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .nilai {
            font-weight: 700;
            color: #0d6efd;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .baik {
            background: #dcfce7;
            color: #15803d;
        }

        .cukup {
            background: #fef3c7;
            color: #a16207;
        }

        .kurang {
            background: #fee2e2;
            color: #b91c1c;
        }

        .aksi {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #6b7280;
        }

        @media(max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 20px 10px;
            }

            .logo h2,
            .menu span {
                display: none;
            }

            .menu a {
                justify-content: center;
            }

            .content {
                margin-left: 70px;
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-school"></i>
            <h2>EKSTRA</h2>
        </div>

        <div class="menu">
            <a href="{{ route('dashboard.guru') }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('guru.kegiatan') }}">
                <i class="fa-solid fa-users"></i>
                <span>Ekstrakurikuler</span>
            </a>

            <a href="{{ route('guru.penilaian') }}" class="active">
                <i class="fa-solid fa-star"></i>
                <span>Penilaian Siswa</span>
            </a>

            <a href="{{ route('guru.absensi') }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Absensi Siswa</span>
            </a>

            <a href="{{ route('guru.profil') }}">
                <i class="fa-solid fa-user"></i>
                <span>Profil</span>
            </a>

            <a href="{{ route('guru.laporan') }}">
                <i class="fa-solid fa-file"></i>
                <span>Laporan</span>
            </a>

            <a href="{{ route('logout') }}">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="content">

        <div class="header">
            <h1>Penilaian Ekstrakurikuler</h1>
            <p>Kelola dan pantau hasil penilaian siswa ekstrakurikuler.</p>
        </div>

        @if(session('success'))
            <div class="message success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="message error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="card">
            <div class="card-title">
                <i class="fa-solid fa-pen-to-square"></i>
                <h2>Tambah Penilaian Siswa</h2>
            </div>

            <form action="{{ route('guru.penilaian.simpan') }}" method="POST">
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label>Nama Siswa</label>

                        <select name="username" required>
                            <option value="">-- Pilih Siswa --</option>

                            @forelse(($siswa ?? collect()) as $user)
                                <option value="{{ $user->username }}"
                                    {{ old('username') == $user->username ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->username }})
                                </option>
                            @empty
                                <option value="" disabled>Belum ada akun siswa</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Ekstrakurikuler</label>
                        <input type="text"
                               name="nama_kegiatan"
                               value="{{ old('nama_kegiatan') }}"
                               placeholder="Contoh: Futsal"
                               maxlength="100"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Nilai (0–100)</label>
                        <input type="number"
                               name="nilai"
                               min="0"
                               max="100"
                               step="0.01"
                               value="{{ old('nilai') }}"
                               placeholder="Masukkan nilai"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan"
                                  placeholder="Masukkan keterangan penilaian">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="form-group full">
                        <button type="submit" class="btn">
                            <i class="fa-solid fa-save"></i>
                            Simpan Penilaian
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="fa-solid fa-clipboard-check"></i>
                <h2>Daftar Nilai Siswa</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Ekstrakurikuler</th>
                        <th>Nilai</th>
                        <th>Predikat</th>
                        <th>Keterangan</th>
                        <th>Dicatat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($nilai ?? collect()) as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td class="nilai">{{ $item->nilai }}</td>

                            <td>
                                @if($item->nilai >= 85)
                                    <span class="badge baik">Sangat Baik</span>
                                @elseif($item->nilai >= 75)
                                    <span class="badge cukup">Cukup</span>
                                @else
                                    <span class="badge kurang">Perlu Bimbingan</span>
                                @endif
                            </td>

                            <td>{{ $item->keterangan ?: '-' }}</td>
                            <td>{{ $item->dicatat_oleh ?: '-' }}</td>

                            <td>
                                <div class="aksi">
                                    <button type="button"
                                            class="btn"
                                            onclick="editNilai(this)"
                                            data-id="{{ $item->id }}"
                                            data-nilai="{{ $item->nilai }}"
                                            data-keterangan="{{ $item->keterangan }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('guru.penilaian.hapus', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus penilaian ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada data penilaian siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card" id="formEdit" style="display:none;">
            <div class="card-title">
                <i class="fa-solid fa-pen"></i>
                <h2>Edit Penilaian</h2>
            </div>

            <form id="formEditNilai" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">
                        <label>Nilai (0–100)</label>
                        <input type="number" name="nilai" id="editNilai"
                               min="0" max="100" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="editKeterangan"></textarea>
                    </div>

                    <div class="form-group full">
                        <button type="submit" class="btn">
                            Simpan Perubahan
                        </button>

                        <button type="button" class="btn btn-secondary"
                                onclick="document.getElementById('formEdit').style.display='none'">
                            Batal
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </main>

    <script>
        function editNilai(button) {
            const id = button.dataset.id;

            document.getElementById('formEditNilai').action =
                "{{ url('/guru/penilaian') }}/" + id;

            document.getElementById('editNilai').value =
                button.dataset.nilai;

            document.getElementById('editKeterangan').value =
                button.dataset.keterangan || '';

            const form = document.getElementById('formEdit');
            form.style.display = 'block';

            form.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    </script>

</body>
</html>
