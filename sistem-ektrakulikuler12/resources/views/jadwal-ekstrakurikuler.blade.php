
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Ekstrakurikuler</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }
        .card {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px #00000010;
        }
        h1 { color: #0f766e; }
        .jadwal {
            padding: 15px;
            margin: 12px 0;
            background: #f0fdfa;
            border-left: 4px solid #0f766e;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Jadwal Ekstrakurikuler</h1>
        <p>Informasi kegiatan ekstrakurikuler siswa.</p>

        <div class="jadwal">
            <h3>Ekstrakurikuler Wajib</h3>
            <p>Jadwal kegiatan wajib akan ditampilkan di sini.</p>
        </div>

        <div class="jadwal">
            <h3>Ekstrakurikuler Gabungan</h3>
            <p>Jadwal kegiatan bersama sekolah lain akan ditampilkan di sini.</p>
        </div>

        <a href="{{ url('/dashboard-siswa') }}">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
