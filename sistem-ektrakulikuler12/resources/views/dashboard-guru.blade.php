<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Dashboard Guru</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100vh;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f6fa;
            color: #17202a;
        }


        /* =====================================
           SIDEBAR GURU
        ===================================== */

        .sidebar {
            position: fixed;

            left: 0;
            top: 0;
            bottom: 0;

            width: 270px;

            background: linear-gradient(
                180deg,
                #148f5a,
                #087847
            );

            color: white;

            padding: 30px 20px;

            z-index: 1000;
        }


        .guru-logo {
            text-align: center;

            padding-bottom: 30px;

            border-bottom:
                1px solid
                rgba(255,255,255,.2);
        }


        .guru-icon {
            width: 65px;
            height: 65px;

            margin: 0 auto 10px;

            border-radius: 18px;

            background:
                rgba(255,255,255,.15);

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 35px;
        }


        .guru-logo h2 {
            font-size: 24px;
            font-weight: 700;
        }


        .guru-logo p {
            font-size: 12px;
            opacity: .8;
            margin-top: 3px;
        }


        .menu-title {
            font-size: 11px;

            text-transform: uppercase;

            margin:
                30px 15px 12px;

            opacity: .7;
        }


        .menu a {
            display: flex;

            align-items: center;

            gap: 15px;

            color: white;

            text-decoration: none;

            padding:
                14px 16px;

            margin-bottom: 7px;

            border-radius: 11px;

            font-size: 14px;

            transition: .2s;
        }


        .menu a:hover,
        .menu a.active {
            background:
                rgba(255,255,255,.18);
        }


        .menu-icon {
            width: 24px;

            text-align: center;

            font-size: 18px;
        }


        /* =====================================
           MAIN GURU
        ===================================== */

        .main {
            margin-left: 270px;

            width:
                calc(100% - 270px);

            min-height: 100vh;

            padding: 35px 40px;
        }


        /* =====================================
           HEADER
        ===================================== */

        .header {
            background: white;

            border-radius: 18px;

            padding:
                28px 30px;

            margin-bottom: 28px;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,.05);

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        .header h1 {
            color: #116b43;

            font-size: 30px;

            margin-bottom: 5px;
        }


        .header p {
            color: #718096;

            font-size: 14px;
        }


        .guru-profile {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .guru-info {
            text-align: right;
        }


        .guru-info strong {
            display: block;

            color: #116b43;

            font-size: 14px;
        }


        .guru-info span {
            color: #718096;

            font-size: 11px;
        }


        .profile-icon {
            width: 48px;
            height: 48px;

            border-radius: 50%;

            background: #d9f7e7;

            color: #148f5a;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 23px;
        }


        /* =====================================
           STATISTIK
        ===================================== */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 20px;

            margin-bottom: 28px;
        }


        .stat-card {
            background: white;

            border-radius: 17px;

            padding: 25px;

            display: flex;

            align-items: center;

            gap: 17px;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,.05);
        }


        .stat-icon {
            width: 60px;
            height: 60px;

            flex-shrink: 0;

            border-radius: 15px;

            background: #d9f7e7;

            color: #148f5a;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 25px;
        }


        .stat-number {
            font-size: 25px;

            font-weight: 700;

            color: #116b43;
        }


        .stat-label {
            color: #718096;

            font-size: 12px;

            margin-top: 2px;
        }


        /* =====================================
           KEGIATAN
        ===================================== */

        .content-card {
            background: white;

            border-radius: 18px;

            padding: 28px;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,.05);
        }


        .content-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 22px;
        }


        .content-header h2 {
            color: #151b26;

            font-size: 22px;
        }


        .content-header p {
            color: #718096;

            font-size: 13px;

            margin-top: 4px;
        }


        .btn {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding:
                11px 18px;

            background: #148f5a;

            color: white;

            text-decoration: none;

            border-radius: 9px;

            font-size: 13px;

            font-weight: 600;
        }


        .btn:hover {
            background: #087847;
        }


        /* =====================================
           TABLE
        ===================================== */

        .table-wrapper {
            width: 100%;

            overflow-x: auto;
        }


        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 700px;
        }


        thead {
            background: #148f5a;

            color: white;
        }


        th {
            text-align: left;

            padding:
                15px;

            font-size: 13px;
        }


        td {
            padding:
                16px 15px;

            border-bottom:
                1px solid #e8edf1;

            font-size: 14px;
        }


        tbody tr:hover {
            background: #f7fbf9;
        }


        .status {
            display: inline-block;

            padding:
                6px 13px;

            border-radius: 20px;

            background: #d9f7e7;

            color: #148f5a;

            font-size: 11px;

            font-weight: 600;
        }


        /* =====================================
           QUICK MENU
        ===================================== */

        .quick-menu {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;

            margin-top: 25px;
        }


        .quick-card {
            padding: 22px;

            border:
                1px solid #e1e8ed;

            border-radius: 14px;

            text-decoration: none;

            color: #17202a;

            transition: .2s;
        }


        .quick-card:hover {
            border-color: #148f5a;

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 20px
                rgba(0,0,0,.06);
        }


        .quick-icon {
            font-size: 28px;

            margin-bottom: 12px;
        }


        .quick-card h3 {
            font-size: 15px;

            color: #116b43;

            margin-bottom: 5px;
        }


        .quick-card p {
            color: #718096;

            font-size: 12px;
        }

    </style>
</head>


<body>


<!-- =========================================
     SIDEBAR GURU
========================================= -->

<aside class="sidebar">

    <div class="guru-logo">

        <div class="guru-icon">
            👨‍🏫
        </div>

        <h2>
            GURU
        </h2>

        <p>
            Sistem Ekstrakurikuler
        </p>

    </div>


    <div class="menu-title">
        Menu Guru
    </div>


    <nav class="menu">

        <!-- HANYA DASHBOARD GURU -->

        <a
            href="{{ route('dashboard.guru') }}"
            class="active"
        >
            <span class="menu-icon">🏠</span>
            Dashboard Guru
        </a>


        <a href="#kegiatan">
            <span class="menu-icon">👥</span>
            Data Kegiatan
        </a>


        <a href="#penilaian">
            <span class="menu-icon">⭐</span>
            Penilaian Siswa
        </a>


        <a href="#laporan">
            <span class="menu-icon">📄</span>
            Laporan
        </a>


       <a href="{{ route('guru.profil') }}">
    👤 Profil Guru
</a>


        <a href="{{ route('login') }}">
            <span class="menu-icon">🚪</span>
            Logout
        </a>

    </nav>

</aside>



<!-- =========================================
     MAIN GURU
========================================= -->

<main class="main">


    <!-- HEADER -->

    <header class="header">

        <div>

            <h1>
                Dashboard Guru
            </h1>

            <p>
                Kelola kegiatan dan penilaian ekstrakurikuler siswa.
            </p>

        </div>


        <div class="guru-profile">

            <div class="guru-info">

                <strong>
                    Guru Pembimbing
                </strong>

                <span>
                    Sistem Ekstrakurikuler
                </span>

            </div>


            <div class="profile-icon">
                👨‍🏫
            </div>

        </div>

    </header>



    <!-- =====================================
         STATISTIK GURU
    ===================================== -->

    <section class="stats">


        <div class="stat-card">

            <div class="stat-icon">
                👨‍🎓
            </div>

            <div>

                <div class="stat-number">
                    120
                </div>

                <div class="stat-label">
                    Total Siswa
                </div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon">
                👥
            </div>

            <div>

                <div class="stat-number">
                    9
                </div>

                <div class="stat-label">
                    Ekstrakurikuler
                </div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon">
                ⭐
            </div>

            <div>

                <div class="stat-number">
                    87
                </div>

                <div class="stat-label">
                    Rata-rata Nilai
                </div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon">
                📅
            </div>

            <div>

                <div class="stat-number">
                    92%
                </div>

                <div class="stat-label">
                    Kehadiran
                </div>

            </div>

        </div>

    </section>



    <!-- =====================================
         DATA KEGIATAN
    ===================================== -->

    <section
        class="content-card"
        id="kegiatan"
    >

        <div class="content-header">

            <div>

                <h2>
                    Data Kegiatan Ekstrakurikuler
                </h2>

                <p>
                    Daftar kegiatan yang dikelola oleh guru
                </p>

            </div>


            <a
                href="#"
                class="btn"
            >
                + Tambah Kegiatan
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Ekstrakurikuler
                        </th>

                        <th>
                            Pembimbing
                        </th>

                        <th>
                            Jumlah Siswa
                        </th>

                        <th>
                            Jadwal
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>1</td>

                        <td>
                            Futsal
                        </td>

                        <td>
                            Pak Ahmad
                        </td>

                        <td>
                            25
                        </td>

                        <td>
                            Senin
                        </td>

                        <td>
                            <span class="status">
                                Aktif
                            </span>
                        </td>

                    </tr>


                    <tr>

                        <td>2</td>

                        <td>
                            Coding
                        </td>

                        <td>
                            Pak Budi
                        </td>

                        <td>
                            20
                        </td>

                        <td>
                            Rabu
                        </td>

                        <td>
                            <span class="status">
                                Aktif
                            </span>
                        </td>

                    </tr>


                    <tr>

                        <td>3</td>

                        <td>
                            Basket
                        </td>

                        <td>
                            Pak Deni
                        </td>

                        <td>
                            18
                        </td>

                        <td>
                            Jumat
                        </td>

                        <td>
                            <span class="status">
                                Aktif
                            </span>
                        </td>

                    </tr>


                    <tr>

                        <td>4</td>

                        <td>
                            Pramuka
                        </td>

                        <td>
                            Bu Siti
                        </td>

                        <td>
                            30
                        </td>

                        <td>
                            Sabtu
                        </td>

                        <td>
                            <span class="status">
                                Aktif
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


    </section>



    <!-- =====================================
         MENU CEPAT GURU
    ===================================== -->

    <section
        class="quick-menu"
        id="penilaian"
    >


        <a
            href="#"
            class="quick-card"
        >

            <div class="quick-icon">
                ⭐
            </div>

            <h3>
                Penilaian Siswa
            </h3>

            <p>
                Kelola dan input nilai siswa.
            </p>

        </a>
<a href="{{ url('/guru/absensi') }}">
    🗓️ Absensi Siswa
</a>


        <a
            href="#laporan"
            class="quick-card"
        >

            <div class="quick-icon">
                📊
            </div>

            <h3>
                Laporan Nilai
            </h3>

            <p>
                Lihat rekap nilai kegiatan.
            </p>

        </a>



        <a
            href="#profil"
            class="quick-card"
        >

            <div class="quick-icon">
                👨‍🏫
            </div>

            <h3>
                Profil Guru
            </h3>

            <p>
                Informasi akun guru.
            </p>

        </a>


    </section>


</main>

</body>
</html>