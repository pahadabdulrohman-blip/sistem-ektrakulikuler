
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Guru - Sistem Ekstrakurikuler</title>

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
            background: #f3f6fa;
            color: #17202a;
        }

        /* SIDEBAR */
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
            overflow-y: auto;
        }

        .guru-logo {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255,255,255,.2);
        }

        .guru-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 10px;
            border-radius: 18px;
            background: rgba(255,255,255,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
        }

        .guru-logo h2 {
            font-size: 24px;
            font-weight: 700;
        }

        .guru-logo p {
            font-size: 13px;
            opacity: .8;
            margin-top: 5px;
        }

        .menu-title {
            font-size: 12px;
            text-transform: uppercase;
            margin: 30px 15px 12px;
            opacity: .7;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            text-decoration: none;
            padding: 15px 16px;
            border-radius: 11px;
            font-size: 14px;
            transition: .2s;
            cursor: pointer;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.2);
        }

        .menu-icon {
            width: 24px;
            text-align: center;
            font-size: 19px;
        }

        /* KONTEN UTAMA */
        .main {
            margin-left: 270px;
            width: calc(100% - 270px);
            min-height: 100vh;
            padding: 35px 40px;
        }

        .header {
            background: white;
            border-radius: 18px;
            padding: 28px 30px;
            margin-bottom: 28px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .header h1 {
            color: #116b43;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            color: #718096;
            font-size: 13px;
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

        /* STATISTIK */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border-radius: 17px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            flex-shrink: 0;
            border-radius: 15px;
            background: #d9f7e7;
            color: #148f5a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-number {
            font-size: 23px;
            font-weight: 700;
            color: #116b43;
        }

        .stat-label {
            color: #718096;
            font-size: 11px;
            margin-top: 3px;
        }

        /* KARTU KONTEN */
        .content-card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .content-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            gap: 15px;
        }

        .content-header h2 {
            color: #151b26;
            font-size: 21px;
        }

        .content-header p {
            color: #718096;
            font-size: 12px;
            margin-top: 4px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 18px;
            background: #148f5a;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 9px;
            font-size: 12px;
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
            padding: 14px;
            font-size: 12px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e8edf1;
            font-size: 13px;
        }

        tbody tr:hover {
            background: #f7fbf9;
        }

        .status {
            display: inline-block;
            padding: 6px 13px;
            border-radius: 20px;
            background: #d9f7e7;
            color: #148f5a;
            font-size: 11px;
            font-weight: 600;
        }

        /* MENU CEPAT */
        .quick-menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .quick-card {
            padding: 22px;
            border: 1px solid #e1e8ed;
            border-radius: 14px;
            text-decoration: none;
            color: #17202a;
            transition: .2s;
            background: white;
        }

        .quick-card:hover {
            border-color: #148f5a;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,.06);
        }

        .quick-icon {
            font-size: 28px;
            margin-bottom: 12px;
        }

        .quick-card h3 {
            font-size: 14px;
            color: #116b43;
            margin-bottom: 5px;
        }

        .quick-card p {
            color: #718096;
            font-size: 11px;
        }

        @media(max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 20px 16px;
            }

            .guru-logo {
                text-align: center;
                padding-bottom: 15px;
            }

            .guru-logo h2 {
                font-size: 18px;
            }

            .guru-logo p {
                font-size: 11px;
            }

            .guru-icon {
                width: 44px;
                height: 44px;
                font-size: 22px;
            }

            .menu-title {
                margin: 18px 0 10px;
            }

            .menu a {
                padding: 12px 14px;
            }

            .main {
                margin-left: 0;
                width: 100%;
                padding: 20px 15px;
            }

            .header {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .header h1 {
                font-size: 21px;
            }

            .guru-profile {
                align-self: flex-end;
            }

            .guru-info {
                display: none;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .quick-menu {
                grid-template-columns: 1fr;
            }

            .content-card {
                padding: 18px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

@php
    $usernameGuru = session('username', 'guru');

    $guru = \App\Models\User::where('username', $usernameGuru)
        ->where('role', 'guru')
        ->first();

    $namaGuru = $guru->name ?? 'Guru Pembimbing';

    $fotoGuru = \App\Models\ProfilePhoto::where('username', $usernameGuru)
        ->where('role', 'guru')
        ->first();

    // Statistik diambil langsung dari database agar selalu mengikuti data terbaru.
    $totalSiswa = \App\Models\User::where('role', 'siswa')->count();

    $daftarEkskul = \App\Models\Ekstrakurikuler::withCount('pendaftaran')
        ->orderBy('nama_ekstrakurikuler')
        ->get();

    $totalEkskul = $daftarEkskul->count();

    $rataNilai = round((float) \App\Models\Penilaian::avg('nilai'), 1);
    $rataNilaiTampil = rtrim(
        rtrim(number_format($rataNilai, 1, ',', '.'), '0'),
        ','
    );

    $totalAbsensi = \App\Models\AbsensiSiswa::count();
    $totalHadir = \App\Models\AbsensiSiswa::where('status', 'hadir')->count();

    $persenHadir = $totalAbsensi > 0
        ? (int) round($totalHadir / $totalAbsensi * 100)
        : 0;
@endphp

    <!-- SIDEBAR GURU -->
    <aside class="sidebar">

        <div class="guru-logo">
            <div class="guru-icon">G</div>
            <h2>GURU</h2>
            <p>Sistem Ekstrakurikuler</p>
        </div>

        <div class="menu-title">Menu Guru</div>

        <nav class="menu">

            <a href="{{ route('dashboard.guru') }}"
               class="{{ request()->routeIs('dashboard.guru') ? 'active' : '' }}">
                <span class="menu-icon"><i class="fa-solid fa-house"></i></span>
                <span class="menu-text">Dashboard Guru</span>
            </a>

            <a href="{{ route('guru.kegiatan') }}"
               class="{{ request()->routeIs('guru.kegiatan') ? 'active' : '' }}">
                <span class="menu-icon"><i class="fa-solid fa-users"></i></span>
                <span class="menu-text">Data Kegiatan</span>
            </a>

            <a href="{{ route('guru.jadwal.index') }}"
               class="{{ request()->routeIs('guru.jadwal*') ? 'active' : '' }}">
                <span class="menu-icon"><i class="fa-solid fa-calendar-days"></i></span>
                <span class="menu-text">Jadwal Kegiatan</span>
            </a>

            <a href="{{ route('guru.penilaian') }}"
               class="{{ request()->routeIs('guru.penilaian*') ? 'active' : '' }}">
                <span class="menu-icon"><i class="fa-solid fa-star"></i></span>
                <span class="menu-text">Penilaian Siswa</span>
            </a>

            <a href="{{ route('guru.absensi') }}"
               class="{{ request()->routeIs('guru.absensi*') ? 'active' : '' }}">
                <span class="menu-icon"><i class="fa-solid fa-calendar-check"></i></span>
                <span class="menu-text">Absensi Siswa</span>
            </a>

            <a href="{{ route('guru.laporan') }}"
               class="{{ request()->routeIs('guru.laporan') ? 'active' : '' }}">
                <span class="menu-icon"><i class="fa-solid fa-file-lines"></i></span>
                <span class="menu-text">Laporan</span>
            </a>

            <a href="{{ route('guru.profil') }}"
               class="{{ request()->routeIs('guru.profil') ? 'active' : '' }}">
                <span class="menu-icon"><i class="fa-solid fa-user"></i></span>
                <span class="menu-text">Profil Guru</span>
            </a>

            <a href="{{ route('login') }}">
                <span class="menu-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                <span class="menu-text">Logout</span>
            </a>

        </nav>
    </aside>

    <!-- KONTEN DASHBOARD -->
    <main class="main">

        <header class="header">
            <div>
                <h1>Dashboard Guru</h1>
                <p>Selamat datang, {{ $namaGuru }}. Berikut data terbaru sistem ekstrakurikuler.</p>
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

        <!-- STATISTIK -->
        <section class="stats">

            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <div>
                    <div class="stat-number">{{ $totalSiswa }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="stat-number">{{ $totalEkskul }}</div>
                    <div class="stat-label">Ekstrakurikuler</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
                <div>
                    <div class="stat-number">{{ $rataNilaiTampil }}</div>
                    <div class="stat-label">Rata-rata Nilai</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div>
                    <div class="stat-number">{{ $persenHadir }}%</div>
                    <div class="stat-label">Kehadiran</div>
                </div>
            </div>

        </section>

        <!-- DATA KEGIATAN -->
        <section class="content-card">

            <div class="content-header">
                <div>
                    <h2>Data Kegiatan Ekstrakurikuler</h2>
                    <p>Daftar kegiatan yang dikelola oleh guru.</p>
                </div>

                <a href="{{ route('guru.kegiatan') }}" class="btn">
                    Lihat Kegiatan →
                </a>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ekstrakurikuler</th>
                            <th>Pembimbing</th>
                            <th>Jumlah Siswa</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($daftarEkskul as $ekskul)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ekskul->nama_ekstrakurikuler }}</td>
                                <td>{{ $ekskul->pembina ?: 'Belum ditentukan' }}</td>
                                <td>{{ $ekskul->pendaftaran_count }}</td>
                                <td>{{ $ekskul->jadwal ?: 'Belum ditentukan' }}</td>
                                <td><span class="status">Aktif</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;color:#718096;padding:35px;">
                                    Belum ada data ekstrakurikuler.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </section>

    </main>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>

</html>