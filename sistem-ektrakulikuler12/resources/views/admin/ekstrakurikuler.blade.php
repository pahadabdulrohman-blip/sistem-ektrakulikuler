<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ekstrakurikuler Admin</title>

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

        /* =========================
           SIDEBAR
        ========================= */

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

        /* MENU */

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

        /* ICON */

        .menu-icon {
            width: 30px;
            font-size: 18px;
        }

        /* BADGE PERMINTAAN PASSWORD */

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


        /* =========================
           CONTENT
        ========================= */

        .content {
            margin-left: 270px;
            padding: 35px;
        }


        /* =========================
           HEADER
        ========================= */

        .header {
            display: flex;

            justify-content: space-between;
            align-items: center;

            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 34px;
            margin-bottom: 8px;
        }

        .header p {
            color: #64748b;
            font-size: 17px;
        }


        /* =========================
           TAMBAH EKSKUL
        ========================= */

        .add-btn {
            background: #2563eb;
            color: white;

            padding: 13px 20px;

            text-decoration: none;

            border-radius: 8px;

            font-weight: bold;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }


        /* =========================
           DASHBOARD BUTTON
        ========================= */

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


        /* =========================
           GRID
        ========================= */

        .grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 22px;
        }


        /* =========================
           CARD
        ========================= */

        .card {
            background: white;

            border-radius: 15px;

            padding: 27px;

            min-height: 245px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, .07);
        }

        .icon {
            font-size: 42px;

            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 22px;

            margin-bottom: 8px;
        }

        .card p {
            color: #64748b;

            line-height: 1.5;

            min-height: 45px;
        }


        /* =========================
           KELOLA
        ========================= */

        .kelola {
            display: inline-block;

            background: #2563eb;
            color: white;

            text-decoration: none;

            padding: 10px 18px;

            border-radius: 8px;

            margin-top: 20px;
        }

        .kelola:hover {
            background: #1d4ed8;
        }


        /* =========================
           TABLET
        ========================= */

        @media(max-width: 1000px) {

            .grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

        }


        /* =========================
           MOBILE
        ========================= */

        @media(max-width: 700px) {

            .sidebar {
                position: relative;

                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;

                padding: 25px;
            }

            .header {
                flex-direction: column;

                align-items: flex-start;

                gap: 20px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     SIDEBAR ADMIN
===================================================== -->

<div class="sidebar">


    <!-- LOGO -->

    <div class="logo">

        <h2>
            ADMIN PANEL
        </h2>

        <p>
            Sistem Ekstrakurikuler
        </p>

    </div>


    <!-- MENU -->

    <div class="menu">


        <!-- DASHBOARD -->

        <a href="{{ route('dashboard.admin') }}">

            <span class="menu-icon">
                🏠
            </span>

            Dashboard

        </a>


        <!-- EKSTRAKURIKULER -->

        <a
            href="{{ route('admin.ekstrakurikuler') }}"
            class="active"
        >

            <span class="menu-icon">
                ⚽
            </span>

            Ekstrakurikuler

        </a>


        <!-- PENILAIAN -->

        <a href="{{ route('admin.penilaian') }}">

            <span class="menu-icon">
                ⭐
            </span>

            Penilaian

        </a>


        <!-- LAPORAN -->

        <a href="{{ route('admin.laporan') }}">

            <span class="menu-icon">
                📄
            </span>

            Laporan

        </a>


        <!-- PROFIL -->

        <a href="{{ route('admin.profil') }}">

            <span class="menu-icon">
                👤
            </span>

            Profil

        </a>


        <!-- =================================================
             PERMINTAAN PASSWORD
        ================================================== -->

        <a href="{{route('admin.password.requests') }}">

            <span class="menu-icon">
                🔔
            </span>

            <span>
                Permintaan Password
            </span>


            @php

                $jumlahPermintaan =
                    \App\Models\PasswordRequest::where(
                        'status',
                        'menunggu'
                    )->count();

            @endphp


            @if($jumlahPermintaan > 0)

                <span class="badge">
                    {{ $jumlahPermintaan }}
                </span>

            @endif

        </a>


        <!-- LOGOUT -->

        <a href="{{ route('logout') }}">

            <span class="menu-icon">
                🚪
            </span>

            Logout

        </a>


    </div>

</div>



<!-- =====================================================
     CONTENT
===================================================== -->

<div class="content">


    <!-- HEADER -->

    <div class="header">


        <div>

            <h1>
                Ekstrakurikuler
            </h1>

            <p>
                Kelola data ekstrakurikuler sekolah
            </p>

        </div>


        <!-- TAMBAH EKSKUL -->

        <a
            href="{{ route('admin.ekstrakurikuler.create') }}"
            class="add-btn"
        >

            + Tambah Ekskul

        </a>


    </div>



    <!-- DASHBOARD -->

    <a
        href="{{ route('dashboard.admin') }}"
        class="dashboard-btn"
    >

        ← Dashboard

    </a>



    <!-- =================================================
         DATA EKSKUL
    ================================================== -->

    <div class="grid">


        <!-- FUTSAL -->

        <div class="card">

            <div class="icon">
                ⚽
            </div>

            <h2>
                Futsal
            </h2>

            <p>
                Ekstrakurikuler olahraga futsal.
            </p>

            <a
                href="{{ route('admin.ekstrakurikuler.show', 1) }}"
                class="kelola"
            >

                Kelola

            </a>

        </div>



        <!-- CODING -->

        <div class="card">

            <div class="icon">
                💻
            </div>

            <h2>
                Coding
            </h2>

            <p>
                Ekstrakurikuler pemrograman dan teknologi.
            </p>

            <a
                href="{{ route('admin.ekstrakurikuler.show', 2) }}"
                class="kelola"
            >

                Kelola

            </a>

        </div>



        <!-- BASKET -->

        <div class="card">

            <div class="icon">
                🏀
            </div>

            <h2>
                Basket
            </h2>

            <p>
                Ekstrakurikuler olahraga basket.
            </p>

            <a
                href="{{ route('admin.ekstrakurikuler.show', 3) }}"
                class="kelola"
            >

                Kelola

            </a>

        </div>



        <!-- PENCAK SILAT -->

        <div class="card">

            <div class="icon">
                🥋
            </div>

            <h2>
                Pencak Silat
            </h2>

            <p>
                Ekstrakurikuler bela diri.
            </p>

            <a
                href="{{ route('admin.ekstrakurikuler.show', 4) }}"
                class="kelola"
            >

                Kelola

            </a>

        </div>



        <!-- PRAMUKA -->

        <div class="card">

            <div class="icon">
                🏕️
            </div>

            <h2>
                Pramuka
            </h2>

            <p>
                Ekstrakurikuler kepramukaan.
            </p>

            <a
                href="{{ route('admin.ekstrakurikuler.show', 5) }}"
                class="kelola"
            >

                Kelola

            </a>

        </div>



        <!-- VOLI -->

        <div class="card">

            <div class="icon">
                🏐
            </div>

            <h2>
                Voli
            </h2>

            <p>
                Ekstrakurikuler olahraga voli.
            </p>

            <a
                href="{{ route('admin.ekstrakurikuler.show', 6) }}"
                class="kelola"
            >

                Kelola

            </a>

        </div>


    </div>


</div>


</body>
</html>