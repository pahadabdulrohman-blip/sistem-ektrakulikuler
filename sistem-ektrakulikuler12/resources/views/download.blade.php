<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unduh Aplikasi - AKTIVIA</title>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: grid; place-items: center;
            padding: 18px; font-family: Arial, sans-serif;
            background: #f4f7f9; color: #263238;
        }
        .card {
            background: #fff; padding: 40px 32px; border-radius: 20px;
            text-align: center; max-width: 480px; width: 100%;
            box-shadow: 0 10px 30px rgba(9, 60, 93, .08);
        }
        h1 { color: #093C5D; margin: 0 0 8px; font-size: 26px; }
        p { color: #666; line-height: 1.6; font-size: 14px; }
        .meta {
            background: #f4f7f9; border-radius: 12px; padding: 14px;
            margin: 22px 0; font-size: 14px; color: #444;
        }
        .btn {
            display: inline-block; padding: 14px 28px; border-radius: 10px;
            background: #093C5D; color: #fff; text-decoration: none;
            font-weight: bold;
        }
        .btn:hover { background: #0b4b73; }
        .kecil { font-size: 12px; color: #999; word-break: break-all; }
        a.kembali { display: inline-block; margin-top: 18px; color: #093C5D; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Unduh Aplikasi</h1>
        <p>Silakan unduh berkas APK berikut lalu buka di perangkat Android Anda.</p>

        <div class="meta">
            <strong>{{ $nama }}</strong><br>
            Versi {{ $versi }} &middot; {{ $ukuran }}
        </div>

        <a class="btn" href="{{ $url }}" download>Unduh APK</a>

        <p class="kecil">SHA-256: {{ $sha256 }}</p>

        <a class="kembali" href="{{ url('/login') }}">Kembali ke halaman login</a>
    </div>
</body>
</html>
