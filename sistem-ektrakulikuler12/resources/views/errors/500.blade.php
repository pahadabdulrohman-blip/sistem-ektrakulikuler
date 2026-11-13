
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kesalahan Server - AKTIVIA</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0; min-height: 100vh;
            display: grid; place-items: center;
            padding: 18px;
            font-family: Arial, sans-serif;
            background: #f4f7f9; color: #263238;
        }
        .card {
            background: white; padding: 40px;
            border-radius: 20px; text-align: center;
            max-width: 450px; width: 100%;
        }
        h1 { font-size: 75px; color: #dc3545; margin: 0; }
        h2 { color: #093C5D; }
        p { color: #777; line-height: 1.6; }
        a {
            display: inline-block; padding: 12px 25px;
            margin-top: 15px; background: #093C5D;
            color: white; text-decoration: none; border-radius: 8px;
        }

        @media (max-width: 480px) {
            .card { padding: 28px 18px; border-radius: 16px; }
            h1 { font-size: 58px; }
            h2 { font-size: 20px; }
            p { font-size: 14px; }
            a { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>500</h1>
        <h2>Terjadi Kesalahan Server</h2>
        <p>Maaf, sistem sedang mengalami gangguan. Silakan coba kembali nanti.</p>
        <a href="{{ route('login') }}">Kembali ke Login</a>
    </div>
</body>
</html>
