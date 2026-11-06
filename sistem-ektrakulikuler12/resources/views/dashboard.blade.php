<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Sistem Ekstrakurikuler</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #edf7fc;
            color: #074b70;
        }

        /* =========================
           LAYOUT
        ========================= */

        .app {
            min-height: 100vh;
            display: flex;
        }

        /* =========================
           SIDEBAR DESKTOP
        ========================= */

        .sidebar {
            width: 250px;
            min-height: 100vh;

            background: linear-gradient(
                180deg,
                #087bb2,
                #07577e
            );

            color: white;

            padding: 25px 18px;

            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 10px 12px 30px;

            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .brand-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background: rgba(255,255,255,0.16);

            font-size: 21px;
        }

        .brand h2 {
            font-size: 17px;
            line-height: 1.3;
        }

        .menu {
            margin-top: 25px;
        }

        .menu-title {
            padding: 0 12px;
            margin-bottom: 10px;

            font-size: 11px;
            opacity: 0.65;

            text-transform: uppercase;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 14px;

            padding: 13px 14px;

            margin-bottom: 6px;

            border-radius: 11px;

            color: white;
            text-decoration: none;

            font-size: 13px;

            transition: .25s;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,0.16);
        }

        .menu a i {
            width: 20px;
            text-align: center;
        }

        /* =========================
           MAIN
        ========================= */

        .main {
            width: calc(100% - 250px);
            margin-left: 250px;
            min-height: 100vh;
        }

        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            height: 75px;

            background: white;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 35px;

            border-bottom: 1px solid #e2edf2;

            position: sticky;
            top: 0;
            z-index: 10;
        }

        .page-title h1 {
            font-size: 20px;
            color: #07577e;
        }

        .page-title p {
            font-size: 11px;
            color: #8a9ba4;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-info {
            text-align: right;
        }

        .profile-info strong {
            display: block;
            font-size: 13px;
            color: #07577e;
        }

        .profile-info span {
            font-size: 10px;
            color: #8b9aa2;
        }

        .profile-icon {
            width: 42px;
            height: 42px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #e5f5fc;

            color: #087bb2;

            font-size: 19px;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            padding: 35px;
            max-width: 1400px;
            margin: auto;
        }

        .welcome {
            margin-bottom: 28px;
        }

        .welcome p {
            color: #678795;
            font-size: 17px;
        }

        .welcome h2 {
            font-size: 32px;
            color: #07577e;
            margin: 3px 0;
        }

        .welcome span {
            color: #5c8497;
            font-size: 14px;
        }

        /* =========================
           STAT CARD
        ========================= */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 35px;
        }

        .stat-card {
            background: white;

            border-radius: 18px;

            padding: 22px;

            display: flex;
            align-items: center;

            gap: 17px;

            border: 1px solid #dcecf4;

            box-shadow: 0 5px 18px rgba(0,70,100,0.06);

            transition: .25s;
        }

        .stat-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 12px 25px rgba(0,70,100,0.10);
        }

        .stat-icon {
            width: 58px;
            height: 58px;

            flex-shrink: 0;

            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #e3f4fc;

            color: #07618d;

            font-size: 23px;
        }

        .stat-card h3 {
            color: #07577e;
            font-size: 25px;
        }

        .stat-card p {
            color: #72909e;
            font-size: 12px;
        }

        /* =========================
           SECTION
        ========================= */

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 18px;
        }

        .section-header h2 {
            color: #07577e;
            font-size: 21px;
        }

        .section-header a {
            color: #087bb2;
            font-size: 13px;
            text-decoration: none;
        }

        /* =========================
           EXTRACURRICULAR GRID
        ========================= */

        .ekskul-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;
        }

        .ekskul-card {
            background: white;

            border: 1px solid #d7e9f1;

            border-radius: 18px;

            padding: 20px;

            display: flex;
            align-items: center;

            gap: 17px;

            text-decoration: none;

            transition: .25s;

            position: relative;
            overflow: hidden;
        }

        .ekskul-card:hover {
            transform: translateY(-4px);

            border-color: #76bfdc;

            box-shadow:
                0 12px 25px rgba(0,90,130,0.10);
        }

        .ekskul-icon {
            width: 62px;
            height: 62px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #e6f4fa;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #07618d;

            font-size: 25px;
        }

        .ekskul-info {
            flex: 1;
        }

        .ekskul-info h3 {
            color: #07577e;
            font-size: 17px;
            margin-bottom: 3px;
        }

        .ekskul-info p {
            color: #71909e;
            font-size: 12px;
        }

        .arrow {
            color: #087bb2;
            font-size: 18px;
        }

        /* =========================
           MOBILE TOPBAR
        ========================= */

        .mobile-menu {
            display: none;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .ekskul-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }
        }

        @media (max-width: 750px) {

            .sidebar {
                display: none;
            }

            .main {
                width: 100%;
                margin-left: 0;
            }

            .topbar {
                height: 62px;
                padding: 0 18px;

                background: #087bb2;
                color: white;
            }

            .mobile-menu {
                display: block;

                font-size: 22px;
                color: white;
            }

            .page-title h1 {
                color: white;
                font-size: 17px;
            }

            .page-title p {
                display: none;
            }

            .profile-info {
                display: none;
            }

            .profile-icon {
                background: white;
                color: #087bb2;
            }

            .content {
                padding: 30px 20px;
            }

            .welcome h2 {
                font-size: 28px;
            }

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);

                gap: 14px;
            }

            .stat-card {
                padding: 17px;

                flex-direction: column;

                text-align: center;
            }

            .ekskul-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 430px) {

            .stats {
                grid-template-columns: 1fr 1fr;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
            }

            .stat-card h3 {
                font-size: 22px;
            }

            .welcome h2 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">

            <div class="brand-icon">
                <i class="fa-solid fa-school"></i>
            </div>

            <h2>
                Sistem<br>
                Ekstrakurikuler
            </h2>

        </div>

        <div class="menu">

            <div class="menu-title">
                Menu Utama
            </div>

            <a href="{{ route('dashboard') }}" class="active">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>

            <a href="{{ route('ekstrakurikuler') }}">
                <i class="fa-solid fa-people-group"></i>
                Ekstrakurikuler
            </a>

            <a href="{{ route('penilaian') }}">
                <i class="fa-solid fa-star"></i>
                Penilaian
            </a>

            <a href="{{ route('laporan') }}">
                <i class="fa-solid fa-file-lines"></i>
                Laporan
            </a>

            <a href="{{ route('profil') }}">
                <i class="fa-solid fa-user"></i>
                Profil
            </a>

        </div>

    </aside>


    <!-- MAIN -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="mobile-menu">
                <i class="fa-solid fa-bars"></i>
            </div>

            <div class="page-title">

                <h1>
                    Sistem Ekstrakurikuler
                </h1>

                <p>
                    Dashboard siswa
                </p>

            </div>

            <div class="profile">

                <div class="profile-info">

                    <strong>
                        Fahad Abdul Rohman
                    </strong>

                    <span>
                        Siswa - XI RPL 1
                    </span>

                </div>

                <div class="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

            </div>

        </header>


        <!-- CONTENT -->
        <div class="content">

            <!-- WELCOME -->
            <section class="welcome">

                <p>
                    Selamat Datang,
                </p>

                <h2>
                    Fahad Abdul Rohman
                </h2>

                <span>
                    Siswa - XI RPL 1
                </span>

            </section>


            <!-- STATISTICS -->
            <section class="stats">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="fa-solid fa-people-group"></i>
                    </div>

                    <div>
                        <h3>12</h3>
                        <p>Ekstrakurikuler</p>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="fa-solid fa-user-check"></i>
                    </div>

                    <div>
                        <h3>8</h3>
                        <p>Peserta Aktif</p>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <div>
                        <h3>86</h3>
                        <p>Nilai Rata-rata</p>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>

                    <div>
                        <h3>5</h3>
                        <p>Kegiatan Aktif</p>
                    </div>

                </div>

            </section>


            <!-- EKSTRAKURIKULER -->
            <section>

                <div class="section-header">

                    <h2>
                        Ekstrakurikuler Terdaftar
                    </h2>

                    <a href="{{ route('ekstrakurikuler') }}">
                        Lihat Semua
                    </a>

                </div>


                <div class="ekskul-grid">


                    <!-- FUTSAL -->
                    <a
                        href="{{ url('/ekstrakurikuler/1') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-futbol"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Futsal</h3>
                            <p>Olahraga</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- SENI -->
                    <a
                        href="{{ url('/ekstrakurikuler/2') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-palette"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Seni</h3>
                            <p>Seni & Budaya</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- CODING -->
                    <a
                        href="{{ url('/ekstrakurikuler/3') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-code"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Coding</h3>
                            <p>Teknologi</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- PENCAK SILAT -->
                    <a
                        href="{{ url('/ekstrakurikuler/4') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-hand-fist"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Pencak Silat</h3>
                            <p>Olahraga</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- BASKET -->
                    <a
                        href="{{ url('/ekstrakurikuler/5') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-basketball"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Basket</h3>
                            <p>Olahraga</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- VOLI -->
                    <a
                        href="{{ url('/ekstrakurikuler/6') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-volleyball"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Voli</h3>
                            <p>Olahraga</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- PRAMUKA -->
                    <a
                        href="{{ url('/ekstrakurikuler/7') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-campground"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Pramuka</h3>
                            <p>Organisasi</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- PMR -->
                    <a
                        href="{{ url('/ekstrakurikuler/8') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-kit-medical"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>PMR</h3>
                            <p>Kesehatan</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                    <!-- ROHIS -->
                    <a
                        href="{{ url('/ekstrakurikuler/9') }}"
                        class="ekskul-card"
                    >

                        <div class="ekskul-icon">
                            <i class="fa-solid fa-book-quran"></i>
                        </div>

                        <div class="ekskul-info">
                            <h3>Rohis</h3>
                            <p>Keagamaan</p>
                        </div>

                        <div class="arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                    </a>


                </div>

            </section>

        </div>

    </main>

</div>

</body>
</html>