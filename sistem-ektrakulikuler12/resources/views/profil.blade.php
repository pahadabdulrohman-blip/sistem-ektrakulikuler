
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - Sistem Ekstrakurikuler</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #172033;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 324px;
            background: linear-gradient(180deg, #034aa0, #2023b2);
            color: white;
            padding: 35px 24px;
            overflow-y: auto;
        }

        /* LOGO SIDEBAR */
        .logo {
            width: 104px;
            height: 104px;
            border-radius: 25px;
            background: rgba(255,255,255,.17);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 58px;
            font-weight: bold;
            margin: 0 auto 25px;
            overflow: hidden;
            color: white;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .sidebar .subtitle {
            text-align: center;
            color: #d8f5e7;
            margin-bottom: 38px;
        }

        .menu-title {
            border-top: 1px solid rgba(255,255,255,.2);
            padding: 35px 18px 18px;
            font-size: 13px;
            color: #d8f5e7;
        }

        .sidebar a {
            display: block;
            padding: 20px;
            margin-bottom: 8px;
            border-radius: 14px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: .2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,.2);
        }

        .main {
            margin-left: 324px;
            min-height: 100vh;
            padding: 42px 48px;
        }

        .topbar {
            background: white;
            border-radius: 22px;
            padding: 28px 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,.04);
        }

        .topbar h1 {
            color: #0703e6;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .topbar p {
            color: #718096;
        }

        .top-user {
            color: #272a76;
            font-weight: bold;
            text-align: right;
        }

        .profile-layout {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,.04);
        }

        .profile-card {
            text-align: center;
            height: fit-content;
        }

        .avatar {
            width: 145px;
            height: 145px;
            border-radius: 50%;
            background: #d8f5e7;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #3351d7;
            font-size: 65px;
            font-weight: bold;
            border: 5px solid #e5f8ee;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-card h2 {
            color: #363ecf;
            margin-bottom: 8px;
        }

        .role {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 30px;
            background: #d8f5e7;
            color: #3249c9;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .card-title {
            color: #1945c7;
            font-size: 23px;
            margin-bottom: 25px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .info {
            background: #f7faf9;
            border: 1px solid #e1eee7;
            padding: 20px;
            border-radius: 12px;
            min-width: 0;
        }

        .info small {
            display: block;
            color: #718096;
            margin-bottom: 9px;
        }

        .info strong {
            color: #1954ca;
            overflow-wrap: anywhere;
        }

        .upload-card {
            margin-top: 25px;
        }

        .upload-card p {
            color: #718096;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        input[type="file"] {
            width: 100%;
            padding: 13px;
            border: 1px solid #d6e2dc;
            border-radius: 10px;
            background: #f8faf9;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            border: none;
            border-radius: 10px;
            padding: 14px 22px;
            background: #1b48dd;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: #1c6cce;
        }

        .btn-secondary {
            background: #64748b;
            margin-top: 20px;
        }

        .message {
            padding: 13px;
            border-radius: 9px;
            margin-bottom: 15px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 1000px) {
            .sidebar {
                width: 250px;
            }

            .main {
                margin-left: 250px;
                padding: 25px;
            }

            .profile-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .top-user {
                text-align: left;
            }
        }
    </style>
</head>

<body>

@php
    $username = session('username', 'siswa');

    $fotoProfil = \App\Models\ProfilePhoto::where('username', $username)
        ->where('role', 'siswa')
        ->first();

    $fotoUrl = ($fotoProfil && $fotoProfil->photo_path)
        ? asset('storage/' . $fotoProfil->photo_path)
        : null;
@endphp

<!-- SIDEBAR SISWA -->
<aside class="sidebar">

    <div class="logo">
        @if ($fotoUrl)
            <img
                src="{{ $fotoUrl }}?v={{ $fotoProfil->updated_at ? $fotoProfil->updated_at->timestamp : time() }}"
                alt="Logo Foto Profil Siswa"
            >
        @else
            S
        @endif
    </div>

    <h2>SISWA</h2>
    <p class="subtitle">Sistem Ekstrakurikuler</p>

    <div class="menu-title">MENU SISWA</div>

    <a href="/dashboard-siswa">🏠 &nbsp; Dashboard Siswa</a>
    <a href="/ekstrakurikuler">👥 &nbsp; Daftar Ekstrakurikuler</a>
    <a href="/jadwal-ekstrakurikuler">📅 &nbsp; Jadwal Kegiatan</a>
    <a href="/penilaian">⭐ &nbsp; Penilaian Saya</a>
    <a href="/profil" class="active">👤 &nbsp; Profil Siswa</a>
    <a href="/logout">🚪 &nbsp; Logout</a>

</aside>

<!-- KONTEN UTAMA -->
<main class="main">

    <header class="topbar">
        <div>
            <h1>Profil Siswa</h1>
            <p>Kelola informasi akun dan foto profil kamu.</p>
        </div>

        <div class="top-user">
            Siswa AKTIVIA<br>
            <small>Sistem Ekstrakurikuler</small>
        </div>
    </header>

    <div class="profile-layout">

        <!-- KARTU PROFIL -->
        <section class="card profile-card">

            <div class="avatar">
                @if ($fotoUrl)
                    <img
                        src="{{ $fotoUrl }}?v={{ $fotoProfil->updated_at ? $fotoProfil->updated_at->timestamp : time() }}"
                        alt="Foto Profil Siswa"
                    >
                @else
                    S
                @endif
            </div>

            <h2>{{ $username }}</h2>

            <span class="role">Siswa Aktif</span>

            <br>

            <a href="/dashboard-siswa" class="btn btn-secondary">
                ← Kembali ke Dashboard
            </a>

        </section>

        <div>

            <!-- INFORMASI AKUN -->
            <section class="card">

                <h2 class="card-title">Informasi Akun</h2>

                <div class="info-grid">

                    <div class="info">
                        <small>Nama Pengguna</small>
                        <strong>{{ $username }}</strong>
                    </div>

                    <div class="info">
                        <small>Role Pengguna</small>
                        <strong>Siswa</strong>
                    </div>

                </div>

            </section>

            <!-- UPLOAD FOTO -->
            <section class="card upload-card">

                <h2 class="card-title">Foto Profil</h2>

                <p>
                    Pilih foto profil baru untuk memperbarui
                    tampilan akun siswa kamu.
                </p>

                @if (session('success'))
                    <div class="message success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="message error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form
                    action="{{ route('profil.foto.upload') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <input
                        type="file"
                        name="foto"
                        accept=".jpg,.jpeg,.png,.webp"
                        required
                    >

                    <button type="submit" class="btn">
                        📷 Simpan Foto Profil
                    </button>

                </form>

            </section>

        </div>

    </div>

</main>

</body>
</html>
