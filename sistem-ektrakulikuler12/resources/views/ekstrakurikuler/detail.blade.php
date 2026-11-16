<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $ekskul['nama'] }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

        .menu i {
            width: 18px;
            margin-right: 8px;
            text-align: center;
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

        @media(max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 22px 16px;
            }

            .sidebar p {
                margin-bottom: 20px;
            }

            .menu {
                display: inline-block;
                padding: 10px 14px;
                margin: 0 6px 8px 0;
            }

            .content {
                margin-left: 0;
                padding: 22px 15px;
            }

            .back {
                padding: 10px 16px;
                margin-bottom: 20px;
            }

            .card {
                padding: 25px 20px;
            }

            .icon {
                font-size: 52px;
            }

            h1 {
                font-size: 28px;
            }

            .description {
                font-size: 16px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

    <aside class="sidebar">

        <h2>ADMIN PANEL</h2>

        <p>Sistem Ekstrakurikuler</p>

        <a href="{{ route('dashboard.siswa') }}" class="menu">
            <i class="fa-solid fa-house"></i>Dashboard
        </a>

        <a href="{{ route('ekstrakurikuler') }}" class="menu">
            <i class="fa-solid fa-users"></i>Ekstrakurikuler
        </a>

        <a href="{{ route('jadwal.ekstrakurikuler') }}" class="menu">
            <i class="fa-solid fa-calendar-days"></i>Jadwal Kegiatan
        </a>

        <a href="{{ route('penilaian') }}" class="menu">
            <i class="fa-solid fa-star"></i>Penilaian
        </a>

        <a href="{{ route('profil') }}" class="menu">
            <i class="fa-solid fa-user"></i>Profil
        </a>

    </aside>


    <main class="content">

        <a href="{{ route('ekstrakurikuler') }}" class="back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card">

            <div class="icon">
                @include('partials.ekskul-icon', ['ikon' => $ekskul['icon'] ?? null, 'nama' => $ekskul['nama'] ?? ''])
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

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>