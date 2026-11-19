<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $ekskul->nama_ekstrakurikuler }}</title>

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

        /* Samakan dengan dashboard siswa: biru, bukan hitam seperti admin. */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #0785bb, #08658c);
            padding: 25px 15px;
            color: white;
            z-index: 1000;
        }

        .logo {
            text-align: center;
            margin-bottom: 12px;
        }

        .logo i {
            font-size: 40px;
            margin-bottom: 8px;
        }

        .logo h2 {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;
        }

        .sidebar p {
            text-align: center;
            color: rgba(255,255,255,.75);
            margin-bottom: 30px;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            padding: 13px 16px;
            margin-bottom: 8px;
            border-radius: 12px;
            font-weight: 500;
            transition: .3s;
        }

        .menu i {
            width: 22px;
            text-align: center;
        }

        .menu:hover {
            background: rgba(255,255,255,.20);
        }

        .content {
            margin-left: 260px;
            padding: 45px;
        }

        .back {
            display: inline-block;
            background: #0785bb;
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

        <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <h2>SISWA</h2>
        </div>

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
            <i class="fa-solid fa-star"></i>Nilai Saya
        </a>

        <a href="{{ route('profil') }}" class="menu">
            <i class="fa-solid fa-user"></i>Profil
        </a>

        <a href="{{ route('logout.confirm') }}" class="menu" data-logout>
            <i class="fa-solid fa-right-from-bracket"></i>Logout
        </a>

        @include('partials.logout-form')

    </aside>


    <main class="content">

        <a href="{{ route('ekstrakurikuler') }}" class="back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div style="display:inline-block;background:#dcfce7;color:#166534;
                    padding:8px 14px;border-radius:999px;font-weight:bold;
                    font-size:13px;margin-bottom:16px;">
            <i class="fa-solid fa-user-graduate"></i>
            Tampilan Siswa — hanya melihat foto kegiatan
        </div>

        <div class="card">

            <div class="icon">
                @include('partials.ekskul-icon', ['ikon' => $ekskul->ikon, 'nama' => $ekskul->nama_ekstrakurikuler])
            </div>

            <h1>
                {{ $ekskul->nama_ekstrakurikuler }}
            </h1>

            <p class="description">
                {{ $ekskul->deskripsi ?: 'Belum ada deskripsi.' }}
            </p>

            <div class="info">

                <h3>Informasi Ekstrakurikuler</h3>

                <p>
                    Kegiatan {{ $ekskul->nama_ekstrakurikuler }}
                    merupakan salah satu kegiatan ekstrakurikuler
                    yang tersedia di sekolah.
                </p>

                <p>
                    <strong>Pembina:</strong>
                    {{ $ekskul->pembina ?: 'Belum ditentukan' }}<br>

                    <strong>Jadwal:</strong>
                    {{ $ekskul->jadwal ?: 'Belum ditentukan' }}<br>

                    <strong>Tempat:</strong>
                    {{ $ekskul->tempat ?: 'Belum ditentukan' }}
                </p>

            </div>

            @include('partials.foto-kegiatan', [
                'ekskul' => $ekskul,
                'fotos' => $fotos ?? collect(),
                'bisaKelola' => false,
            ])

        </div>

    </main>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>