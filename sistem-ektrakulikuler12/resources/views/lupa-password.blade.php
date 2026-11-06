<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - Sistem Ekstrakurikuler</title>

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
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #064866, #149bad);
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,.2);
        }

        .icon {
            width: 75px;
            height: 75px;
            margin: 0 auto 20px;
            border-radius: 20px;
            background: linear-gradient(135deg, #064866, #149bad);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        h1 {
            text-align: center;
            color: #073f5d;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #222;
        }

        .input-box {
            position: relative;
            margin-bottom: 20px;
        }

        .input-box i {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #08718e;
        }

        input,
        select {
            width: 100%;
            height: 52px;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 0 15px 0 45px;
            font-family: 'Poppins', sans-serif;
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: #0c9db2;
            box-shadow: 0 0 0 3px rgba(12,157,178,.1);
        }

        select {
            padding-left: 15px;
        }

        .btn {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #064866, #149bad);
            color: white;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            margin-top: 5px;
        }

        .btn:hover {
            opacity: .9;
        }

        .admin-box {
            margin-top: 25px;
            padding: 18px;
            border-radius: 15px;
            background: #eef9fb;
            text-align: center;
        }

        .admin-box p {
            color: #555;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .admin-link {
            color: #08718e;
            font-weight: 600;
            text-decoration: none;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #08718e;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .success {
            background: #e8f8ee;
            color: #16753c;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        @media(max-width:600px) {
            .card {
                padding: 30px 22px;
            }
        }
    </style>
</head>

<body>

<div class="card">

    <div class="icon">
        <i class="fa-solid fa-key"></i>
    </div>

    <h1>Lupa Password?</h1>

    <p class="subtitle">
        Masukkan data akun kamu. Permintaan perubahan password akan
        diteruskan kepada Admin Sistem.
    </p>

    @if(session('success'))
        <div class="success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <label>Role</label>

        <select name="role" required>
            <option value="">Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="siswa">Siswa</option>
        </select>

        <br><br>

        <label>Username</label>

        <div class="input-box">
            <i class="fa-solid fa-user"></i>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >
        </div>

        <button type="submit" class="btn">
            <i class="fa-solid fa-paper-plane"></i>
            Kirim Permintaan
        </button>
    </form>

    <div class="admin-box">

        <p>
            Tidak bisa mengakses akun?
        </p>

        <a href="{{ route('hubungi.admin') }}" class="admin-link">
            <i class="fa-solid fa-headset"></i>
            Hubungi Admin
        </a>

    </div>

    <a href="{{ route('login') }}" class="back">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Login
    </a>

</div>

</body>
</html>