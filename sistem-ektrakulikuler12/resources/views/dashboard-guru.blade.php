
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Guru - Sistem Ekstrakurikuler</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js untuk visualisasi statistik dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

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

        /* VISUALISASI STATISTIK */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .chart-card {
            background: white;
            padding: 24px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
        }

        .chart-card h2 {
            font-size: 15px;
            color: #17202a;
        }

        .chart-sub {
            color: #718096;
            font-size: 11px;
            margin: 4px 0 18px;
        }

        .chart-box {
            position: relative;
            height: 280px;
        }

        .chart-wide {
            grid-column: 1 / -1;
        }

        .chart-empty {
            height: 280px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #94a3b8;
            font-size: 12px;
            border: 1px dashed #dbe3ea;
            border-radius: 12px;
        }

        .chart-empty i {
            font-size: 24px;
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

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .chart-wide {
                grid-column: auto;
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

    // Data visualisasi: pendaftar per ekstrakurikuler.
    $labelPendaftarEkskul = $daftarEkskul
        ->pluck('nama_ekstrakurikuler')
        ->all();

    $dataPendaftarEkskul = $daftarEkskul
        ->pluck('pendaftaran_count')
        ->all();

    // Data visualisasi: rekap status absensi.
    $statusAbsensi = \App\Models\AbsensiSiswa::selectRaw(
        'status, COUNT(*) as jumlah'
    )
        ->groupBy('status')
        ->pluck('jumlah', 'status');

    $dataStatusAbsensi = [
        (int) ($statusAbsensi['hadir'] ?? 0),
        (int) ($statusAbsensi['izin'] ?? 0),
        (int) ($statusAbsensi['sakit'] ?? 0),
        (int) ($statusAbsensi['alpa'] ?? 0),
    ];

    // Data visualisasi: rata-rata nilai per ekstrakurikuler.
    $nilaiPerEkskul = \App\Models\Penilaian::selectRaw(
        'TRIM(nama_kegiatan) as nama_kegiatan, '
        . 'AVG(nilai) as rata_nilai'
    )
        ->whereNotNull('nama_kegiatan')
        ->where('nama_kegiatan', '!=', '')
        ->groupByRaw('TRIM(nama_kegiatan)')
        ->orderByRaw('TRIM(nama_kegiatan)')
        ->get();

    $labelNilaiEkskul = $nilaiPerEkskul
        ->pluck('nama_kegiatan')
        ->all();

    $dataNilaiEkskul = $nilaiPerEkskul
        ->map(fn ($item) => round((float) $item->rata_nilai, 1))
        ->all();

    // Data visualisasi: sebaran siswa per kelas.
    $sebaranKelas = \App\Models\User::where('role', 'siswa')
        ->pluck('kelas')
        ->map(function ($kelas) {
            $kelas = trim((string) $kelas);

            return $kelas !== '' ? $kelas : 'Belum diisi';
        })
        ->countBy()
        ->sortKeys();

    $labelKelas = $sebaranKelas->keys()->all();
    $dataKelas = $sebaranKelas->values()->all();
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

        <!-- VISUALISASI STATISTIK -->
        <section class="charts-grid">

            <div class="chart-card">
                <h2>Pendaftar per Ekstrakurikuler</h2>
                <p class="chart-sub">
                    Jumlah siswa yang terdaftar pada setiap kegiatan.
                </p>

                <div class="chart-box">
                    <canvas id="chartPendaftarGuru"></canvas>
                </div>

                <div class="chart-empty" id="emptyPendaftarGuru" style="display:none;">
                    <i class="fa-regular fa-chart-bar"></i>
                    Belum ada data pendaftaran.
                </div>
            </div>

            <div class="chart-card">
                <h2>Status Kehadiran</h2>
                <p class="chart-sub">
                    Rekap absensi seluruh kegiatan ekstrakurikuler.
                </p>

                <div class="chart-box">
                    <canvas id="chartKehadiranGuru"></canvas>
                </div>

                <div class="chart-empty" id="emptyKehadiranGuru" style="display:none;">
                    <i class="fa-regular fa-calendar"></i>
                    Belum ada data absensi.
                </div>
            </div>

            <div class="chart-card">
                <h2>Sebaran Siswa per Kelas</h2>
                <p class="chart-sub">
                    Jumlah siswa terdaftar pada setiap kelas.
                </p>

                <div class="chart-box">
                    <canvas id="chartKelasGuru"></canvas>
                </div>

                <div class="chart-empty" id="emptyKelasGuru" style="display:none;">
                    <i class="fa-regular fa-user"></i>
                    Belum ada data siswa.
                </div>
            </div>

            <div class="chart-card">
                <h2>Rata-rata Nilai per Ekstrakurikuler</h2>
                <p class="chart-sub">
                    Nilai rata-rata dari seluruh penilaian siswa.
                </p>

                <div class="chart-box">
                    <canvas id="chartNilaiGuru"></canvas>
                </div>

                <div class="chart-empty" id="emptyNilaiGuru" style="display:none;">
                    <i class="fa-regular fa-star"></i>
                    Belum ada data penilaian.
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                ['emptyPendaftarGuru', 'emptyKehadiranGuru', 'emptyKelasGuru', 'emptyNilaiGuru']
                    .forEach(function (id) {
                        var pesan = document.getElementById(id);

                        if (pesan) {
                            pesan.style.display = 'flex';
                        }
                    });

                return;
            }

            var labelPendaftar = @json($labelPendaftarEkskul);
            var dataPendaftar = @json($dataPendaftarEkskul);
            var dataKehadiran = @json($dataStatusAbsensi);
            var labelNilai = @json($labelNilaiEkskul);
            var dataNilai = @json($dataNilaiEkskul);
            var labelKelas = @json($labelKelas);
            var dataKelas = @json($dataKelas);

            var totalKehadiran = dataKehadiran.reduce(
                function (total, nilai) { return total + nilai; },
                0
            );

            function tampilkanKosong(canvasId, pesanId) {
                var canvas = document.getElementById(canvasId);
                var pesan = document.getElementById(pesanId);

                if (canvas) {
                    canvas.style.display = 'none';
                }

                if (pesan) {
                    pesan.style.display = 'flex';
                }
            }

            // 1. Pendaftar per ekstrakurikuler.
            if (labelPendaftar.length === 0) {
                tampilkanKosong('chartPendaftarGuru', 'emptyPendaftarGuru');
            } else {
                new Chart(document.getElementById('chartPendaftarGuru'), {
                    type: 'bar',
                    data: {
                        labels: labelPendaftar,
                        datasets: [{
                            label: 'Jumlah Pendaftar',
                            data: dataPendaftar,
                            backgroundColor: '#148f5a',
                            hoverBackgroundColor: '#0f6b43',
                            borderRadius: 8,
                            maxBarThickness: 46
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 },
                                grid: { color: '#eef2f5' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // 2. Status kehadiran.
            if (totalKehadiran === 0) {
                tampilkanKosong('chartKehadiranGuru', 'emptyKehadiranGuru');
            } else {
                new Chart(document.getElementById('chartKehadiranGuru'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
                        datasets: [{
                            data: dataKehadiran,
                            backgroundColor: [
                                '#148f5a',
                                '#3b82f6',
                                '#f59e0b',
                                '#ef4444'
                            ],
                            borderWidth: 3,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '58%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    padding: 16
                                }
                            }
                        }
                    }
                });
            }

            // 3. Sebaran siswa per kelas.
            if (labelKelas.length === 0) {
                tampilkanKosong('chartKelasGuru', 'emptyKelasGuru');
            } else {
                new Chart(document.getElementById('chartKelasGuru'), {
                    type: 'doughnut',
                    data: {
                        labels: labelKelas,
                        datasets: [{
                            data: dataKelas,
                            backgroundColor: [
                                '#148f5a',
                                '#3b82f6',
                                '#f59e0b',
                                '#ef4444',
                                '#8b5cf6',
                                '#0f766e',
                                '#64748b'
                            ],
                            borderWidth: 3,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '58%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    padding: 16
                                }
                            }
                        }
                    }
                });
            }

            // 4. Rata-rata nilai per ekstrakurikuler.
            if (labelNilai.length === 0) {
                tampilkanKosong('chartNilaiGuru', 'emptyNilaiGuru');
            } else {
                new Chart(document.getElementById('chartNilaiGuru'), {
                    type: 'bar',
                    data: {
                        labels: labelNilai,
                        datasets: [{
                            label: 'Rata-rata Nilai',
                            data: dataNilai,
                            backgroundColor: '#3b82f6',
                            hoverBackgroundColor: '#148f5a',
                            borderRadius: 8,
                            maxBarThickness: 46
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                grid: { color: '#eef2f5' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });
    </script>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>

</html>