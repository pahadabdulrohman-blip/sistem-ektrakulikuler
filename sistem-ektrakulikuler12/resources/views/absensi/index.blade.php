
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa - AKTIVIA</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f6fa;
            color: #17202a;
        }

        .main {
            margin-left: 270px;
            padding: 35px;
        }

        .header, .card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        h1, h2 {
            color: #116b43;
        }

        h1 {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .subtitle {
            color: #718096;
            font-size: 13px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 22px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 13px;
            border: 1px solid #dce5df;
            border-radius: 9px;
            font-family: inherit;
            font-size: 13px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #148f5a;
        }

        .btn {
            border: none;
            background: #148f5a;
            color: white;
            padding: 13px 22px;
            border-radius: 9px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            margin-top: 22px;
        }

        .btn:hover {
            background: #087847;
        }

        .back {
            display: inline-block;
            color: #148f5a;
            text-decoration: none;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .message {
            padding: 13px;
            border-radius: 9px;
            margin-top: 15px;
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

        .table-wrapper {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            background: #148f5a;
            color: white;
            text-align: left;
            padding: 14px;
            font-size: 12px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e8edf1;
            font-size: 13px;
        }

        .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            background: #d9f7e7;
            color: #087847;
            font-size: 11px;
            font-weight: 600;
        }

        @media(max-width: 800px) {
            .main {
                margin-left: 0;
                padding: 18px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div style="margin-bottom: 20px;">
    <a href="{{ url('/dashboard') }}"
       style="
            display: inline-block;
            padding: 12px 22px;
            background-color: #0b3d5c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
       ">
        ← Kembali ke Dashboard
    </a>
</div>

<main class="main">
    

    <a href="{{ route('dashboard.guru') }}" class="back">
        ← Kembali ke Dashboard Guru
    </a>

    <header class="header">
        <h1>Absensi Siswa</h1>
        <p class="subtitle">
            Kelola dan catat kehadiran siswa dalam kegiatan ekstrakurikuler.
        </p>
    </header>

    <section class="card">

        <h2>Formulir Absensi</h2>

        @if(session('success'))
            <div class="message success">
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

        <form action="{{ route('guru.absensi.simpan') }}" method="POST">
            @csrf

            <div class="form-grid">

                <div>
                    <label>Nama Siswa</label>
                    <select name="username" required>
                        <option value="">-- Pilih Siswa --</option>

                        @foreach($siswa as $item)
                            <option value="{{ $item->username }}"
                                {{ old('username') == $item->username ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->username }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Nama Kegiatan</label>
                    <input
                        type="text"
                        name="nama_kegiatan"
                        value="{{ old('nama_kegiatan') }}"
                        placeholder="Contoh: Futsal"
                        required
                    >
                </div>

                <div>
                    <label>Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal', date('Y-m-d')) }}"
                        required
                    >
                </div>

                <div>
                    <label>Status Kehadiran</label>
                    <select name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpa">Alpa</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn">
                Simpan Absensi
            </button>
        </form>

    </section>

    <section class="card">

        <h2>Rekap Absensi Siswa</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username Siswa</th>
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absensi as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                <span class="status">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>{{ $item->dicatat_oleh }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </section>

</main>

</body>
</html>
