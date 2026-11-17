
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Saya - EKSTRA</title>

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
            width: 250px;
            height: 100vh;
            left: 0;
            top: 0;
            padding: 25px 18px;
            color: white;
            background: linear-gradient(180deg, #0d6efd, #084298);
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo i {
            font-size: 35px;
            margin-bottom: 8px;
        }

        .logo h2 {
            font-size: 20px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 15px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.2);
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
            color: #172554;
            font-size: 30px;
        }

        .header p {
            color: #6b7280;
            margin-top: 7px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
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
            font-size: 20px;
        }

        .info {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .info-item {
            padding: 18px;
            border-radius: 10px;
            background: #eff6ff;
        }

        .info-item p {
            color: #64748b;
            font-size: 13px;
        }

        .info-item h3 {
            margin-top: 5px;
            color: #1e40af;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
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
            color: #0d6efd;
            font-weight: 700;
            font-size: 16px;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
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

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
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

            .info {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-school"></i>
            <h2>EKSTRA</h2>
        </div>

        <div class="menu">
            <a href="{{ route('dashboard.siswa') }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('ekstrakurikuler') }}">
                <i class="fa-solid fa-users"></i>
                <span>Ekstrakurikuler</span>
            </a>

            <a href="{{ route('jadwal.ekstrakurikuler') }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Jadwal Kegiatan</span>
            </a>

            <a href="{{ route('penilaian') }}" class="active">
                <i class="fa-solid fa-star"></i>
                <span>Nilai Saya</span>
            </a>

            <a href="{{ route('profil') }}">
                <i class="fa-solid fa-user"></i>
                <span>Profil Saya</span>
            </a>

            <a href="{{ route('logout.confirm') }}" data-logout>
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>

@include('partials.logout-form')
        </div>
    </aside>

    <main class="content">

        <div class="header">
            <h1>Nilai Ekstrakurikuler Saya</h1>
            <p>Lihat hasil penilaian kegiatan ekstrakurikuler kamu.</p>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="fa-solid fa-user-graduate"></i>
                <h2>Informasi Siswa</h2>
            </div>

            <div class="info">
                <div class="info-item">
                    <p>Username</p>
                    <h3>{{ session('username') }}</h3>
                </div>

                <div class="info-item">
                    <p>Total Penilaian</p>
                    <h3>{{ ($nilai ?? collect())->count() }} Penilaian</h3>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="fa-solid fa-clipboard-check"></i>
                <h2>Daftar Nilai Saya</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ekstrakurikuler</th>
                        <th>Nilai</th>
                        <th>Predikat</th>
                        <th>Keterangan</th>
                        <th>Guru Penilai</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($nilai ?? collect()) as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $item->nama_kegiatan }}</td>

                            <td class="nilai">
                                {{ $item->nilai }}
                            </td>

                            <td>
                                @if($item->nilai >= 85)
                                    <span class="badge baik">
                                        Sangat Baik
                                    </span>
                                @elseif($item->nilai >= 75)
                                    <span class="badge cukup">
                                        Cukup
                                    </span>
                                @else
                                    <span class="badge kurang">
                                        Perlu Bimbingan
                                    </span>
                                @endif
                            </td>

                            <td>{{ $item->keterangan ?: '-' }}</td>

                            <td>{{ $item->dicatat_oleh ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                <i class="fa-solid fa-circle-info"></i>
                                <br>
                                Belum ada nilai yang diberikan oleh Guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
