
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ekskul['nama'] ?? 'Detail Ekskul' }} - Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #111827;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 270px;
            height: 100vh;
            background: #111827;
            color: white;
            padding: 25px 15px;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo h2 {
            font-size: 23px;
        }

        .logo p {
            color: #94a3b8;
            margin-top: 7px;
        }

        .menu a {
            display: block;
            color: #e5e7eb;
            text-decoration: none;
            padding: 14px 18px;
            margin-bottom: 8px;
            border-radius: 9px;
        }

        .menu a i {
            width: 18px;
            margin-right: 8px;
            text-align: center;
        }

        .menu a:hover {
            background: #2563eb;
        }

        .content {
            margin-left: 270px;
            padding: 40px;
        }

        .back {
            display: inline-block;
            background: #111827;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .box {
            background: white;
            max-width: 900px;
            border-radius: 18px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        .icon {
            font-size: 70px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .description {
            color: #64748b;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .info {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .label {
            font-weight: bold;
        }

        .value {
            color: #64748b;
            overflow-wrap: anywhere;
        }

        .buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
        }

        .edit {
            background: #f59e0b;
        }

        .back-list {
            background: #2563eb;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .box {
                padding: 25px;
            }

            .info {
                grid-template-columns: 1fr;
                gap: 7px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

<div class="sidebar">
    <div class="logo">
        <h2>ADMIN PANEL</h2>
        <p>Sistem Ekstrakurikuler</p>
    </div>

    <div class="menu">
        <a href="{{ route('dashboard.admin') }}"><i class="fa-solid fa-house"></i>Dashboard</a>
        <a href="{{ route('admin.ekstrakurikuler') }}"><i class="fa-solid fa-futbol"></i>Ekstrakurikuler</a>
        <a href="{{ route('admin.guru.index') }}"><i class="fa-solid fa-chalkboard-user"></i>Akun Guru</a>
        <a href="{{ route('admin.penilaian') }}"><i class="fa-solid fa-star"></i>Penilaian</a>
        <a href="{{ route('admin.laporan') }}"><i class="fa-solid fa-file-lines"></i>Laporan</a>
        <a href="{{ route('admin.profil') }}"><i class="fa-solid fa-user"></i>Profil</a>
        <a href="{{ route('login') }}"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </div>
</div>

<div class="content">
    <a href="{{ route('admin.ekstrakurikuler') }}" class="back">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="box">
        <div class="icon">
            @include('partials.ekskul-icon', ['ikon' => $ekskul['ikon'] ?? null, 'nama' => $ekskul['nama'] ?? ''])
        </div>

        <h1>{{ $ekskul['nama'] ?? '-' }}</h1>

        <p class="description">
            {{ $ekskul['deskripsi'] ?? 'Belum ada deskripsi.' }}
        </p>

        <div class="info">
            <div class="label">Pembina</div>
            <div class="value">{{ $ekskul['pembina'] ?? '-' }}</div>
        </div>

        <div class="info">
            <div class="label">Jadwal</div>
            <div class="value">{{ $ekskul['jadwal'] ?? '-' }}</div>
        </div>

        <div class="info">
            <div class="label">Tempat</div>
            <div class="value">
                {{ $ekskul['tempat'] ?? $ekskul['lokasi'] ?? '-' }}
            </div>
        </div>

        <div class="buttons">
            <a href="{{ route('admin.ekstrakurikuler') }}" class="btn back-list">
                <i class="fa-solid fa-arrow-left"></i> Daftar Ekskul
            </a>

            <a href="{{ route('admin.ekstrakurikuler.edit', $ekskul['id']) }}"
               class="btn edit">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
        </div>
    </div>
</div>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
