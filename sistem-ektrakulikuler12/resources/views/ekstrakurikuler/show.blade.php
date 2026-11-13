<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $ekskul['nama'] }} - Admin</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #111827;
        }

        .sidebar {
            position: fixed;
            width: 260px;
            height: 100vh;
            background: #111827;
            color: white;
            padding: 30px 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sidebar p {
            text-align: center;
            color: #94a3b8;
            margin-bottom: 50px;
        }

        .menu {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .menu:hover {
            background: #2563eb;
        }

        .content {
            margin-left: 260px;
            padding: 40px;
        }

        .back {
            display: inline-block;
            background: #111827;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 40px;
            max-width: 700px;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .icon {
            font-size: 70px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 35px;
            margin-bottom: 10px;
        }

        .description {
            color: #64748b;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            background: #2563eb;
            margin-right: 10px;
        }

        .btn-edit {
            background: #f59e0b;
        }

        .btn-delete {
            background: #dc2626;
            border: none;
            padding: 12px 20px;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .content {
                padding: 30px 24px;
            }

            .card {
                padding: 32px;
            }

            h1 {
                font-size: 31px;
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
                display: flex;
                align-items: center;
                gap: 6px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
                box-shadow: 0 6px 18px rgba(0, 0, 0, .2);
            }

            .sidebar h2,
            .sidebar p {
                display: none;
            }

            .menu {
                flex: 0 0 auto;
                margin: 0;
                padding: 9px 12px;
                font-size: 12px;
                white-space: nowrap;
                border-radius: 8px;
            }

            .content {
                margin-left: 0;
                padding: 18px;
            }

            .card {
                padding: 24px;
                border-radius: 16px;
            }

            h1 {
                font-size: 27px;
            }

            .description {
                font-size: 16px;
                margin-bottom: 22px;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 12px;
            }

            .card {
                padding: 18px;
            }

            .icon {
                font-size: 52px;
                margin-bottom: 14px;
            }

            h1 {
                font-size: 23px;
            }

            .btn,
            .btn-delete {
                display: block;
                width: 100%;
                text-align: center;
                margin: 0 0 10px;
            }

            .card form {
                display: block !important;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">

    <h2>ADMIN PANEL</h2>

    <p>Sistem Ekstrakurikuler</p>

    <a href="{{ route('dashboard.admin') }}" class="menu">
        🏠 Dashboard
    </a>

    <a href="{{ route('admin.ekstrakurikuler') }}" class="menu">
        ⚽ Ekstrakurikuler
    </a>

    <a href="{{ route('admin.penilaian') }}" class="menu">
        ⭐ Penilaian
    </a>

    <a href="{{ route('admin.laporan') }}" class="menu">
        📄 Laporan
    </a>

    <a href="{{ route('admin.profil') }}" class="menu">
        👤 Profil
    </a>

</div>


<div class="content">

    <a href="{{ route('admin.ekstrakurikuler') }}" class="back">
        ← Kembali
    </a>

    <div class="card">

        <div class="icon">
            {{ $ekskul['icon'] }}
        </div>

        <h1>
            {{ $ekskul['nama'] }}
        </h1>

        <p class="description">
            {{ $ekskul['deskripsi'] }}
        </p>

        <a
            href="{{ route('admin.ekstrakurikuler.edit', $ekskul['id']) }}"
            class="btn btn-edit"
        >
            ✏️ Edit
        </a>

        <form
            action="{{ route('admin.ekstrakurikuler.destroy', $ekskul['id']) }}"
            method="POST"
            style="display:inline;"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn-delete"
                onclick="return confirm('Yakin ingin menghapus ekstrakurikuler ini?')"
            >
                🗑 Hapus
            </button>

        </form>

    </div>

</div>

</body>
</html>