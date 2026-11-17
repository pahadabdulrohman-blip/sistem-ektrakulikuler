<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Konfirmasi Logout - Sistem Ekstrakurikuler</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

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
            min-height: 100vh;
            background: linear-gradient(135deg, #064566 0%, #08708b 55%, #159aaa 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .kartu {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 20px;
            padding: 36px 32px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .20);
        }

        .ikon {
            width: 64px;
            height: 64px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: #e6f6f9;
            color: #08708b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        h1 {
            font-size: 20px;
            color: #093C5D;
            margin-bottom: 8px;
        }

        p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .tombol {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px 18px;
            border: 0;
            border-radius: 10px;
            background: #08708b;
            color: #ffffff;
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .tombol:hover {
            background: #064566;
        }

        .batal {
            display: inline-block;
            margin-top: 14px;
            font-size: 14px;
            color: #64748b;
            text-decoration: none;
        }

        .batal:hover {
            color: #093C5D;
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="kartu">

        <div class="ikon">
            <i class="fa-solid fa-right-from-bracket"></i>
        </div>

        <h1>Keluar dari akun?</h1>

        <p>Sesi Anda akan diakhiri. Untuk masuk lagi, silakan login kembali.</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="tombol">
                <i class="fa-solid fa-right-from-bracket"></i>
                Ya, Logout
            </button>

        </form>

        <a href="{{ route('dashboard') }}" class="batal">Batal, kembali</a>

    </div>

</body>

</html>
