<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Admin</title>

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
                width: 190px;
            }

            .content {
                margin-left: 190px;
                padding: 20px;
            }

            .info strong {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
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
                🏠 Dashboard
            </a>

            <a href="{{ route('admin.ekstrakurikuler') }}">
                ⚽ Ekstrakurikuler
            </a>

            <a href="{{ route('admin.penilaian') }}">
                ⭐ Penilaian
            </a>

            <a href="{{ route('admin.laporan') }}">
                📄 Laporan
            </a>

            <a href="{{ route('admin.profil') }}" class="active">
                👤 Profil
            </a>

            <a href="{{ route('login') }}">
                🚪 Logout
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
                👤
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
                admin@sekolah.sch.id
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
                    justify-content:center;font-size:45px;">
            👤
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

</body>

</html>