
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #111827;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 270px;
            height: 100vh;
            background: #111827;
            color: white;
            padding: 25px 15px;
            overflow-y: auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo h2 {
            font-size: 23px;
        }

        .logo p {
            margin-top: 7px;
            color: #94a3b8;
            font-size: 14px;
        }

        .menu a {
            display: flex;
            align-items: center;
            color: #e5e7eb;
            text-decoration: none;
            padding: 14px 18px;
            margin-bottom: 8px;
            border-radius: 9px;
            font-size: 16px;
            transition: .2s;
        }

        .menu a:hover,
        .menu .active {
            background: #2563eb;
            color: white;
        }

        .menu-icon {
            width: 30px;
            font-size: 18px;
        }

        .badge {
            margin-left: auto;
            min-width: 24px;
            height: 24px;
            padding: 0 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
        }

        .content {
            margin-left: 270px;
            padding: 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .header h1 {
            font-size: 34px;
            margin-bottom: 8px;
        }

        .header p {
            color: #64748b;
            font-size: 17px;
        }

        .add-btn {
            background: #2563eb;
            color: white;
            padding: 13px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            white-space: nowrap;
        }

        .add-btn:hover,
        .kelola:hover {
            background: #1d4ed8;
        }

        .dashboard-btn {
            display: inline-block;
            background: #111827;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .dashboard-btn:hover {
            background: #1f2937;
        }

        .stats {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 22px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
            color: #64748b;
        }

        .stats strong {
            color: #2563eb;
            font-size: 25px;
            margin: 0 5px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 27px;
            min-height: 245px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .07);
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 9px 22px rgba(0, 0, 0, .10);
        }

        .icon {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 22px;
            margin-bottom: 12px;
            overflow-wrap: anywhere;
        }

        .card p {
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 8px;
            overflow-wrap: anywhere;
        }

        .kelola {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .empty {
            background: white;
            padding: 35px;
            border-radius: 12px;
            color: #64748b;
            text-align: center;
            grid-column: 1 / -1;
        }

        .empty h3 {
            color: #111827;
            margin-bottom: 10px;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error-message ul {
            margin: 8px 0 0 20px;
        }

        @media(max-width: 1100px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 25px 18px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header h1 {
                font-size: 28px;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">

        <div class="logo">
            <h2>ADMIN PANEL</h2>
            <p>Sistem Ekstrakurikuler</p>
        </div>

        <div class="menu">

            <a href="{{ route('dashboard.admin') }}">
                <span class="menu-icon"><i class="fa-solid fa-house"></i></span>
                Dashboard
            </a>

            <a href="{{ route('admin.ekstrakurikuler') }}" class="active">
                <span class="menu-icon"><i class="fa-solid fa-futbol"></i></span>
                Ekstrakurikuler
            </a>

            <a href="{{ route('admin.penilaian') }}">
                <span class="menu-icon"><i class="fa-solid fa-star"></i></span>
                Penilaian
            </a>

            <a href="{{ route('admin.laporan') }}">
                <span class="menu-icon"><i class="fa-solid fa-file-lines"></i></span>
                Laporan
            </a>

            <a href="{{ route('admin.profil') }}">
                <span class="menu-icon"><i class="fa-solid fa-user"></i></span>
                Profil
            </a>

            <a href="{{ route('admin.password.requests') }}">
                <span class="menu-icon"><i class="fa-solid fa-bell"></i></span>

                <span>Permintaan Password</span>

                @php
                    $jumlahPermintaan = \App\Models\PasswordRequest::where(
                        'status',
                        'menunggu'
                    )->count();
                @endphp

                @if($jumlahPermintaan > 0)
                    <span class="badge">{{ $jumlahPermintaan }}</span>
                @endif
            </a>

            <a href="{{ route('logout') }}">
                <span class="menu-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                Logout
            </a>

        </div>
    </div>

    <div class="content">

        <div class="header">
            <div>
                <h1>Ekstrakurikuler</h1>
                <p>Kelola data ekstrakurikuler sekolah</p>
            </div>

            <a href="{{ route('admin.ekstrakurikuler.create') }}" class="add-btn">
                + Tambah Ekskul
            </a>
        </div>

        <a href="{{ route('dashboard.admin') }}" class="dashboard-btn">
            ← Dashboard
        </a>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="stats">
            Total Ekstrakurikuler:
            <strong>{{ count($ekskul) }}</strong>
            kegiatan terdaftar
        </div>

        <div class="grid">

            @forelse($ekskul as $item)

                <div class="card">

                    <div class="icon">
                        @include('partials.ekskul-icon', ['ikon' => $item['ikon'] ?? $item['icon'] ?? null, 'nama' => $item['nama'] ?? ''])
                    </div>

                    <h2>
                        {{ $item['nama'] ?? 'Tanpa Nama' }}
                    </h2>

                    <p>
                        {{ $item['deskripsi'] ?? 'Belum ada deskripsi.' }}
                    </p>

                    @if(!empty($item['pembina']))
                        <p>
                            <strong>Pembina:</strong>
                            {{ $item['pembina'] }}
                        </p>
                    @endif

                    @if(!empty($item['jadwal']))
                        <p>
                            <strong>Jadwal:</strong>
                            {{ $item['jadwal'] }}
                        </p>
                    @endif

                    @if(!empty($item['tempat']))
                        <p>
                            <strong>Tempat:</strong>
                            {{ $item['tempat'] }}
                        </p>
                    @endif

                    <a href="{{ route('admin.ekstrakurikuler.show', $item['id']) }}"
                       class="kelola">
                        Kelola
                    </a>

                </div>

            @empty

                <div class="empty">
                    <h3>Belum Ada Data Ekstrakurikuler</h3>
                    <p>Silakan klik tombol Tambah Ekskul untuk menambahkan data.</p>
                </div>

            @endforelse

        </div>

    </div>

</body>
</html>
