
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa - AKTIVIA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 25px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            background: #093c5d;
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 8px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
        }

        button {
            background: #093c5d;
            color: white;
            padding: 12px 22px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            margin-top: 18px;
        }

        button:hover {
            background: #145579;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #eaf2f8;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 15px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <h1>Absensi Siswa</h1>
        <p>AKTIVIA - Sistem Informasi Ekstrakurikuler</p>
        <p>Login sebagai: {{ session('role') }}</p>
    </div>

    <div class="card">
        <h2>Formulir Absensi</h2>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error">
                <strong>Periksa kembali data yang diisi:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url()->current() }}" method="POST">
            @csrf

            <div class="form-grid">
                <div>
                    <label>Username Siswa</label>
                    <input type="text" name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username siswa" required>
                </div>

                <div>
                    <label>Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan"
                        value="{{ old('nama_kegiatan') }}"
                        placeholder="Contoh: Futsal" required>
                </div>

                <div>
                    <label>Tanggal Absensi</label>
                    <input type="date" name="tanggal"
                        value="{{ old('tanggal', date('Y-m-d')) }}"
                        required>
                </div>

                <div>
                    <label>Status Kehadiran</label>
                    <select name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpa" {{ old('status') == 'alpa' ? 'selected' : '' }}>Alpa</option>
                    </select>
                </div>
            </div>

            <button type="submit">Simpan Absensi</button>
        </form>
    </div>

    <div class="card">
        <h2>Riwayat Absensi Siswa</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absensi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td class="status">{{ $item->status }}</td>
                            <td>{{ $item->dicatat_oleh }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
