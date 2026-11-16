
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi AKTIVIA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #093C5D, #3B7597, #6FD1D7);
        }

        .container {
            width: 100%;
            max-width: 430px;
            padding: 35px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0,0,0,.2);
        }

        h2 {
            color: #093C5D;
            text-align: center;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #777;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin: 13px 0 7px;
            font-weight: bold;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: white;
            font-size: 15px;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #3B7597;
        }

        button {
            width: 100%;
            margin-top: 23px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #093C5D;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #3B7597;
        }

        .error {
            color: #d93025;
            font-size: 13px;
        }

        .login {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login a {
            color: #093C5D;
            font-weight: bold;
            text-decoration: none;
        }

        .login a:hover {
            text-decoration: underline;
        }

        @media(max-width: 480px) {
            body {
                padding: 14px;
            }

            .container {
                padding: 24px 20px;
                border-radius: 14px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

<div class="container">

    <h2>AKTIVIA</h2>
    <p class="subtitle">
        Pendaftaran akun siswa. Akun guru dibuat oleh admin sekolah.
    </p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <label>Nama Lengkap</label>
        <input
            type="text"
            name="name"
            placeholder="Masukkan nama lengkap"
            value="{{ old('name') }}"
            required
        >

        <label>Username</label>
        <input
            type="text"
            name="username"
            placeholder="Buat username"
            value="{{ old('username') }}"
            required
        >

        <label>Email Gmail</label>
        <input
            type="email"
            name="email"
            placeholder="contoh@gmail.com"
            value="{{ old('email') }}"
            required
        >

        <label>Kelas</label>
        <select name="kelas" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach (\App\Models\User::DAFTAR_KELAS as $kelas)
                <option value="{{ $kelas }}" {{ old('kelas') == $kelas ? 'selected' : '' }}>
                    {{ $kelas }}
                </option>
            @endforeach
        </select>
        <small style="color:#777;display:block;margin-top:6px;">
            Kelas otomatis naik setiap tahun ajaran baru.
        </small>

        <label>Password</label>
        <input
            type="password"
            name="password"
            placeholder="Minimal 8 karakter"
            required
        >

        <label>Konfirmasi Password</label>
        <input
            type="password"
            name="password_confirmation"
            placeholder="Ulangi password"
            required
        >

        <button type="submit">Daftar Sekarang</button>
    </form>

    <div class="login">
        Sudah punya akun?
        <a href="{{ route('login') }}">Login</a>
    </div>

</div>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
