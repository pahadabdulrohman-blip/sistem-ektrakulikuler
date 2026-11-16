<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Chart.js untuk visualisasi statistik dashboard -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f4f7fb;
}


/* SIDEBAR */

.sidebar{
    position:fixed;
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,#212529,#000);
    color:white;
    padding:25px 18px;
    overflow-y:auto;
}

.logo{
    text-align:center;
    margin-bottom:35px;
}

.logo i{
    font-size:38px;
}

.logo h2{
    margin-top:8px;
}

.menu a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    margin-bottom:8px;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

.menu a:hover,
.menu .active{
    background:rgba(255,255,255,.15);
}


/* NOTIFIKASI */

.notification-link{
    position:relative;
}

.notification-badge{
    margin-left:auto;
    min-width:22px;
    height:22px;
    padding:0 6px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#dc3545;
    color:white;

    border-radius:20px;

    font-size:11px;
    font-weight:700;
}


/* CONTENT */

.content{
    margin-left:250px;
    padding:35px;
}

.header{
    background:white;
    padding:25px;
    border-radius:15px;
    margin-bottom:25px;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header h1{
    color:#212529;
}

.header p{
    color:#777;
    margin-top:5px;
}

.notification-top{
    text-decoration:none;
    color:#212529;

    width:48px;
    height:48px;

    border-radius:12px;

    background:#f1f3f5;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:20px;

    position:relative;
}

.notification-top:hover{
    background:#e9ecef;
}

.notification-top .notification-badge{
    position:absolute;
    top:-5px;
    right:-5px;
}


/* CARDS */

.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,.05);
}

.stat{
    display:flex;
    align-items:center;
    gap:15px;
}

.icon{
    width:55px;
    height:55px;
    background:#e9ecef;
    color:#212529;
    border-radius:12px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:22px;
}

.stat h2{
    color:#212529;
}

.stat p{
    color:#777;
    font-size:13px;
}


/* GRID */

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:15px 0;

    border-bottom:1px solid #eee;
}


/* VISUALISASI STATISTIK */

.charts-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:25px;
}

.chart-card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,.05);
}

.chart-card h2{
    font-size:16px;
    color:#212529;
}

.chart-sub{
    color:#777;
    font-size:12px;
    margin:4px 0 18px;
}

.chart-box{
    position:relative;
    height:290px;
}

.chart-wide{
    grid-column:1 / -1;
}

.chart-empty{
    height:290px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;

    color:#999;
    font-size:13px;

    border:1px dashed #dde2e8;
    border-radius:12px;
}

.chart-empty i{
    font-size:26px;
}

.badge{
    padding:5px 10px;
    background:#e9ecef;
    border-radius:20px;
    font-size:12px;
}


/* NOTIFICATION CARD */

.notification-card{
    margin-top:25px;
}

.notification-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.notification-header h2{
    font-size:20px;
}

.view-all{
    color:#08718b;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}

.request{
    display:flex;
    align-items:center;
    gap:15px;

    padding:15px 0;

    border-bottom:1px solid #eee;
}

.request-icon{
    width:45px;
    height:45px;

    border-radius:12px;

    background:#fff3cd;
    color:#856404;

    display:flex;
    align-items:center;
    justify-content:center;
}

.request-info{
    flex:1;
}

.request-info strong{
    display:block;
    color:#212529;
}

.request-info span{
    font-size:12px;
    color:#777;
}

.status{
    padding:5px 10px;
    border-radius:20px;

    background:#fff3cd;
    color:#856404;

    font-size:11px;
}


/* RESPONSIVE */

@media(max-width:1100px){

    .cards{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:900px){

    .grid{
        grid-template-columns:1fr;
    }

    .charts-grid{
        grid-template-columns:1fr;
    }

    .chart-wide{
        grid-column:auto;
    }

}

@media(max-width:600px){

    .sidebar{
        width:70px;
    }

    .logo h2,
    .menu span{
        display:none;
    }

    .menu a{
        justify-content:center;
    }

    .notification-badge{
        position:absolute;
        top:0;
        right:0;
    }

    .content{
        margin-left:70px;
        padding:20px;
    }

    .cards{
        grid-template-columns:1fr;
    }

    .header{
        padding:20px;
    }

    .header h1{
        font-size:22px;
    }

    .header p{
        font-size:12px;
    }

}

</style>

    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>


@php

    $usernameAdmin = session('username');

    $namaAdmin = \App\Models\User::where('username', $usernameAdmin)
        ->where('role', 'admin')
        ->value('name') ?? 'Administrator';

    $jumlahPermintaan = \App\Models\PasswordRequest::where(
        'status',
        'menunggu'
    )->count();

    // Statistik diambil langsung dari database agar selalu mengikuti data terbaru.
    $totalSiswa = \App\Models\User::where('role', 'siswa')->count();

    $totalGuru = \App\Models\User::where('role', 'guru')->count();

    $totalEkskul = \App\Models\Ekstrakurikuler::count();

    $totalPenilaian = \App\Models\Penilaian::count();

    $totalPenilaianTampil = number_format($totalPenilaian, 0, ',', '.');

    // Data visualisasi: pendaftar per ekstrakurikuler.
    $pendaftarPerEkskul = \App\Models\Ekstrakurikuler::withCount('pendaftaran')
        ->orderByDesc('pendaftaran_count')
        ->orderBy('nama_ekstrakurikuler')
        ->get();

    $labelPendaftarEkskul = $pendaftarPerEkskul
        ->pluck('nama_ekstrakurikuler')
        ->all();

    $dataPendaftarEkskul = $pendaftarPerEkskul
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


<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-user-shield"></i>

        <h2>ADMIN</h2>

    </div>


    <div class="menu">


        <a href="{{ route('dashboard.admin') }}" class="active">

            <i class="fa-solid fa-house"></i>

            <span>Dashboard</span>

        </a>


        <a href="{{ route('admin.ekstrakurikuler') }}">
            <i class="fa-solid fa-people-group"></i>

            <span>Ekstrakurikuler</span>

        </a>


        <a href="{{ route('admin.guru.index') }}">
            <i class="fa-solid fa-chalkboard-user"></i>

            <span>Akun Guru</span>

        </a>


        <a href="{{ route('admin.penilaian') }}">

            <i class="fa-solid fa-star"></i>

            <span>Penilaian</span>

        </a>


        <a href="{{ route('admin.laporan') }}">

            <i class="fa-solid fa-file-lines"></i>

            <span>Laporan</span>

        </a>


      <a href="{{ route('admin.profil') }}">

            <i class="fa-solid fa-user"></i>

            <span>Profil</span>

        </a>


        <!-- PERMINTAAN PASSWORD -->

        <a href="{{ route('admin.password.requests') }}"
           class="notification-link">

            <i class="fa-solid fa-bell"></i>

            <span>Permintaan Password</span>


            @if($jumlahPermintaan > 0)

                <span class="notification-badge">
                    {{ $jumlahPermintaan }}
                </span>

            @endif

        </a>


        <a href="{{ route('login') }}">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>Logout</span>

        </a>


    </div>

</aside>
<a href="{{ route('admin.ekstrakurikuler') }}">
    <i class="fa-solid fa-futbol"></i>
    <span>Ekstrakurikuler</span>
</a>
<a href="{{ route('admin.penilaian') }}">
    <i class="fa-solid fa-star"></i>
    <span>Penilaian</span>
</a>
<a href="{{ route('admin.laporan') }}">
    <i class="fa-solid fa-file-lines"></i>
    <span>Laporan</span>
</a>
<a href="{{ route('admin.profil') }}">
    <i class="fa-solid fa-user"></i>
    <span>Profil</span>
</a>




<!-- CONTENT -->

<main class="content">


    <!-- HEADER -->

    <div class="header">

        <div>

            <h1>Dashboard Admin</h1>

            <p>
                Selamat datang, {{ $namaAdmin }}. Kelola seluruh data
                Sistem Ekstrakurikuler Sekolah.
            </p>

        </div>


        <!-- ICON NOTIFIKASI -->

        <a href="{{route('admin.password.requests') }}"
   class="notification-top">
            <i class="fa-solid fa-bell"></i>


            @if($jumlahPermintaan > 0)

                <span class="notification-badge">
                    {{ $jumlahPermintaan }}
                </span>

            @endif

        </a>

    </div>



    <!-- STATISTIK -->

    <div class="cards">


        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-users"></i>

            </div>

            <div>

                <h2>{{ $totalSiswa }}</h2>

                <p>Total Siswa</p>

            </div>

        </div>



        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-chalkboard-user"></i>

            </div>

            <div>

                <h2>{{ $totalGuru }}</h2>

                <p>Total Guru</p>

            </div>

        </div>



        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-people-group"></i>

            </div>

            <div>

                <h2>{{ $totalEkskul }}</h2>

                <p>Ekstrakurikuler</p>

            </div>

        </div>



        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-star"></i>

            </div>

            <div>

                <h2>{{ $totalPenilaianTampil }}</h2>

                <p>Data Penilaian</p>

            </div>

        </div>


    </div>



    <!-- VISUALISASI STATISTIK -->

    <div class="charts-grid">

        <div class="chart-card">

            <h2>Pendaftar per Ekstrakurikuler</h2>

            <p class="chart-sub">
                Jumlah siswa yang terdaftar pada setiap kegiatan.
            </p>

            <div class="chart-box">
                <canvas id="chartPendaftar"></canvas>
            </div>

            <div class="chart-empty" id="emptyPendaftar" style="display:none;">
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
                <canvas id="chartKehadiran"></canvas>
            </div>

            <div class="chart-empty" id="emptyKehadiran" style="display:none;">
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
                <canvas id="chartKelas"></canvas>
            </div>

            <div class="chart-empty" id="emptyKelas" style="display:none;">
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
                <canvas id="chartNilai"></canvas>
            </div>

            <div class="chart-empty" id="emptyNilai" style="display:none;">
                <i class="fa-regular fa-star"></i>
                Belum ada data penilaian.
            </div>

        </div>

    </div>



    <!-- DATA SISTEM -->

    <div class="grid">


        <div class="card">

            <h2>Data Sistem</h2>


            <div class="item">

                <span>Total Siswa</span>

                <strong>{{ $totalSiswa }}</strong>

            </div>


            <div class="item">

                <span>Total Guru</span>

                <strong>{{ $totalGuru }}</strong>

            </div>


            <div class="item">

                <span>Ekstrakurikuler</span>

                <strong>{{ $totalEkskul }}</strong>

            </div>


            <div class="item">

                <span>Penilaian</span>

                <strong>{{ $totalPenilaianTampil }}</strong>

            </div>

        </div>



        <!-- STATUS -->

        <div class="card">

            <h2>Status Sistem</h2>


            <div class="item">

                <span>Database</span>

                <span class="badge">
                    Aktif
                </span>

            </div>


            <div class="item">

                <span>Sistem</span>

                <span class="badge">
                    Online
                </span>

            </div>


            <div class="item">

                <span>Server</span>

                <span class="badge">
                    Aktif
                </span>

            </div>


            <div class="item">

                <span>Backup</span>

                <span class="badge">
                    Tersedia
                </span>

            </div>

        </div>


    </div>



    <!-- NOTIFIKASI PERMINTAAN PASSWORD -->

    <div class="card notification-card">

        <div class="notification-header">

            <h2>
                <i class="fa-solid fa-bell"></i>
                Permintaan Ubah Password
            </h2>


           <a href="{{ route('admin.password.requests') }}"
         class="view-all">
           Lihat Semua
          </a>
        </div>


        @php

            $permintaanTerbaru =
                \App\Models\PasswordRequest::latest()
                ->take(5)
                ->get();

        @endphp


        @forelse($permintaanTerbaru as $item)


            <div class="request">


                <div class="request-icon">

                    <i class="fa-solid fa-key"></i>

                </div>


                <div class="request-info">

                    <strong>
                        {{ $item->username }}
                    </strong>

                    <span>

                        Role:
                        {{ ucfirst($item->role) }}

                        &nbsp; • &nbsp;

                        {{ $item->created_at->format('d/m/Y H:i') }}

                    </span>

                </div>


                <span class="status">

                    {{ ucfirst($item->status) }}

                </span>


            </div>


        @empty


            <div style="
                text-align:center;
                padding:30px;
                color:#777;
            ">

                <i class="fa-regular fa-bell-slash"
                   style="
                    font-size:30px;
                    margin-bottom:10px;
                 ">
                </i>

                <p>
                    Belum ada permintaan ubah password.
                </p>

            </div>


        @endforelse


    </div>


</main>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                ['emptyPendaftar', 'emptyKehadiran', 'emptyKelas', 'emptyNilai']
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
                tampilkanKosong('chartPendaftar', 'emptyPendaftar');
            } else {
                new Chart(document.getElementById('chartPendaftar'), {
                    type: 'bar',
                    data: {
                        labels: labelPendaftar,
                        datasets: [{
                            label: 'Jumlah Pendaftar',
                            data: dataPendaftar,
                            backgroundColor: '#212529',
                            hoverBackgroundColor: '#08718b',
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
                                grid: { color: '#eef1f5' }
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
                tampilkanKosong('chartKehadiran', 'emptyKehadiran');
            } else {
                new Chart(document.getElementById('chartKehadiran'), {
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
                tampilkanKosong('chartKelas', 'emptyKelas');
            } else {
                new Chart(document.getElementById('chartKelas'), {
                    type: 'doughnut',
                    data: {
                        labels: labelKelas,
                        datasets: [{
                            data: dataKelas,
                            backgroundColor: [
                                '#212529',
                                '#08718b',
                                '#148f5a',
                                '#f59e0b',
                                '#3b82f6',
                                '#ef4444',
                                '#8b5cf6'
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
                tampilkanKosong('chartNilai', 'emptyNilai');
            } else {
                new Chart(document.getElementById('chartNilai'), {
                    type: 'bar',
                    data: {
                        labels: labelNilai,
                        datasets: [{
                            label: 'Rata-rata Nilai',
                            data: dataNilai,
                            backgroundColor: '#08718b',
                            hoverBackgroundColor: '#212529',
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
                                grid: { color: '#eef1f5' }
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