
@php
    $username = session('username', session('name', 'Siswa'));
    $role = session('role', 'siswa');

    $fotoProfil = \App\Models\ProfilePhoto::where('username', $username)
        ->where('role', $role)
        ->first();

    $fotoUrl = ($fotoProfil && $fotoProfil->photo_path)
        ? $fotoProfil->url
        : null;

    $inisial = strtoupper(substr($username, 0, 1));
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - AKTIVIA</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #263445;
        }

        /* SIDEBAR SISWA */
        .sidebar {
            width: 300px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0d6efd, #084298);
            color: white;
            padding: 25px 15px;
            z-index: 1000;
            overflow-y: auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo > i {
            font-size: 43px;
            margin-bottom: 8px;
            display: block;
        }

        .logo h2 {
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* FOTO PROFIL SIDEBAR */
        .sidebar-photo {
            width: 95px;
            height: 95px;
            margin: 15px auto 12px;
            border-radius: 50%;
            overflow: hidden;
            background: rgba(255,255,255,.2);
            border: 4px solid rgba(255,255,255,.7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: bold;
            color: white;
        }

        .sidebar-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .sidebar-username {
            text-align: center;
            font-size: 14px;
            margin-bottom: 28px;
            color: #eaf2ff;
            overflow-wrap: anywhere;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px 16px;
            margin-bottom: 8px;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-size: 19px;
            font-weight: 500;
            transition: .3s;
        }

        .menu a i {
            width: 25px;
            text-align: center;
            font-size: 21px;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.20);
        }

        /* KONTEN */
        .main {
            margin-left: 300px;
            padding: 35px;
        }

        .header, .card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header h1, .card h2 {
            color: #172554;
        }

        .header p, .description {
            color: #718096;
            margin-top: 10px;
        }

        .content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 25px;
        }

        .profile-card {
            text-align: center;
        }

        .avatar {
            width: 145px;
            height: 145px;
            border-radius: 50%;
            margin: 5px auto 20px;
            background: #dbeafe;
            border: 6px solid #e7f0ff;
            display: grid;
            place-items: center;
            color: #0d6efd;
            font-size: 65px;
            font-weight: bold;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-card h2 {
            color: #172554;
            margin-bottom: 12px;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-block;
            background: #dbeafe;
            color: #084298;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: bold;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 25px;
        }

        .info-item {
            background: #f6f9ff;
            border: 1px solid #e1eafa;
            padding: 20px;
            border-radius: 13px;
        }

        .info-item span {
            display: block;
            color: #718096;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .info-item strong {
            color: #084298;
            overflow-wrap: anywhere;
        }

        input[type="file"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #d5e4dc;
            border-radius: 12px;
            margin: 20px 0;
            background: #f8faf9;
        }

        button {
            border: none;
            background: #0d6efd;
            color: white;
            padding: 15px 24px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            background: #084298;
        }

        .message {
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            background: #dbeafe;
            color: #084298;
        }

        .error {
            background: #ffe4e4;
            color: #b42318;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .back {
            display: inline-block;
            margin-top: 22px;
            padding: 13px 20px;
            border-radius: 10px;
            background: #64748b;
            color: white;
            text-decoration: none;
        }

        .back:hover {
            background: #475569;
        }

        @media(max-width: 1100px) {
            .content {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                min-height: 0;
                position: sticky;
                top: 0;
                padding: 12px 14px;
                z-index: 100;
                overflow: visible;
                box-shadow: 0 6px 18px rgba(0, 0, 0, .18);
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 9px;
                text-align: left;
                margin-bottom: 9px;
            }

            .logo > i {
                font-size: 20px;
                margin: 0;
                display: inline-block;
            }

            .sidebar-photo {
                width: 38px;
                height: 38px;
                margin: 0;
                font-size: 17px;
                border-width: 2px;
                flex-shrink: 0;
            }

            .logo h2 {
                font-size: 17px;
                letter-spacing: .5px;
            }

            .sidebar-username {
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
                padding: 9px 12px;
                margin: 0;
                gap: 7px;
                font-size: 12px;
                white-space: nowrap;
                border-radius: 8px;
            }

            .menu a i {
                width: auto;
                font-size: 14px;
            }

            .main {
                margin-left: 0;
                padding: 16px;
            }

            .header {
                display: block;
                padding: 18px;
                border-radius: 14px;
            }

            .header h1 {
                font-size: 23px;
            }

            .content {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .avatar {
                width: 110px;
                height: 110px;
                font-size: 48px;
            }

            .card {
                padding: 22px;
            }

            button,
            .back {
                width: 100%;
                text-align: center;
            }
        }

        @media(max-width: 480px) {
            .main {
                padding: 12px;
            }

            .header {
                padding: 15px;
            }

            .card {
                padding: 18px;
            }

            .header h1 {
                font-size: 21px;
            }

            .avatar {
                width: 90px;
                height: 90px;
                font-size: 40px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

<!-- SIDEBAR SISWA -->
<aside class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-graduation-cap"></i>

        <div class="sidebar-photo">
            @if($fotoUrl)
                <img src="{{ $fotoUrl }}?v={{ $fotoProfil->updated_at?->timestamp ?? time() }}"
                     alt="Foto Profil Siswa">
            @else
                {{ $inisial }}
            @endif
        </div>

        <h2>SISWA</h2>
    </div>

    <p class="sidebar-username">{{ $username }}</p>

    <nav class="menu">

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

        <a href="{{ route('penilaian') }}">
            <i class="fa-solid fa-star"></i>
            <span>Nilai Saya</span>
        </a>

        <a href="{{ route('siswa.profil') }}" class="active">
            <i class="fa-solid fa-user"></i>
            <span>Profil</span>
        </a>

        <a href="{{ route('logout.confirm') }}" data-logout>
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>

@include('partials.logout-form')

    </nav>

</aside>

<!-- KONTEN PROFIL -->
<main class="main">

    <header class="header">
        <div>
            <h1>Profil Siswa</h1>
            <p>Kelola informasi akun dan foto profil kamu.</p>
        </div>

        <div style="text-align:right;color:#0d6efd">
            <strong>AKTIVIA</strong>
            <p>Sistem Ekstrakurikuler</p>
        </div>
    </header>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <section class="content">

        <div class="card profile-card">

            <div class="avatar">
                @if($fotoUrl)
                    <img src="{{ $fotoUrl }}?v={{ $fotoProfil->updated_at?->timestamp ?? time() }}"
                         alt="Foto Profil">
                @else
                    {{ $inisial }}
                @endif
            </div>

            <h2>{{ $username }}</h2>

            <span class="status">Siswa Aktif</span>

            <br>

            <a href="{{ route('dashboard.siswa') }}" class="back">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>

        </div>

        <div>

            <div class="card">

                <h2>Informasi Akun</h2>

                <div class="info-grid">

                    <div class="info-item">
                        <span>Nama Pengguna</span>
                        <strong>{{ $username }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Role Pengguna</span>
                        <strong>Siswa</strong>
                    </div>

                </div>

            </div>

            <div class="card">

                <h2>Foto Profil</h2>

                <p class="description">
                    Pilih foto profil baru untuk memperbarui tampilan akun siswa.
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </p>

                <form action="{{ route('profil.foto.upload') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="file"
                           name="foto"
                           accept=".jpg,.jpeg,.png,.webp"
                           required>

                    <button type="submit">
                        <i class="fa-solid fa-camera"></i>
                        Simpan Foto Profil
                    </button>

                </form>

            </div>

        </div>

    </section>

</main>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
