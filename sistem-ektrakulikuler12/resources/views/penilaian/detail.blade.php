<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Nilai - EKSTRA</title>

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
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #0d6efd, #084298);
            color: white;
            padding: 25px 18px;
            z-index: 10;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo i {
            font-size: 35px;
            margin-bottom: 8px;
        }

        .logo h2 {
            font-size: 18px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .menu i {
            width: 22px;
        }

        .content {
            margin-left: 250px;
            padding: 35px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #0d6efd;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .back:hover {
            text-decoration: underline;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: clamp(24px, 4vw, 30px);
            color: #172554;
            overflow-wrap: anywhere;
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
            box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
            overflow-wrap: anywhere;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 19px;
            color: #172554;
        }

        .card-title i {
            color: #0d6efd;
            font-size: 20px;
        }

        .nilai-box {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            padding: 28px 20px;
            border-radius: 14px;
            text-align: center;
        }

        .nilai-box p {
            color: #64748b;
            font-size: 14px;
        }

        .nilai-box h1 {
            font-size: clamp(46px, 12vw, 70px);
            color: #0d6efd;
            line-height: 1.15;
            margin: 6px 0 10px;
        }

        .grade {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            padding: 7px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .grade.cukup {
            background: #fef3c7;
            color: #a16207;
        }

        .grade.kurang {
            background: #fee2e2;
            color: #b91c1c;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .info-item {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            padding: 18px;
            border-radius: 10px;
        }

        .info-item span {
            display: block;
            color: #64748b;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .info-item strong {
            color: #1e40af;
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        @media (max-width: 1024px) {
            .content {
                padding: 28px 22px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: sticky;
                top: 0;
                width: 100%;
                height: auto;
                padding: 12px 14px;
                z-index: 100;
                box-shadow: 0 6px 18px rgba(0, 0, 0, .18);
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 9px;
                text-align: left;
                margin-bottom: 9px;
            }

            .logo i {
                font-size: 22px;
                margin-bottom: 0;
            }

            .logo h2 {
                font-size: 18px;
            }

            .menu {
                flex-direction: row;
                gap: 6px;
                overflow-x: auto;
                padding-bottom: 3px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
            }

            .menu a {
                flex: 0 0 auto;
                justify-content: flex-start;
                padding: 9px 12px;
                gap: 7px;
                font-size: 12px;
                white-space: nowrap;
                border-radius: 8px;
            }

            .menu i {
                width: auto;
                font-size: 14px;
            }

            .content {
                margin-left: 0;
                padding: 16px;
            }

            .card {
                padding: 18px;
                border-radius: 13px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 12px;
            }

            .card {
                padding: 15px;
            }

            .nilai-box {
                padding: 22px 15px;
            }
        }
    </style>
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

        <a href="{{ route('penilaian') }}" class="active">
            <i class="fa-solid fa-star"></i>
            <span>Nilai Saya</span>
        </a>

        <a href="{{ route('profil') }}">
            <i class="fa-solid fa-user"></i>
            <span>Profil Saya</span>
        </a>

        <a href="{{ route('logout') }}">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>

<main class="content">

    <a href="{{ route('penilaian') }}" class="back">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Nilai Saya
    </a>

    <header class="header">
        <h1>{{ $nilai->nama_kegiatan }}</h1>
        <p>Detail penilaian ekstrakurikuler.</p>
    </header>

    @php
        $angkaNilai = (float) $nilai->nilai;

        if ($angkaNilai >= 85) {
            $predikat = 'Sangat Baik';
            $gradeClass = '';
        } elseif ($angkaNilai >= 75) {
            $predikat = 'Cukup';
            $gradeClass = 'cukup';
        } else {
            $predikat = 'Perlu Bimbingan';
            $gradeClass = 'kurang';
        }
    @endphp

    <section class="card">
        <div class="nilai-box">
            <p>Nilai Akhir</p>
            <h1>{{ $nilai->nilai }}</h1>
            <span class="grade {{ $gradeClass }}">{{ $predikat }}</span>
        </div>
    </section>

    <section class="card">
        <h2 class="card-title">
            <i class="fa-solid fa-circle-info"></i>
            Informasi Penilaian
        </h2>

        <div class="info-grid">
            <div class="info-item">
                <span>Nama Siswa</span>
                <strong>{{ $nilai->username }}</strong>
            </div>

            <div class="info-item">
                <span>Ekstrakurikuler</span>
                <strong>{{ $nilai->nama_kegiatan }}</strong>
            </div>

            <div class="info-item">
                <span>Dicatat Oleh</span>
                <strong>{{ $nilai->dicatat_oleh ?: '-' }}</strong>
            </div>

            <div class="info-item">
                <span>Tanggal</span>
                <strong>{{ $nilai->created_at?->translatedFormat('d F Y') ?? '-' }}</strong>
            </div>
        </div>
    </section>

    <section class="card">
        <h2 class="card-title">
            <i class="fa-solid fa-comment-dots"></i>
            Catatan Pembina
        </h2>

        <p style="color:#475569;line-height:1.8;">
            {{ $nilai->keterangan ?: 'Belum ada catatan dari pembina.' }}
        </p>
    </section>

</main>

</body>
</html>
