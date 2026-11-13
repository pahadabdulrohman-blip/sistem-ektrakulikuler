
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ekskul['nama'] ?? 'Detail Ekskul' }} - Admin</title>

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
                position: sticky;
                top: 0;
                width: 100%;
                height: auto;
                padding: 12px 14px;
                z-index: 100;
                box-shadow: 0 6px 18px rgba(0, 0, 0, .2);
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 10px;
                text-align: left;
                margin-bottom: 9px;
            }

            .logo h2 {
                font-size: 17px;
            }

            .logo p {
                display: none;
            }

            .menu {
                display: flex;
                gap: 6px;
                overflow-x: auto;
                padding-bottom: 3px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
            }

            .menu a {
                flex: 0 0 auto;
                margin-bottom: 0;
                padding: 9px 12px;
                font-size: 12px;
                white-space: nowrap;
            }

            .content {
                margin-left: 0;
                padding: 16px;
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

        @media (max-width: 480px) {
            .content {
                padding: 12px;
            }

            .box {
                padding: 18px;
                border-radius: 14px;
            }

            .icon {
                font-size: 50px;
            }

            h1 {
                font-size: 23px;
            }

            .description {
                font-size: 15px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">
        <h2>ADMIN PANEL</h2>
        <p>Sistem Ekstrakurikuler</p>
    </div>

    <div class="menu">
        <a href="{{ route('dashboard.admin') }}">🏠 Dashboard</a>
        <a href="{{ route('admin.ekstrakurikuler') }}">⚽ Ekstrakurikuler</a>
        <a href="{{ route('admin.penilaian') }}">⭐ Penilaian</a>
        <a href="{{ route('admin.laporan') }}">📄 Laporan</a>
        <a href="{{ route('admin.profil') }}">👤 Profil</a>
        <a href="{{ route('login') }}">🚪 Logout</a>
    </div>
</div>

<div class="content">
    <a href="{{ route('admin.ekstrakurikuler') }}" class="back">
        ← Kembali
    </a>

    <div class="box">
        <div class="icon">
            {{ $ekskul['ikon'] ?? '⚽' }}
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
                ← Daftar Ekskul
            </a>

            <a href="{{ route('admin.ekstrakurikuler.edit', $ekskul['id']) }}"
               class="btn edit">
                ✏ Edit
            </a>
        </div>
    </div>
</div>

</body>
</html>
