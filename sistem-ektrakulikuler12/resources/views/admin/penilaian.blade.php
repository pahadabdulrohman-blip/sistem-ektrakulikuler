<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penilaian - Admin</title>

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
            margin-bottom: 30px;
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
        }

        .table-box {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background: #f9fafb;
        }

        .nilai {
            font-weight: bold;
            color: #2563eb;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
        }

        @media(max-width: 700px) {
            .sidebar {
                width: 190px;
            }

            .content {
                margin-left: 190px;
                padding: 20px;
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

            <a href="{{ route('admin.ekstrakurikuler') }}">
                ⚽ Ekstrakurikuler
            </a>

            <a href="{{ route('admin.penilaian') }}" class="active">
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
                <h1>Penilaian</h1>
                <p>Kelola nilai siswa ekstrakurikuler</p>
            </div>

            <a href="{{ route('dashboard.admin') }}" class="back">
                ← Dashboard
            </a>

        </div>


        <div class="table-box">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Ekstrakurikuler</th>
                        <th>Nilai</th>
                        <th>Predikat</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Ahmad Fauzan</td>
                        <td>XI RPL 1</td>
                        <td>Futsal</td>
                        <td class="nilai">92</td>
                        <td><span class="badge">Sangat Baik</span></td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Muhammad Rizky</td>
                        <td>XI RPL 1</td>
                        <td>Coding</td>
                        <td class="nilai">87</td>
                        <td><span class="badge">Baik</span></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Fahad Abdul</td>
                        <td>XI RPL 2</td>
                        <td>Basket</td>
                        <td class="nilai">84</td>
                        <td><span class="badge">Baik</span></td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Rizal Maulana</td>
                        <td>XI RPL 2</td>
                        <td>Pramuka</td>
                        <td class="nilai">74</td>
                        <td><span class="badge">Cukup</span></td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Andi Saputra</td>
                        <td>XI RPL 1</td>
                        <td>Pencak Silat</td>
                        <td class="nilai">67</td>
                        <td><span class="badge">Perlu Bimbingan</span></td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</body>
</html>