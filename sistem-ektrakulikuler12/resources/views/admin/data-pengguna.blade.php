<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $judul }} - Admin</title>

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

        .summary {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 2fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            padding: 22px 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
        }

        .summary-card h2 {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .summary-total {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .summary-icon {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            background: #e0ecff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .summary-total strong {
            font-size: 30px;
            line-height: 1;
            color: #111827;
        }

        .summary-total span {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-top: 5px;
        }

        .kelas-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .kelas-item {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 13px;
            color: #374151;
        }

        .kelas-item strong {
            display: block;
            font-size: 18px;
            color: #111827;
            margin-top: 2px;
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

        .btn-manage {
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .btn-manage:hover {
            background: #1d4ed8;
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

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
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
        }

        tr:hover td {
            background: #f9fafb;
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

            <a href="{{ route('admin.data.guru') }}" class="{{ $roleAktif === 'guru' ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i>Data Guru
            </a>

            <a href="{{ route('admin.data.siswa') }}" class="{{ $roleAktif === 'siswa' ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>Data Siswa
            </a>

            <a href="{{ route('admin.penerimaan-siswa.index') }}">
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
                <h1>{{ $judul }}</h1>
                <p>{{ $deskripsi }}</p>
            </div>

            <a href="{{ route('dashboard.admin') }}" class="back">
                Kembali ke Dashboard
            </a>

        </div>

        <div class="summary">

            <div class="summary-card">

                <h2>Jumlah {{ $roleAktif === 'guru' ? 'Guru' : 'Siswa' }}</h2>

                <div class="summary-total">

                    <div class="summary-icon">
                        <i class="fa-solid {{ $roleAktif === 'guru' ? 'fa-chalkboard-user' : 'fa-users' }}"></i>
                    </div>

                    <div>
                        <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                        <span>Total {{ $roleAktif === 'guru' ? 'guru' : 'siswa' }} terdaftar</span>
                    </div>

                </div>

            </div>

            @if($roleAktif === 'siswa')

                <div class="summary-card">

                    <h2>Sebaran Siswa per Kelas</h2>

                    @if($jumlahPerKelas->isEmpty())

                        <p style="color:#6b7280;font-size:13px;">
                            Belum ada data kelas.
                        </p>

                    @else

                        <div class="kelas-list">

                            @foreach($jumlahPerKelas as $kelas => $jumlah)

                                <div class="kelas-item">
                                    Kelas {{ $kelas }}
                                    <strong>{{ $jumlah }}</strong>
                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            @endif

        </div>

        <div class="card">

            <div class="card-header">

                <h2>Daftar {{ $judul }}</h2>

                @if($roleAktif === 'guru')
                    <a href="{{ route('admin.guru.index') }}" class="btn-manage">
                        <i class="fa-solid fa-user-gear"></i> Kelola Akun Guru
                    </a>
                @else
                    <a href="{{ route('admin.penerimaan-siswa.index') }}" class="btn-manage">
                        <i class="fa-solid fa-user-check"></i> Kelola Penerimaan
                    </a>
                @endif

            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        @if($roleAktif === 'siswa')
                            <th>Nama Sekolah</th>
                        @endif
                        <th>Username</th>
                        <th>Email</th>
                        @if($roleAktif === 'siswa')
                            <th>Kelas</th>
                            <th>Tahun Masuk</th>
                            <th>Status</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengguna as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            @if($roleAktif === 'siswa')
                                <td>{{ $item->nama_sekolah ?: '-' }}</td>
                            @endif
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email ?: '-' }}</td>
                            @if($roleAktif === 'siswa')
                                @php
                                    $statusSiswa = $item->status_pendaftaran ?: 'diterima';
                                @endphp

                                <td>{{ $item->kelas_saat_ini ?: '-' }}</td>
                                <td>{{ $item->tahun_masuk ?: '-' }}</td>
                                <td>
                                    <span class="status status-{{ $statusSiswa }}">
                                        {{ ucfirst($statusSiswa) }}
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $roleAktif === 'siswa' ? 8 : 4 }}" class="empty">
                                Belum ada data {{ $roleAktif }}.
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
