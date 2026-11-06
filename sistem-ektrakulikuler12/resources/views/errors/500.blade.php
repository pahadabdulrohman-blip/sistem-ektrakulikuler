
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kesalahan Server - AKTIVIA</title>
    <style>
        body {
            margin: 0; min-height: 100vh;
            display: grid; place-items: center;
            font-family: Arial, sans-serif;
            background: #f4f7f9; color: #263238;
        }
        .card {
            background: white; padding: 40px;
            border-radius: 20px; text-align: center;
            max-width: 450px; width: 90%;
        }
        h1 { font-size: 75px; color: #dc3545; margin: 0; }
        h2 { color: #093C5D; }
        p { color: #777; line-height: 1.6; }
        a {
            display: inline-block; padding: 12px 25px;
            margin-top: 15px; background: #093C5D;
            color: white; text-decoration: none; border-radius: 8px;
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
