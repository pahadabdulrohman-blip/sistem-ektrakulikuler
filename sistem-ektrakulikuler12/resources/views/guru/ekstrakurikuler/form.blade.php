<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }} | AKTIVIA</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #eef8ff;
            color: #075985;
        }

        .sidebar {
            width: 270px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 28px 20px;
            background: linear-gradient(180deg, #0788bd, #08618b);
            color: white;
            z-index: 10;
            overflow-y: auto;
        }

        .brand {
            font-size: 21px;
            font-weight: 800;
            padding: 5px 12px 30px;
            border-bottom: 1px solid #ffffff55;
            line-height: 1.5;
        }

        .menu-title {
            margin: 30px 12px 15px;
            font-size: 12px;
            font-weight: 600;
            color: #c8edff;
        }

        .menu {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 8px;
            font-size: 14px;
            transition: .2s;
        }

        .menu:hover,
        .menu.active {
            background: #ffffff35;
        }

        .main {
            margin-left: 270px;
            min-height: 100vh;
        }

        .topbar {
            min-height: 90px;
            background: #0788bd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 18px 40px;
        }

        .topbar h2 {
            font-size: 23px;
        }

        .user {
            text-align: right;
            font-size: 13px;
        }

        .content {
            padding: 40px;
        }

        .panel {
            width: 100%;
            max-width: 820px;
            background: white;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 5px 20px #07598512;
        }

        .panel h1 {
            font-size: 28px;
            color: #075985;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #648ba4;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #075985;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #cfe3ee;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            background: #fbfeff;
            color: #243746;
            outline: none;
        }

        input:focus,
        textarea:focus {
            border-color: #0788bd;
            box-shadow: 0 0 0 3px rgba(7, 136, 189, .1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .hint {
            display: block;
            color: #7894a6;
            font-size: 12px;
            margin-top: 6px;
        }

        .alert {
            padding: 14px 18px;
            background: #ffe1e1;
            color: #a32323;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert ul {
            margin: 8px 0 0 20px;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 26px;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 13px 20px;
            color: white;
            background: #0788bd;
            text-decoration: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            text-align: center;
            transition: .2s;
        }

        .btn:hover {
            background: #056b99;
        }

        .btn-secondary {
            background: #e7eef3;
            color: #365b70;
        }

        .btn-secondary:hover {
            background: #d7e4ec;
        }

        @media (max-width: 1024px) {
            .content {
                padding: 28px 22px;
            }
        }

        @media (max-width: 800px) {
            .sidebar {
                position: sticky;
                top: 0;
                width: 100%;
                height: auto;
                padding: 12px 14px;
                z-index: 100;
                display: flex;
                align-items: center;
                gap: 8px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
                box-shadow: 0 6px 18px rgba(0, 0, 0, .18);
            }

            .brand,
            .menu-title {
                display: none;
            }

            .menu {
                flex: 0 0 auto;
                margin: 0;
                padding: 9px 12px;
                font-size: 12px;
                white-space: nowrap;
            }

            .main {
                margin-left: 0;
                min-height: 0;
            }

            .topbar {
                min-height: 0;
                padding: 16px 18px;
            }

            .topbar h2 {
                font-size: 17px;
            }

            .content {
                padding: 16px;
            }

            .panel {
                padding: 22px;
            }

            .panel h1 {
                font-size: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-group.full {
                grid-column: auto;
            }
        }

        @media (max-width: 480px) {
            .topbar {
                padding: 14px;
            }

            .content {
                padding: 12px;
            }

            .panel {
                padding: 18px;
                border-radius: 14px;
            }

            .panel h1 {
                font-size: 21px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<aside class="sidebar">

    <div class="brand">
        AKTIVIA<br>
        Sistem Ekstrakurikuler
    </div>

    <div class="menu-title">MENU GURU</div>

    <a href="{{ route('dashboard.guru') }}" class="menu">
        🏠 Dashboard
    </a>

    <a href="{{ route('guru.ekstrakurikuler.index') }}" class="menu active">
        👥 Ekstrakurikuler
    </a>

    <a href="{{ route('guru.penilaian') }}" class="menu">
        ⭐ Penilaian
    </a>

    <a href="{{ route('guru.laporan') }}" class="menu">
        📊 Laporan
    </a>

    <a href="{{ route('guru.absensi') }}" class="menu">
        📋 Absensi
    </a>

    <a href="{{ route('guru.profil') }}" class="menu">
        👤 Profil
    </a>

    <a href="{{ route('logout') }}" class="menu"
       onclick="return confirm('Yakin ingin keluar?')">
        🚪 Logout
    </a>

</aside>

<main class="main">

    <header class="topbar">
        <h2>{{ $judul }}</h2>

        <div class="user">
            <strong>{{ session('username', 'Guru') }}</strong>
            <br>
            Guru
        </div>
    </header>

    <section class="content">

        <div class="panel">

            <h1>{{ $judul }}</h1>

            <p class="subtitle">
                Lengkapi data ekstrakurikuler di bawah ini.
            </p>

            @if ($errors->any())
                <div class="alert">
                    <strong>Periksa kembali data yang dimasukkan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $action }}" method="POST">

                @csrf

                @if ($method !== 'POST')
                    @method($method)
                @endif

                <div class="form-grid">

                    <div class="form-group">
                        <label for="nama_ekstrakurikuler">Nama Ekstrakurikuler</label>
                        <input
                            type="text"
                            id="nama_ekstrakurikuler"
                            name="nama_ekstrakurikuler"
                            value="{{ old('nama_ekstrakurikuler', $item->nama_ekstrakurikuler) }}"
                            placeholder="Contoh: Futsal"
                            maxlength="255"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="ikon">Ikon</label>
                        <input
                            type="text"
                            id="ikon"
                            name="ikon"
                            value="{{ old('ikon', $item->ikon) }}"
                            placeholder="Contoh: ⚽"
                            maxlength="50">
                        <small class="hint">Gunakan emoji, misalnya ⚽ 🏸 💻.</small>
                    </div>

                    <div class="form-group full">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            placeholder="Masukkan deskripsi ekstrakurikuler"
                            required>{{ old('deskripsi', $item->deskripsi) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="pembina">Nama Pembina</label>
                        <input
                            type="text"
                            id="pembina"
                            name="pembina"
                            value="{{ old('pembina', $item->pembina) }}"
                            placeholder="Contoh: Bapak Ahmad"
                            maxlength="255">
                    </div>

                    <div class="form-group">
                        <label for="jadwal">Jadwal</label>
                        <input
                            type="text"
                            id="jadwal"
                            name="jadwal"
                            value="{{ old('jadwal', $item->jadwal) }}"
                            placeholder="Contoh: Senin, 15.00 - 17.00"
                            maxlength="255">
                    </div>

                    <div class="form-group full">
                        <label for="tempat">Tempat</label>
                        <input
                            type="text"
                            id="tempat"
                            name="tempat"
                            value="{{ old('tempat', $item->tempat) }}"
                            placeholder="Contoh: Lapangan Sekolah"
                            maxlength="255">
                    </div>

                </div>

                <div class="buttons">

                    <button type="submit" class="btn">
                        {{ $method === 'POST' ? '+ Simpan Ekstrakurikuler' : 'Simpan Perubahan' }}
                    </button>

                    <a href="{{ route('guru.ekstrakurikuler.index') }}"
                       class="btn btn-secondary">
                        ← Kembali
                    </a>

                </div>

            </form>

        </div>

    </section>

</main>

</body>
</html>
