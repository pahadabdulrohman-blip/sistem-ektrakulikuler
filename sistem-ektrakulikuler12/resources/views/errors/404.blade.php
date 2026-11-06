
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - AKTIVIA</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Arial, sans-serif;
            background: #f4f7f9;
            color: #263238;
        }
        .card {
            width: 90%;
            max-width: 480px;
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px #00000012;
        }
        h1 { font-size: 75px; color: #08718b; margin: 0; }
        h2 { color: #093C5D; }
        p { color: #777; line-height: 1.6; }
        a {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 25px;
            color: white;
            background: #093C5D;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Maaf, halaman yang kamu cari tidak tersedia atau sudah dipindahkan.</p>
        <a href="{{ route('login') }}">Kembali ke Login</a>
    </div>
</body>
</html>
