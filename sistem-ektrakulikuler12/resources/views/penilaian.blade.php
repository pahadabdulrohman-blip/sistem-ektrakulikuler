<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penilaian Ekstrakurikuler</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #0d6efd, #084298);
            color: white;
            padding: 25px 18px;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo i {
            font-size: 35px;
            margin-bottom: 8px;
        }

        .logo h2 {
            font-size: 18px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,0.2);
        }

        .menu i {
            width: 22px;
        }

        .content {
            margin-left: 250px;
            padding: 35px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 30px;
            color: #172554;
        }

        .header p {
            color: #6b7280;
            margin-top: 5px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
            overflow-x: auto;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-title i {
            color: #0d6efd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        th {
            background: #0d6efd;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .nilai {
            font-weight: 700;
            color: #0d6efd;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .baik {
            background: #dcfce7;
            color: #15803d;
        }

        .cukup {
            background: #fef3c7;
            color: #a16207;
        }

        .kurang {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn {
            background: #0d6efd;
            color: white;
            text-decoration: none;
            padding: 8px 13px;
            border-radius: 7px;
            font-size: 12px;
        }

        .btn:hover {
            background: #084298;
        }

        @media(max-width: 768px) {

            .sidebar {
                width: 70px;
                padding: 20px 10px;
            }

            .logo h2,
            .menu span {
                display: none;
            }

            .menu a {
                justify-content: center;
            }

            .content {
                margin-left: 70px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <i class="fa-solid fa-school"></i>
            <h2>EKSTRA</h2>
        </div>

        <div class="menu">

            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('ekstrakurikuler') }}">
                <i class="fa-solid fa-users"></i>
                <span>Ekstrakurikuler</span>
            </a>

            <a href="{{ route('penilaian') }}" class="active">
                <i class="fa-solid fa-star"></i>
                <span>Penilaian</span>
            </a>

            <a href="{{ route('profil') }}">
                <i class="fa-solid fa-user"></i>
                <span>Profil</span>
            </a>

            <a href="{{ route('laporan') }}">
                <i class="fa-solid fa-file"></i>
                <span>Laporan</span>
            </a>

        </div>

    </aside>


    <!-- CONTENT -->
    <main class="content">

        <div class="header">
            <h1>Penilaian Ekstrakurikuler</h1>
            <p>Data penilaian siswa ekstrakurikuler</p>
        </div>


        <div class="card">

            <div class="card-title">
                <i class="fa-solid fa-clipboard-check"></i>
                <h2>Daftar Nilai Siswa</h2>
            </div>


            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Ekstrakurikuler</th>
                        <th>Kehadiran</th>
                        <th>Keterampilan</th>
                        <th>Nilai</th>
                        <th>Predikat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>


                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Ahmad Fauzan</td>
                        <td>Futsal</td>
                        <td>95%</td>
                        <td>90</td>
                        <td class="nilai">92</td>
                        <td>
                            <span class="badge baik">
                                Sangat Baik
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penilaian.detail', 1) }}"
                               class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>2</td>
                        <td>Muhammad Rizky</td>
                        <td>Coding</td>
                        <td>90%</td>
                        <td>85</td>
                        <td class="nilai">87</td>
                        <td>
                            <span class="badge baik">
                                Baik
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penilaian.detail', 2) }}"
                               class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>3</td>
                        <td>Fahad Abdul</td>
                        <td>Basket</td>
                        <td>85%</td>
                        <td>82</td>
                        <td class="nilai">84</td>
                        <td>
                            <span class="badge baik">
                                Baik
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penilaian.detail', 3) }}"
                               class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>4</td>
                        <td>Rizal Maulana</td>
                        <td>Pramuka</td>
                        <td>75%</td>
                        <td>72</td>
                        <td class="nilai">74</td>
                        <td>
                            <span class="badge cukup">
                                Cukup
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penilaian.detail', 4) }}"
                               class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>5</td>
                        <td>Andi Saputra</td>
                        <td>Pencak Silat</td>
                        <td>65%</td>
                        <td>68</td>
                        <td class="nilai">67</td>
                        <td>
                            <span class="badge kurang">
                                Perlu Bimbingan
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penilaian.detail', 5) }}"
                               class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>
<tbody>

@foreach ($nilai as $item)

<tr>
    <td>{{ $item['id'] }}</td>

    <td>{{ $item['nama'] }}</td>

    <td>{{ $item['ekstrakurikuler'] }}</td>

    <td>{{ $item['kehadiran'] }}%</td>

    <td>{{ $item['keterampilan'] }}</td>

    <td>
        <strong>{{ $item['nilai'] }}</strong>
    </td>

    <td>
        {{ $item['predikat'] }}
    </td>

    <td>
        <a href="{{ route('penilaian.detail', $item['id']) }}">
            Detail
        </a>
    </td>
</tr>

@endforeach

</tbody>
                </tbody>

            </table>

        </div>

    </main>

</body>
</html>