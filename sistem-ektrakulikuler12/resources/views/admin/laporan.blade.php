<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan - Admin</title>

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
            margin-bottom: 30px;
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
        }

        /* RINGKASAN */
        .summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .summary-icon {
            width: 55px;
            height: 55px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #dbeafe;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .summary-card h2 {
            color: #111827;
            font-size: 24px;
        }

        .summary-card p {
            color: #6b7280;
            font-size: 12px;
            margin-top: 3px;
        }

        .table-box {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background: #f9fafb;
        }

        .nilai {
            font-weight: bold;
            color: #2563eb;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #e5e7eb;
            color: #4b5563;
            font-size: 12px;
            white-space: nowrap;
        }

        .badge.sangat-baik {
            background: #dcfce7;
            color: #166534;
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

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 35px;
        }

        .report-note {
            margin-top: 18px;
            color: #6b7280;
            font-size: 12px;
        }

        .print {
            margin-bottom: 20px;
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        @media(max-width: 900px) {
            .summary {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 700px) {
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

            .header,
            .heading {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            h1 {
                font-size: 24px;
            }
        }

        @media print {
            .sidebar,
            .back,
            .print {
                display: none;
            }

            .content {
                margin-left: 0;
            }

            .summary-card,
            .table-box {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

@php
    $detailPenilaian = $detailPenilaian ?? collect();
    $totalSiswa = $totalSiswa ?? 0;
    $totalPenilaian = $totalPenilaian ?? $detailPenilaian->count();
    $rataNilai = $rataNilai ?? '-';
    $totalPendaftar = $totalPendaftar ?? 0;
    $rekapEkskul = $rekapEkskul ?? collect();
@endphp

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

            <a href="{{ route('admin.guru.index') }}">
                <i class="fa-solid fa-chalkboard-user"></i>Akun Guru
            </a>

            <a href="{{ route('admin.penilaian') }}">
                <i class="fa-solid fa-star"></i>Penilaian
            </a>

            <a href="{{ route('admin.laporan') }}" class="active">
                <i class="fa-solid fa-file-lines"></i>Laporan
            </a>

            <a href="{{ route('admin.profil') }}">
                <i class="fa-solid fa-user"></i>Profil
            </a>

            <a href="{{ route('login') }}">
                <i class="fa-solid fa-right-from-bracket"></i>Logout
            </a>

        </div>

    </div>


    <!-- CONTENT -->
    <div class="content">

        <div class="header">

            <div>
                <h1>Laporan</h1>
                <p>Laporan hasil penilaian ekstrakurikuler siswa</p>
            </div>

            <a href="{{ route('dashboard.admin') }}" class="back">
                &larr; Dashboard
            </a>

        </div>

        <button class="print" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>

        <!-- RINGKASAN -->
        <section class="summary">

            <div class="summary-card">
                <div class="summary-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <h2>{{ $totalSiswa }}</h2>
                    <p>Total Siswa</p>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon"><i class="fa-solid fa-star"></i></div>
                <div>
                    <h2>{{ $totalPenilaian }}</h2>
                    <p>Data Penilaian</p>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon"><i class="fa-solid fa-chart-line"></i></div>
                <div>
                    <h2>{{ $rataNilai }}</h2>
                    <p>Rata-rata Nilai</p>
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
        <div class="table-box">

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
                    @forelse ($detailPenilaian as $index => $item)
                        @php
                            $predikat = data_get($item, 'predikat', '-');
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ data_get($item, 'nama', '-') }}</td>
                            <td>{{ data_get($item, 'kelas', '-') }}</td>
                            <td>{{ data_get($item, 'kegiatan', '-') }}</td>
                            <td class="nilai">{{ data_get($item, 'nilai', '-') }}</td>
                            <td>
                                <span class="badge {{ \Illuminate\Support\Str::slug($predikat) }}">
                                    {{ $predikat }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada data penilaian untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <!-- REKAP AGREGAT EKSTRAKURIKULER -->
        <div class="table-box" style="margin-top: 25px;">

            <div style="margin-bottom: 18px;">
                <h2 style="color: #111827; font-size: 20px;">
                    Rekap Agregat Ekstrakurikuler
                </h2>
                <p style="color: #6b7280; font-size: 13px; margin-top: 4px;">
                    Dihitung langsung di database memakai COUNT, SUM, AVG,
                    dan GROUP BY.
                </p>
            </div>

            @include('partials.rekap-ekstrakurikuler', [
                'rekapEkskul' => $rekapEkskul,
                'totalPendaftar' => $totalPendaftar,
            ])

        </div>

        <p class="report-note">
            Laporan ini menampilkan data penilaian terbaru dari database.
            Gunakan tombol Cetak Laporan untuk mencetak halaman.
        </p>

    </div>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
