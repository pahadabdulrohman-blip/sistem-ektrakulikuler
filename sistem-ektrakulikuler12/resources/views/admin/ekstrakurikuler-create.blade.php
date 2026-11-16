<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Ekstrakurikuler</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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

            width: 255px;
            height: 100vh;

            background: #111827;
            color: white;

            padding: 25px 15px;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo h2 {
            font-size: 22px;
        }

        .logo p {
            color: #9ca3af;
            margin-top: 5px;
            font-size: 13px;
        }

        .menu a {
            display: block;

            color: #d1d5db;

            text-decoration: none;

            padding: 14px;

            margin-bottom: 7px;

            border-radius: 8px;
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
            margin-left: 255px;
            padding: 40px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 30px;
        }

        .header p {
            color: #64748b;
            margin-top: 8px;
        }

        .box {
            background: white;

            max-width: 750px;

            padding: 30px;

            border-radius: 16px;

            box-shadow:
                0 5px 20px rgba(0,0,0,.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            font-weight: bold;

            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 100%;

            padding: 13px;

            border: 1px solid #d1d5db;

            border-radius: 8px;

            font-size: 15px;

            outline: none;
        }

        input:focus,
        textarea:focus {
            border-color: #2563eb;
        }

        textarea {
            min-height: 120px;

            resize: vertical;
        }

        .error {
            color: #dc2626;

            font-size: 13px;

            margin-top: 5px;
        }

        .buttons {
            display: flex;

            gap: 10px;

            margin-top: 25px;
        }

        .btn {
            border: none;

            padding: 12px 20px;

            border-radius: 8px;

            text-decoration: none;

            cursor: pointer;

            font-size: 14px;
        }

        .save {
            background: #2563eb;
            color: white;
        }

        .save:hover {
            background: #1d4ed8;
        }

        .back {
            background: #e5e7eb;
            color: #111827;
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
                margin-bottom: 0;
                padding: 12px 10px;
            }

            .content {
                margin-left: 0;
                padding: 22px 15px;
            }

            .header h1 {
                font-size: 24px;
            }

            .box {
                padding: 20px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                text-align: center;
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

        <a href="{{ route('admin.ekstrakurikuler') }}"
           class="active">
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

        <a href="{{ route('admin.profil') }}">
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

        <h1>
            Tambah Ekstrakurikuler
        </h1>

        <p>
            Tambahkan kegiatan ekstrakurikuler baru.
        </p>

    </div>


    <div class="box">
        {{-- NOTIFIKASI BERHASIL --}}
@if(session('success'))
    <div style="
        background:#dcfce7;
        color:#166534;
        padding:13px;
        border-radius:8px;
        margin-bottom:20px;
    ">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

{{-- NOTIFIKASI ERROR --}}
@if($errors->any())
    <div style="
        background:#fee2e2;
        color:#b91c1c;
        padding:13px;
        border-radius:8px;
        margin-bottom:20px;
    ">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ $errors->first() }}
    </div>
@endif

        <form
            action="{{ route('admin.ekstrakurikuler.store') }}"
            method="POST">

            @csrf


            <div class="form-group">

                <label>
                    Nama Ekstrakurikuler
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Contoh: Badminton"
                    required>

                @error('nama')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label>
                    Ikon
                </label>

                <input
                    type="text"
                    name="ikon"
                    value="{{ old('ikon') }}"
                    placeholder="Contoh: F">

                <small>
                    Bisa menggunakan huruf atau singkatan, misalnya F, C, B, PS, V.
                </small>

            </div>


            <div class="form-group">

                <label>
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    placeholder="Masukkan deskripsi ekstrakurikuler"
                    required>{{ old('deskripsi') }}</textarea>

                @error('deskripsi')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label>
                    Nama Pembina
                </label>

                <input
                    type="text"
                    name="pembina"
                    value="{{ old('pembina') }}"
                    placeholder="Contoh: Bapak Ahmad">

            </div>


            <div class="form-group">

                <label>
                    Jadwal
                </label>

                <input
                    type="text"
                    name="jadwal"
                    value="{{ old('jadwal') }}"
                    placeholder="Contoh: Senin, 15.00 - 17.00">

            </div>


            <div class="buttons">

                <a
                    href="{{ route('admin.ekstrakurikuler') }}"
                    class="btn back">

                    <i class="fa-solid fa-arrow-left"></i> Kembali

                </a>


                <button
                    type="submit"
                    class="btn save">

                    <i class="fa-solid fa-plus"></i> Simpan Ekskul

                </button>

            </div>

        </form>

    </div>

</div>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>

</html>