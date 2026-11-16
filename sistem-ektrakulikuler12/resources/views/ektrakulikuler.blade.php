<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ekstrakurikuler Admin</title>

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
            color: #222;
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
            font-size: 12px;
            color: #9ca3af;
            margin-top: 5px;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: #d1d5db;
            padding: 14px 15px;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 7px;
        }

        .header p {
            color: #6b7280;
        }

        .add-btn {
            background: #2563eb;
            color: white;
            padding: 12px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: bold;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
        }

        .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 21px;
            margin-bottom: 8px;
        }

        .card p {
            color: #6b7280;
            min-height: 42px;
            margin-bottom: 18px;
        }

        .buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 7px;
            text-decoration: none;
            color: white;
            font-size: 13px;
        }

        .kelola {
            background: #2563eb;
        }

        .edit {
            background: #f59e0b;
        }

        .hapus {
            background: #dc2626;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .empty {
            grid-column: 1 / -1;
            background: white;
            padding: 50px;
            text-align: center;
            border-radius: 15px;
            color: #6b7280;
        }

        @media(max-width: 900px) {
            .cards {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width: 650px) {
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
            }

            .content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .header {
                align-items: flex-start;
                gap: 15px;
                flex-direction: column;
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
            <i class="fa-solid fa-house"></i>Dashboard
        </a>

        <a href="{{ route('admin.ekstrakurikuler') }}" class="active">
            <i class="fa-solid fa-futbol"></i>Ekstrakurikuler
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

        <div>
            <h1>Ekstrakurikuler</h1>
            <p>Kelola data ekstrakurikuler sekolah</p>
        </div>

        <a href="{{ route('admin.ekstrakurikuler.create') }}"
           class="add-btn">
            <i class="fa-solid fa-plus"></i> Tambah Ekstrakurikuler
        </a>

    </div>


    @if(session('success'))
        <div class="success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif


    <div class="cards">

        @forelse($ekstrakurikuler as $item)

            <div class="card">

                <div class="icon">
                    @include('partials.ekskul-icon', ['ikon' => $item->ikon, 'nama' => $item->nama])
                </div>

                <h3>
                    {{ $item->nama }}
                </h3>

                <p>
                    {{ $item->deskripsi }}
                </p>

                <div class="buttons">

                    <a href="{{ route('admin.ekstrakurikuler.show', $item->id) }}"
                       class="btn kelola">
                        Kelola
                    </a>

                    <a href="{{ route('admin.ekstrakurikuler.edit', $item->id) }}"
                       class="btn edit">
                        Edit
                    </a>

                    <form action="{{ route('admin.ekstrakurikuler.destroy', $item->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus ekstrakurikuler ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn hapus">
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="empty">
                <h3>Belum ada ekstrakurikuler</h3>
                <p>Silakan klik tombol Tambah Ekstrakurikuler.</p>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>