<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $ekskul['nama'] }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #111827;
            padding: 30px 20px;
            color: white;
        }

        .sidebar h2 {
            text-align: center;
            margin: 0;
        }

        .sidebar p {
            text-align: center;
            color: #94a3b8;
            margin-bottom: 40px;
        }

        .menu {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px;
            margin-bottom: 8px;
            border-radius: 10px;
        }

        .menu:hover {
            background: #2563eb;
        }

        .content {
            margin-left: 250px;
            padding: 45px;
        }

        .back {
            display: inline-block;
            background: #111827;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .card {
            max-width: 800px;
            background: white;
            padding: 45px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .icon {
            font-size: 75px;
        }

        h1 {
            font-size: 40px;
            margin: 15px 0;
        }

        .description {
            color: #64748b;
            font-size: 20px;
            line-height: 1.6;
        }

        .info {
            margin-top: 30px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
        }

        .info p {
            margin-top: 10px;
            line-height: 1.7;
            color: #475569;
        }

        @media (max-width: 1024px) {
            .content {
                padding: 30px 24px;
            }

            .card {
                padding: 32px;
            }

            h1 {
                font-size: 34px;
            }

            .description {
                font-size: 17px;
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
                display: flex;
                align-items: center;
                gap: 6px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
                box-shadow: 0 6px 18px rgba(0, 0, 0, .2);
            }

            .sidebar h2,
            .sidebar p {
                display: none;
            }

            .menu {
                flex: 0 0 auto;
                margin: 0;
                padding: 9px 12px;
                font-size: 12px;
                white-space: nowrap;
                border-radius: 8px;
            }

            .content {
                margin-left: 0;
                padding: 18px;
            }

            .card {
                padding: 24px;
                border-radius: 16px;
            }

            h1 {
                font-size: 28px;
            }

            .description {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 12px;
            }

            .card {
                padding: 18px;
            }

            .icon {
                font-size: 52px;
            }

            h1 {
                font-size: 23px;
            }

            .description {
                font-size: 15px;
            }

            .info {
                margin-top: 20px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">

        <h2>ADMIN PANEL</h2>

        <p>Sistem Ekstrakurikuler</p>

        <a href="{{ route('dashboard.siswa') }}" class="menu">
            🏠 Dashboard
        </a>

        <a href="{{ route('ekstrakurikuler') }}" class="menu">
            ⚽ Ekstrakurikuler
        </a>

        <a href="{{ route('penilaian') }}" class="menu">
            ⭐ Penilaian
        </a>

        <a href="{{ route('profil') }}" class="menu">
            👤 Profil
        </a>

    </aside>


    <main class="content">

        <a href="{{ route('ekstrakurikuler') }}" class="back">
            ← Kembali
        </a>

        <div class="card">

            <div class="icon">
                {{ $ekskul['icon'] }}
            </div>

            <h1>
                {{ $ekskul['nama'] }}
            </h1>

            <p class="description">
                {{ $ekskul['deskripsi'] }}
            </p>

            <div class="info">

                <h3>Informasi Ekstrakurikuler</h3>

                <p>
                    Kegiatan {{ $ekskul['nama'] }}
                    merupakan salah satu kegiatan ekstrakurikuler
                    yang tersedia di sekolah.
                </p>

                <p>
                    Siswa dapat mengikuti kegiatan sesuai jadwal
                    yang telah ditentukan oleh sekolah.
                </p>

            </div>

        </div>

    </main>

</body>
</html>