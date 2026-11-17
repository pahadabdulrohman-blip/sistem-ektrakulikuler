<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penerimaan Siswa - Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            color: #222;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: #111827;
            padding: 25px 15px;
            color: white;
            overflow-y: auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h2 {
            font-size: 20px;
        }

        .logo p {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 5px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: #d1d5db;
            padding: 14px 15px;
            border-radius: 8px;
            margin-bottom: 7px;
        }

        .menu a i {
            width: 18px;
            margin-right: 8px;
            text-align: center;
        }

        .menu a:hover,
        .menu a.active {
            background: #2563eb;
            color: white;
        }

        .content {
            margin-left: 240px;
            padding: 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 12px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 7px;
        }

        .header p {
            color: #6b7280;
        }

        .back {
            text-decoration: none;
            background: #111827;
            color: white;
            padding: 11px 18px;
            border-radius: 8px;
            white-space: nowrap;
        }

        .message {
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            padding: 22px 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
            text-decoration: none;
            color: inherit;
            border: 2px solid transparent;
        }

        .summary-card:hover {
            border-color: #2563eb;
        }

        .summary-card h2 {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .summary-total {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .summary-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-menunggu {
            background: #fef3c7;
            color: #b45309;
        }

        .icon-diterima {
            background: #dcfce7;
            color: #15803d;
        }

        .icon-ditolak {
            background: #fee2e2;
            color: #b91c1c;
        }

        .summary-total strong {
            font-size: 28px;
            line-height: 1;
            color: #111827;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
            margin-bottom: 25px;
            overflow-x: auto;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .card h2 {
            font-size: 19px;
            color: #1f2937;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filters a {
            text-decoration: none;
            color: #374151;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
        }

        .filters a:hover,
        .filters a.active {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
            vertical-align: middle;
        }

        tr:hover td {
            background: #f9fafb;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .status-diterima {
            background: #dcfce7;
            color: #166534;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        .aksi {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-small {
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 7px;
            font-family: inherit;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-terima {
            background: #15803d;
        }

        .btn-terima:hover {
            background: #166534;
        }

        .btn-tolak {
            background: #dc2626;
        }

        .btn-tolak:hover {
            background: #991b1b;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 25px;
        }

        @media(max-width: 1000px) {
            .summary {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 800px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 20px 16px;
            }

            .logo {
                margin-bottom: 18px;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
                gap: 7px;
            }

            .menu a {
                flex: 1 1 calc(50% - 7px);
                text-align: center;
                margin-bottom: 0;
            }

            .content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">
            <h2>ADMIN PANEL</h2>
            <p>Sistem Ekstrakurikuler</p>
        </div>

        <div class="menu">

            <a href="{{ route('dashboard.admin') }}">
                <i class="fa-solid fa-house"></i>Dashboard
            </a>

            <a href="{{ route('admin.ekstrakurikuler') }}">
                <i class="fa-solid fa-futbol"></i>Ekstrakurikuler
            </a>

            <a href="{{ route('admin.data.guru') }}">
                <i class="fa-solid fa-chalkboard-user"></i>Data Guru
            </a>

            <a href="{{ route('admin.data.siswa') }}">
                <i class="fa-solid fa-users"></i>Data Siswa
            </a>

            <a href="{{ route('admin.penerimaan-siswa.index') }}" class="active">
                <i class="fa-solid fa-user-check"></i>Penerimaan Siswa
            </a>

            <a href="{{ route('admin.penilaian') }}">
                <i class="fa-solid fa-star"></i>Penilaian
            </a>

            <a href="{{ route('admin.laporan') }}">
                <i class="fa-solid fa-file-lines"></i>Laporan
            </a>

            <a href="{{ route('admin.profil') }}">
                <i class="fa-solid fa-user"></i>Profil
            </a>

            <a href="{{ route('logout.confirm') }}" data-logout>
                <i class="fa-solid fa-right-from-bracket"></i>Logout
            </a>

@include('partials.logout-form')

        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="header">

            <div>
                <h1>Penerimaan Siswa</h1>
                <p>Terima atau tolak pendaftaran akun siswa baru.</p>
            </div>

            <a href="{{ route('dashboard.admin') }}" class="back">
                Kembali ke Dashboard
            </a>

        </div>

        @if (session('success'))
            <div class="message success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="summary">

            <a href="{{ route('admin.penerimaan-siswa.index', ['status' => 'menunggu']) }}"
               class="summary-card">

                <h2>Menunggu Persetujuan</h2>

                <div class="summary-total">
                    <div class="summary-icon icon-menunggu">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <strong>{{ $jumlah['menunggu'] }}</strong>
                </div>

            </a>

            <a href="{{ route('admin.penerimaan-siswa.index', ['status' => 'diterima']) }}"
               class="summary-card">

                <h2>Diterima</h2>

                <div class="summary-total">
                    <div class="summary-icon icon-diterima">
                        <i class="fa-solid fa-user-check"></i>
                    </div>

                    <strong>{{ $jumlah['diterima'] }}</strong>
                </div>

            </a>

            <a href="{{ route('admin.penerimaan-siswa.index', ['status' => 'ditolak']) }}"
               class="summary-card">

                <h2>Ditolak</h2>

                <div class="summary-total">
                    <div class="summary-icon icon-ditolak">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>

                    <strong>{{ $jumlah['ditolak'] }}</strong>
                </div>

            </a>

        </div>

        <div class="card">

            <div class="card-header">

                <h2>Daftar Pendaftaran Siswa</h2>

                <div class="filters">

                    <a href="{{ route('admin.penerimaan-siswa.index', ['status' => 'semua']) }}"
                       class="{{ $status === 'semua' ? 'active' : '' }}">
                        Semua
                    </a>

                    <a href="{{ route('admin.penerimaan-siswa.index', ['status' => 'menunggu']) }}"
                       class="{{ $status === 'menunggu' ? 'active' : '' }}">
                        Menunggu
                    </a>

                    <a href="{{ route('admin.penerimaan-siswa.index', ['status' => 'diterima']) }}"
                       class="{{ $status === 'diterima' ? 'active' : '' }}">
                        Diterima
                    </a>

                    <a href="{{ route('admin.penerimaan-siswa.index', ['status' => 'ditolak']) }}"
                       class="{{ $status === 'ditolak' ? 'active' : '' }}">
                        Ditolak
                    </a>

                </div>

            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nama Sekolah</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($siswa as $index => $item)

                        @php
                            $statusSiswa = $item->status_pendaftaran ?: 'diterima';
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->nama_sekolah ?: '-' }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email ?: '-' }}</td>
                            <td>{{ $item->kelas_saat_ini ?: '-' }}</td>
                            <td>{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <span class="status status-{{ $statusSiswa }}">
                                    {{ ucfirst($statusSiswa) }}
                                </span>
                            </td>
                            <td>
                                <div class="aksi">

                                    @if($statusSiswa !== 'diterima')
                                        <form
                                            action="{{ route('admin.penerimaan-siswa.terima', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Terima pendaftaran siswa {{ $item->name }}?')"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn-small btn-terima">
                                                <i class="fa-solid fa-check"></i> Terima
                                            </button>
                                        </form>
                                    @endif

                                    @if($statusSiswa !== 'ditolak')
                                        <form
                                            action="{{ route('admin.penerimaan-siswa.tolak', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Tolak pendaftaran siswa {{ $item->name }}?')"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn-small btn-tolak">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="empty">
                                Tidak ada pendaftaran siswa dengan status ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
