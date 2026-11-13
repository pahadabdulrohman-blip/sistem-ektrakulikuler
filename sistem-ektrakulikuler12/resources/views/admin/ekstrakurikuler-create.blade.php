<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Ekstrakurikuler</title>

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

        @media (max-width: 1024px) {
            .content {
                padding: 30px 24px;
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
                padding: 18px;
            }

            .header h1 {
                font-size: 25px;
            }

            .box {
                padding: 22px;
                max-width: 100%;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 12px;
            }

            .header h1 {
                font-size: 22px;
            }

            .box {
                padding: 18px;
                border-radius: 13px;
            }

            .form-group {
                margin-bottom: 16px;
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

        <a href="{{ route('admin.ekstrakurikuler') }}"
           class="active">
            ⚽ Ekstrakurikuler
        </a>

        <a href="{{ route('admin.penilaian') }}">
            ⭐ Penilaian
        </a>

        <a href="{{ route('admin.laporan') }}">
            📄 Laporan
        </a>

        <a href="{{ route('admin.profil') }}">
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

        <h1>
            Tambah Ekstrakurikuler
        </h1>

        <p>
            Tambahkan kegiatan ekstrakurikuler baru.
        </p>

    </div>


    <div class="box">

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
                    placeholder="Contoh: 🏸">

                <small>
                    Bisa menggunakan emoji, misalnya ⚽ 🏀 🏸 💻.
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

                    ← Kembali

                </a>


                <button
                    type="submit"
                    class="btn save">

                    + Simpan Ekskul

                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>