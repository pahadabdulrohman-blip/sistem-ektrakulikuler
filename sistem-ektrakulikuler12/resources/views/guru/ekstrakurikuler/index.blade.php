
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler Guru | AKTIVIA</title>

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

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .heading h1 {
            font-size: 30px;
            color: #075985;
        }

        .heading p {
            color: #648ba4;
            font-size: 14px;
            margin-top: 5px;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            color: white;
            background: #0788bd;
            text-decoration: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            transition: .2s;
        }

        .btn:hover {
            background: #056b99;
            transform: translateY(-1px);
        }

        .btn-edit {
            background: #e69a18;
        }

        .btn-edit:hover {
            background: #c47e08;
        }

        .btn-delete {
            background: #dc4545;
        }

        .btn-delete:hover {
            background: #b92e2e;
        }

        .alert {
            padding: 14px 18px;
            background: #d8f7e6;
            color: #176b3b;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-error {
            background: #ffe1e1;
            color: #a32323;
        }

        .table-box {
            background: white;
            border-radius: 16px;
            padding: 22px;
            overflow-x: auto;
            box-shadow: 0 5px 20px #07598512;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th,
        td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #e5eff5;
            font-size: 13px;
        }

        th {
            color: #075985;
            background: #eff8fd;
            white-space: nowrap;
        }

        td {
            color: #52758b;
            vertical-align: middle;
        }

        td strong {
            color: #075985;
        }

        td small {
            display: inline-block;
            margin-top: 5px;
            color: #7894a6;
            max-width: 230px;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #7894a6;
        }

        .total-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 18px 22px;
            border-radius: 14px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px #0759850d;
        }

        .total-box span {
            color: #648ba4;
            font-size: 13px;
        }

        .total-box strong {
            font-size: 23px;
            color: #0788bd;
        }

        @media(max-width: 800px) {
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
                gap: 12px;
            }

            .topbar h2 {
                font-size: 17px;
            }

            .user {
                font-size: 12px;
            }

            .content {
                padding: 18px;
            }

            .heading {
                align-items: flex-start;
                flex-direction: column;
                margin-bottom: 18px;
            }

            .heading h1 {
                font-size: 24px;
            }

            .heading .btn {
                width: 100%;
                text-align: center;
            }

            .table-box {
                padding: 16px;
            }

            table {
                min-width: 720px;
            }

            .total-box {
                padding: 15px 18px;
            }
        }

        @media(max-width: 480px) {
            .topbar {
                padding: 14px;
            }

            .content {
                padding: 12px;
            }

            .heading h1 {
                font-size: 21px;
            }

            .table-box {
                padding: 12px;
                border-radius: 13px;
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

        <h2>Daftar Ekstrakurikuler</h2>

        <div class="user">
            <strong>{{ session('username', 'Guru') }}</strong>
            <br>
            Guru
        </div>

    </header>

    <section class="content">

        <div class="heading">

            <div>
                <h1>Ekstrakurikuler</h1>
                <p>Kelola data kegiatan ekstrakurikuler sekolah.</p>
            </div>

            <a href="{{ route('guru.ekstrakurikuler.create') }}" class="btn">
                + Tambah Ekstrakurikuler
            </a>

        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="total-box">
            <span>Total Ekstrakurikuler Terdaftar</span>
            <strong>{{ $ekskul->count() }}</strong>
        </div>

        <div class="table-box">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ekstrakurikuler</th>
                        <th>Pembina</th>
                        <th>Jadwal</th>
                        <th>Tempat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($ekskul as $index => $item)

                        <tr>

                            <td>{{ $index + 1 }}</td>

                            <td>
                                {{ $item->ikon ?? '📌' }}
                                <strong>
                                    {{ $item->nama_ekstrakurikuler }}
                                </strong>
                                <br>
                                <small>
                                    {{ $item->deskripsi }}
                                </small>
                            </td>

                            <td>
                                {{ $item->pembina ?: 'Belum ditentukan' }}
                            </td>

                            <td>
                                {{ $item->jadwal ?: 'Belum ditentukan' }}
                            </td>

                            <td>
                                {{ $item->tempat ?: 'Belum ditentukan' }}
                            </td>

                            <td>
                                <div class="actions">

                                    <a href="{{ route('guru.ekstrakurikuler.edit', $item->id) }}"
                                       class="btn btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('guru.ekstrakurikuler.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus ekstrakurikuler ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-delete">
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada data ekstrakurikuler.
                                <br><br>
                                Silakan klik tombol Tambah Ekstrakurikuler.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</main>

</body>
</html>
