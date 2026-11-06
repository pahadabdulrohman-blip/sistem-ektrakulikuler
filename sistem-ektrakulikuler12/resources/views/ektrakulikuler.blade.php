<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ekstrakurikuler Admin</title>

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
                width: 190px;
            }

            .content {
                margin-left: 190px;
                padding: 20px;
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
            🏠 Dashboard
        </a>

        <a href="{{ route('admin.ekstrakurikuler') }}" class="active">
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

        <div>
            <h1>Ekstrakurikuler</h1>
            <p>Kelola data ekstrakurikuler sekolah</p>
        </div>

        <a href="{{ route('admin.ekstrakurikuler.create') }}"
           class="add-btn">
            + Tambah Ekstrakurikuler
        </a>

    </div>


    @if(session('success'))
        <div class="success">
            ✓ {{ session('success') }}
        </div>
    @endif


    <div class="cards">

        @forelse($ekstrakurikuler as $item)

            <div class="card">

                <div class="icon">
                    {{ $item->ikon ?: '🏆' }}
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