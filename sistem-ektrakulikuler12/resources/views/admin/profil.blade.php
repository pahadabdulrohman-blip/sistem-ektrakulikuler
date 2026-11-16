<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Admin</title>

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
            color: #111827;
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
            margin-top: 5px;
            color: #9ca3af;
            font-size: 12px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: #d1d5db;
            padding: 14px;
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
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 30px;
        }

        .header p {
            color: #6b7280;
            margin-top: 8px;
        }

        .profile {
            max-width: 750px;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        .avatar {
            width: 90px;
            height: 90px;
            background: #2563eb;
            color: white;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 40px;
            margin-bottom: 20px;
        }

        .profile h2 {
            margin-bottom: 5px;
        }

        .role {
            color: #2563eb;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .info strong {
            display: inline-block;
            width: 130px;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .back:hover {
            background: #1d4ed8;
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
            }

            .content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .info strong {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

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

            <a href="{{ route('admin.laporan') }}">
                <i class="fa-solid fa-file-lines"></i>Laporan
            </a>

            <a href="{{ route('admin.profil') }}" class="active">
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

            <h1>Profil Admin</h1>

            <p>
                Informasi akun administrator sistem.
            </p>

        </div>


        <div class="profile">

            <div class="avatar">
                <i class="fa-solid fa-user-shield"></i>
            </div>

            <h2>Administrator</h2>

            <div class="role">
                ADMINISTRATOR
            </div>


            <div class="info">
                <strong>Nama</strong>
                Administrator Sistem
            </div>


            <div class="info">
                <strong>Username</strong>
                admin
            </div>


            <div class="info">
                <strong>Email</strong>
                adminekstrakulikuler@gmail.co
            </div>


            <div class="info">
                <strong>Role</strong>
                Admin
            </div>


            <div class="info">
                <strong>Status</strong>
                Aktif
            </div>


            <a href="{{ route('dashboard.admin') }}" class="back">
                ← Kembali ke Dashboard
            </a>

        </div>
@php
    $fotoProfil = \App\Models\ProfilePhoto::where(
        'username', session('username')
    )->where(
        'role', session('role')
    )->first();
@endphp

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
    @endforeach
@endif

<div style="margin: 20px 0;">
    @if ($fotoProfil)
        <img
            src="{{ asset('storage/' . $fotoProfil->photo_path) }}"
            alt="Foto Profil"
            style="width:130px;height:130px;object-fit:cover;border-radius:50%;"
        >
    @else
        <div style="width:130px;height:130px;border-radius:50%;
                    background:#d9f7e7;display:flex;align-items:center;
                    justify-content:center;font-size:45px;color:#166534;">
            <i class="fa-solid fa-user"></i>
        </div>
    @endif

    <form action="{{ route('profil.foto.upload') }}"
          method="POST"
          enctype="multipart/form-data"
          style="margin-top:15px;">
        @csrf

        <label for="foto">Pilih foto profil</label><br>

        <input
            type="file"
            name="foto"
            id="foto"
            accept=".jpg,.jpeg,.png,.webp"
            required
        >

        <br><br>

        <button type="submit">Simpan Foto</button>
    </form>
</div>
    </div>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>

</html>