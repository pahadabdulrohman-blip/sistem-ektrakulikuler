<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hubungi Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #064866, #149bad);
        }

        .card {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 40px;
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,.2);
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #e8f8fb;
            color: #08718e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
        }

        h1 {
            color: #073f5d;
            margin-bottom: 10px;
        }

        .description {
            color: #777;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .contact {
            background: #f4fafb;
            border-radius: 15px;
            padding: 20px;
            text-align: left;
            margin-bottom: 20px;
        }

        .contact p {
            margin: 10px 0;
            color: #444;
            font-size: 14px;
        }

        .contact i {
            width: 25px;
            color: #08718e;
        }

        .back {
            display: inline-block;
            margin-top: 10px;
            color: #08718e;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="card">

    <div class="icon">
        <i class="fa-solid fa-headset"></i>
    </div>

    <h1>Hubungi Admin</h1>

    <p class="description">
        Jika kamu lupa password atau mengalami masalah saat masuk,
        silakan hubungi Admin Sistem Ekstrakurikuler.
    </p>

    <div class="contact">

        <p>
            <i class="fa-solid fa-user-shield"></i>
            <strong>Admin Sistem</strong>
        </p>

        <p>
            <i class="fa-solid fa-envelope"></i>
           fahad.abdul845@smk.belajar.id
        </p>

        <p>
            <i class="fa-solid fa-phone"></i>
            083103734649
        </p>

        <p>
            <i class="fa-solid fa-clock"></i>
            Senin - Jumat, 08.00 - 15.00
        </p>

    </div>

    <a href="{{ route('login') }}" class="back">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Login
    </a>

</div>

</body>
</html>