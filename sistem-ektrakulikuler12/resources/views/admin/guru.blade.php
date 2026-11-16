<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Akun Guru - Admin</title>

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
            overflow-y: auto;
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
            gap: 12px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 7px;
        }

        .header p {
            color: #6b7280;
        }

        .back {
            text-decoration: none;
            background: #111827;
            color: white;
            padding: 11px 18px;
            border-radius: 8px;
            white-space: nowrap;
        }

        .message {
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
            margin-bottom: 25px;
            overflow-x: auto;
        }

        .card h2 {
            font-size: 19px;
            margin-bottom: 18px;
            color: #1f2937;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .full {
            grid-column: 1 / -1;
        }

        .btn {
            border: none;
            background: #2563eb;
            color: white;
            padding: 11px 18px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        tr:hover td {
            background: #f9fafb;
        }

        .aksi {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-small {
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 7px;
            font-family: inherit;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-reset {
            background: #0f766e;
        }

        .btn-reset:hover {
            background: #115e59;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-danger:hover {
            background: #991b1b;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 25px;
        }

        @media(max-width: 800px) {
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

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }

            h1 {
                font-size: 24px;
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

            <a href="{{ route('admin.penilaian') }}">
                <i class="fa-solid fa-star"></i>Penilaian
            </a>

            <a href="{{ route('admin.guru.index') }}" class="active">
                <i class="fa-solid fa-chalkboard-user"></i>Akun Guru
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
                <h1>Akun Guru</h1>
                <p>Buat dan kelola akun guru untuk login ke sistem.</p>
            </div>

            <a href="{{ route('dashboard.admin') }}" class="back">
                Kembali ke Dashboard
            </a>

        </div>

        @if (session('success'))
            <div class="message success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="message error">
                @foreach ($errors->all() as $error)
                    <div>
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <div class="card">

            <h2>Tambah Akun Guru</h2>

            <form action="{{ route('admin.guru.store') }}" method="POST">
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama guru"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Buat username guru"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@gmail.com"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Password Awal</label>
                        <input
                            type="text"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                    </div>

                    <div class="form-group full">
                        <button type="submit" class="btn">
                            <i class="fa-solid fa-user-plus"></i>
                            Buat Akun Guru
                        </button>
                    </div>

                </div>

            </form>

        </div>

        <div class="card">

            <h2>Daftar Akun Guru</h2>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($guru as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <div class="aksi">

                                    <button
                                        type="button"
                                        class="btn-small btn-reset"
                                        onclick="resetPassword({{ $item->id }}, @js($item->name))"
                                    >
                                        <i class="fa-solid fa-key"></i> Reset Password
                                    </button>

                                    <form
                                        action="{{ route('admin.guru.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus akun guru {{ $item->name }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-small btn-danger">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada akun guru. Silakan buat akun di form atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

    <form id="formReset" method="POST" hidden>
        @csrf
        @method('PUT')
        <input type="hidden" name="password" id="resetPasswordValue">
    </form>

    <script>
        function resetPassword(id, nama) {
            const sandi = prompt(
                'Password baru untuk ' + nama + ' (minimal 8 karakter):'
            );

            if (sandi === null) {
                return;
            }

            if (sandi.length < 8) {
                alert('Password minimal 8 karakter.');
                return;
            }

            const form = document.getElementById('formReset');
            form.action = "{{ url('/admin/guru') }}/" + id + "/reset-password";
            document.getElementById('resetPasswordValue').value = sandi;
            form.submit();
        }
    </script>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
