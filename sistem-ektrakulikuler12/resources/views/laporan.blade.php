<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Guru</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f6fa;
            color: #17202a;
        }

        /* SIDEBAR - SAMA DENGAN DASHBOARD GURU */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 270px;
            background: linear-gradient(180deg, #148f5a, #087847);
            color: white;
            padding: 30px 20px;
            z-index: 1000;
        }

        .guru-logo {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255,255,255,.2);
        }

        .logo-icon {
            width: 78px;
            height: 78px;
            background: rgba(255,255,255,.15);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: 800;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0 auto 15px;
        }

        .guru-logo h2 {
            font-size: 24px;
            font-weight: 700;
        }

        .guru-logo p {
            font-size: 12px;
            opacity: .8;
            margin-top: 3px;
        }

        .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            margin: 30px 15px 12px;
            opacity: .7;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            text-decoration: none;
            padding: 14px 16px;
            margin-bottom: 7px;
            border-radius: 11px;
            font-size: 14px;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.18);
        }

        .menu-icon {
            width: 24px;
            text-align: center;
            font-size: 18px;
        }

        /* KONTEN UTAMA */
        .main {
            margin-left: 270px;
            width: calc(100% - 270px);
            min-height: 100vh;
            padding: 35px 40px;
        }

        /* HEADER */
        .header {
            background: white;
            border-radius: 18px;
            padding: 28px 30px;
            margin-bottom: 28px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .header h1 {
            color: #116b43;
            font-size: 30px;
            margin-bottom: 5px;
        }

        .header p {
            color: #718096;
            font-size: 14px;
        }

        .guru-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .guru-info {
            text-align: right;
        }

        .guru-info strong {
            display: block;
            color: #116b43;
            font-size: 14px;
        }

        .guru-info span {
            color: #718096;
            font-size: 11px;
        }

        .profile-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #d9f7e7;
            color: #148f5a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            overflow: hidden;
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* RINGKASAN */
        .summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .summary-card {
            background: white;
            border-radius: 17px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 17px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: #d9f7e7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            flex-shrink: 0;
        }

        .summary-card h2 {
            color: #116b43;
            font-size: 25px;
        }

        .summary-card p {
            color: #718096;
            font-size: 12px;
        }

        /* TABEL LAPORAN */
        .content-card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .content-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .content-heading h2 {
            font-size: 22px;
            color: #17202a;
        }

        .content-heading p {
            color: #718096;
            font-size: 13px;
            margin-top: 4px;
        }

        .btn {
            border: none;
            border-radius: 9px;
            padding: 11px 18px;
            background: #148f5a;
            color: white;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover {
            background: #087847;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        thead {
            background: #148f5a;
            color: white;
        }

        th {
            text-align: left;
            padding: 15px;
            font-size: 13px;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #e8edf1;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f7fbf9;
        }

        .empty {
            text-align: center;
            color: #718096;
            padding: 35px;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            background: #e8edf1;
            color: #4a5568;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge.sangat-baik {
            background: #d9f7e7;
            color: #116b43;
        }

        .badge.baik {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge.cukup {
            background: #fef3c7;
            color: #92400e;
        }

        .badge.perlu-bimbingan {
            background: #fee2e2;
            color: #991b1b;
        }

        .nilai {
            font-weight: 700;
            color: #116b43;
        }

        .report-note {
            margin-top: 20px;
            color: #718096;
            font-size: 12px;
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .summary {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .header,
            .content-heading {
                flex-direction: column;
                align-items: flex-start;
            }

            .guru-profile {
                align-self: flex-end;
            }
        }

        /* CETAK LAPORAN */
        @media print {
            .sidebar,
            .btn {
                display: none !important;
            }

            .main {
                margin: 0;
                width: 100%;
                padding: 10px;
            }

            body {
                background: white;
            }

            .header,
            .summary-card,
            .content-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

@php
    // Normalisasi $siswa agar count() dan perulangan selalu aman:
    // terima array, Collection, satu objek User, atau null.
    $siswaList = match (true) {
        ($siswa ?? null) instanceof \App\Models\User => [$siswa],
        ($siswa ?? null) instanceof \Illuminate\Support\Collection => $siswa->all(),
        is_array($siswa ?? null) => $siswa,
        default => [],
    };

    // Statistik dikirim controller (query count() dari database).
    $totalSiswa = $totalSiswa ?? count($siswaList);
    $totalKegiatan = $totalKegiatan ?? 0;
    $totalPenilaian = $totalPenilaian ?? 0;
    $totalPendaftar = $totalPendaftar ?? 0;
    $rekapEkskul = $rekapEkskul ?? collect();

    // Profil guru yang sedang login.
    $usernameGuru = session('username', 'guru');

    $guru = \App\Models\User::where('username', $usernameGuru)
        ->where('role', 'guru')
        ->first();

    $namaGuru = $guru->name ?? 'Guru Pembimbing';

    $fotoGuru = \App\Models\ProfilePhoto::where('username', $usernameGuru)
        ->where('role', 'guru')
        ->first();
@endphp

<!-- SIDEBAR GURU -->
<aside class="sidebar">

    <div class="guru-logo">
        <div class="logo-icon">G</div>
        <h2>GURU</h2>
        <p>Sistem Ekstrakurikuler</p>
    </div>

    <div class="menu-title">Menu Guru</div>

    <nav class="menu">

        <a href="{{ route('dashboard.guru') }}">
            <span class="menu-icon"><i class="fa-solid fa-house"></i></span>
            Dashboard Guru
        </a>

        <a href="{{ route('guru.kegiatan') }}">
            <span class="menu-icon"><i class="fa-solid fa-users"></i></span>
            Data Kegiatan
        </a>

        <a href="{{ route('guru.jadwal.index') }}">
            <span class="menu-icon"><i class="fa-solid fa-calendar-days"></i></span>
            Jadwal Kegiatan
        </a>

        <a href="{{ route('guru.penilaian') }}">
            <span class="menu-icon"><i class="fa-solid fa-star"></i></span>
            Penilaian Siswa
        </a>

        <a href="{{ route('guru.laporan') }}" class="active">
            <span class="menu-icon"><i class="fa-solid fa-file-lines"></i></span>
            Laporan
        </a>

        <a href="{{ route('guru.profil') }}">
            <span class="menu-icon"><i class="fa-solid fa-user"></i></span>
            Profil Guru
        </a>

        <a href="{{ route('logout.confirm') }}" data-logout>
            <span class="menu-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
            Logout
        </a>

@include('partials.logout-form')

    </nav>
</aside>

<!-- KONTEN UTAMA -->
<main class="main">

    <header class="header">
        <div>
            <h1>Laporan Guru</h1>
            <p>Rekap data siswa dan kegiatan ekstrakurikuler.</p>
        </div>

        <div class="guru-profile">
            <div class="guru-info">
                <strong>{{ $namaGuru }}</strong>
                <span>Guru Pembimbing</span>
            </div>

            <div class="profile-icon">
                @if ($fotoGuru && $fotoGuru->photo_path)
                    <img
                        src="{{ asset('storage/' . $fotoGuru->photo_path) }}"
                        alt="Foto Profil {{ $namaGuru }}"
                    >
                @else
                    <i class="fa-solid fa-chalkboard-user"></i>
                @endif
            </div>

        </div>
    </header>

    <!-- RINGKASAN -->
    <section class="summary">

        <div class="summary-card">
            <div class="summary-icon"><i class="fa-solid fa-user-graduate"></i></div>
            <div>
                <h2>{{ $totalSiswa }}</h2>
                <p>Data Siswa</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="fa-solid fa-users"></i></div>
            <div>
                <h2>{{ $totalKegiatan }}</h2>
                <p>Data Kegiatan</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="fa-solid fa-chart-line"></i></div>
            <div>
                <h2>{{ $totalPenilaian }}</h2>
                <p>Data Penilaian</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="fa-solid fa-clipboard-list"></i></div>
            <div>
                <h2>{{ $totalPendaftar }}</h2>
                <p>Total Pendaftaran</p>
            </div>
        </div>

    </section>

    <!-- TABEL LAPORAN -->
    <section class="content-card">

        <div class="content-heading">
            <div>
                <h2>Rekap Data Siswa</h2>
                <p>Daftar siswa dalam laporan ekstrakurikuler.</p>
            </div>

            <button class="btn" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </button>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Ekstrakurikuler</th>
                        <th>Nilai</th>
                        <th>Predikat</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswaList as $index => $item)
                        @php
                            $predikat = data_get($item, 'predikat', '-');
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ data_get($item, 'nama', data_get($item, 'name', '-')) }}
                            </td>
                            <td>
                                {{ data_get($item, 'kelas', '-') }}
                            </td>
                            <td>
                                {{ data_get($item, 'ekstrakurikuler', '-') }}
                            </td>
                            <td class="nilai">
                                {{ data_get($item, 'nilai', '-') }}
                            </td>
                            <td>
                                <span class="badge {{ \Illuminate\Support\Str::slug($predikat) }}">
                                    {{ $predikat }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada data siswa untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <p class="report-note">
            Laporan ini menampilkan data siswa, ekstrakurikuler, dan nilai
            terbaru dari database. Gunakan tombol Cetak Laporan untuk
            mencetak halaman.
        </p>

    </section>

    <!-- REKAP AGREGAT EKSTRAKURIKULER -->
    <section class="content-card" style="margin-top: 25px;">

        <div class="content-heading">
            <div>
                <h2>Rekap Agregat Ekstrakurikuler</h2>
                <p>
                    Dihitung langsung di database memakai COUNT, SUM, AVG,
                    dan GROUP BY.
                </p>
            </div>
        </div>

        <div class="table-wrapper">
            @include('partials.rekap-ekstrakurikuler', [
                'rekapEkskul' => $rekapEkskul,
                'totalPendaftar' => $totalPendaftar,
            ])
        </div>

    </section>

</main>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>