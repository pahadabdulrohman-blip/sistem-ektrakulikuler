
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Siswa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #f4f7fb;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 300px;
    height: 100vh;
    background: linear-gradient(180deg, #0d6efd, #084298);
    color: white;
    padding: 25px 15px;
    z-index: 1000;
}

.logo {
    text-align: center;
    margin-bottom: 48px;
}

.logo i {
    font-size: 43px;
    margin-bottom: 8px;
}

.logo h2 {
    font-size: 30px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* MENU */
.menu a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px 16px;
    margin-bottom: 8px;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-size: 19px;
    font-weight: 500;
    transition: .3s;
}

.menu a i {
    width: 25px;
    text-align: center;
    font-size: 21px;
}

.menu a:hover,
.menu a.active {
    background: rgba(255,255,255,.20);
}

/* CONTENT */
.content {
    margin-left: 300px;
    padding: 35px;
}

.header {
    background: white;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 25px;
}

.header h1 {
    color: #172554;
}

.header p {
    color: #777;
}

/* CARDS */
.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,.05);
}

.stat {
    display: flex;
    align-items: center;
    gap: 15px;
}

.icon {
    width: 55px;
    height: 55px;
    background: #e7f0ff;
    color: #0d6efd;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.stat h2 {
    color: #172554;
}

.stat p {
    color: #777;
    font-size: 13px;
}

/* GRID */
.grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.item {
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.item strong {
    color: #172554;
}

.item small {
    display: block;
    color: #777;
    margin-top: 5px;
}

.empty-ekskul {
    color: #777;
    font-size: 14px;
    line-height: 1.6;
    padding: 10px 0;
}

.empty-ekskul a {
    color: #0d6efd;
    font-weight: 600;
    text-decoration: none;
}

.empty-ekskul a:hover {
    text-decoration: underline;
}

/* RESPONSIVE */
@media(max-width:1100px) {
    .cards {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width:600px) {
    .sidebar {
        width: 100%;
        height: auto;
        min-height: auto;
        position: relative;
    }

    .content {
        margin-left: 0;
        padding: 20px;
    }

    .cards {
        grid-template-columns: 1fr;
    }

    .logo {
        margin-bottom: 35px;
    }

    .menu a {
        font-size: 17px;
    }
}
</style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

@php
    $pilihanEkskul = \App\Models\PendaftaranEkstrakurikuler::with('ekstrakurikuler')
        ->where('username', session('username'))
        ->get()
        ->pluck('ekstrakurikuler')
        ->filter();

    $userSiswa = \App\Models\User::where('username', session('username'))->first();
    $namaSiswa = $userSiswa->name ?? session('username', 'Siswa');
    $kelasSiswa = $userSiswa->kelas_saat_ini ?? '-';
@endphp

<!-- SIDEBAR SISWA -->
<aside class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-graduation-cap"></i>
        <h2>SISWA</h2>
    </div>

    <div class="menu">

        <a href="{{ route('dashboard.siswa') }}" class="active">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('ekstrakurikuler') }}">
            <i class="fa-solid fa-users"></i>
            <span>Ekstrakurikuler</span>
        </a>

        <a href="{{ route('jadwal.ekstrakurikuler') }}">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Jadwal Kegiatan</span>
        </a>

        <a href="{{ route('penilaian') }}">
            <i class="fa-solid fa-star"></i>
            <span>Nilai Saya</span>
        </a>

        <a href="{{ route('profil') }}">
            <i class="fa-solid fa-user"></i>
            <span>Profil</span>
        </a>

        <a href="{{ route('login') }}">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>

    </div>

</aside>

<!-- KONTEN DASHBOARD -->
<main class="content">

    <div class="header">
        <h1>Dashboard Siswa</h1>
        <p>
            Selamat datang, {{ $namaSiswa }}
            &middot; Kelas {{ $kelasSiswa }}
        </p>
    </div>

    <div class="cards">

        <div class="card stat">
            <div class="icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h2>{{ $pilihanEkskul->count() }}</h2>
                <p>Ekstrakurikuler</p>
            </div>
        </div>

        <div class="card stat">
            <div class="icon">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <h2>87</h2>
                <p>Nilai Rata-rata</p>
            </div>
        </div>

        <div class="card stat">
            <div class="icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <h2>90%</h2>
                <p>Kehadiran</p>
            </div>
        </div>

        <div class="card stat">
            <div class="icon">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <div>
                <h2>Baik</h2>
                <p>Predikat</p>
            </div>
        </div>

    </div>

    <div class="grid">

        <div class="card">
            <h2>Ekstrakurikuler Saya</h2>

            @forelse ($pilihanEkskul as $ekskul)

                <div class="item">
                    <strong>{{ $ekskul->nama_ekstrakurikuler }}</strong>
                    <small>
                        {{ $ekskul->jadwal ?: 'Jadwal belum ditentukan' }}
                        @if ($ekskul->tempat)
                            &middot; {{ $ekskul->tempat }}
                        @endif
                    </small>
                </div>

            @empty

                <p class="empty-ekskul">
                    Kamu belum memilih ekstrakurikuler.
                    <a href="{{ route('ekstrakurikuler') }}">Pilih sekarang</a>.
                </p>

            @endforelse
        </div>

    </div>

</main>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
