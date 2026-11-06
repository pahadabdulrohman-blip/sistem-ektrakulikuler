<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sistem Ekstrakurikuler</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .register-link {
    text-align: center;
    margin-top: 22px;
    margin-bottom: 15px;
    font-size: 15px;
    color: #64748b;
}

.register-link a {
    color: #0785a5;
    font-weight: 700;
    text-decoration: none;
    margin-left: 5px;
}

.register-link a:hover {
    color: #093C5D;
    text-decoration: underline;
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;

            background:
                radial-gradient(circle at 42% 8%,
                    rgba(255,255,255,0.08) 0,
                    rgba(255,255,255,0.08) 190px,
                    transparent 191px),

                linear-gradient(
                    135deg,
                    #064566 0%,
                    #08708b 55%,
                    #159aaa 100%
                );

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 14px;
        }


        /* =========================
           CONTAINER
        ========================= */

        .login-wrapper {

            width: 100%;
            max-width: 1120px;

            min-height: 748px;

            display: grid;
            grid-template-columns: 42% 58%;

            background: white;

            border-radius: 0 32px 32px 0;

            overflow: hidden;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.20);
        }


        /* =========================
           BAGIAN KIRI
        ========================= */

        .left-side {

            position: relative;

            color: white;

            padding: 56px 42px;

            display: flex;
            flex-direction: column;
            justify-content: flex-start;

            overflow: hidden;

            background:
                linear-gradient(
                    180deg,
                    #074867 0%,
                    #08627d 55%,
                    #1597aa 100%
                );
        }


        /* Lingkaran dekorasi */

        .circle-one {

            position: absolute;

            width: 380px;
            height: 380px;

            border-radius: 50%;

            background: rgba(255,255,255,0.035);

            top: -130px;
            right: -180px;
        }

        .circle-two {

            position: absolute;

            width: 300px;
            height: 300px;

            border-radius: 50%;

            border: 45px solid rgba(255,255,255,0.035);

            left: -170px;
            bottom: -130px;
        }


        /* Logo */

        .school-logo {

            width: 94px;
            height: 94px;

            border-radius: 25px;

            background: rgba(255,255,255,0.12);

            border: 1px solid rgba(255,255,255,0.35);

            display: flex;

            align-items: center;
            justify-content: center;

            margin-bottom: 32px;

            position: relative;
            z-index: 2;
        }

        .school-logo i {

            font-size: 43px;

            color: white;
        }


        /* Judul */

        .left-side h1 {

            font-size: 39px;

            line-height: 1.25;

            font-weight: 700;

            margin-bottom: 22px;

            position: relative;
            z-index: 2;
        }


        .left-side .description {

            font-size: 17px;

            line-height: 1.9;

            color: rgba(255,255,255,0.92);

            max-width: 430px;

            margin-bottom: 28px;

            position: relative;
            z-index: 2;
        }


        /* Fitur */

        .features {

            display: flex;
            flex-direction: column;

            gap: 18px;

            position: relative;
            z-index: 2;
        }

        .feature {

            display: flex;

            align-items: center;

            gap: 15px;

            font-size: 16px;

            font-weight: 500;
        }

        .feature-icon {

            width: 42px;
            height: 42px;

            border-radius: 11px;

            background: rgba(255,255,255,0.12);

            display: flex;

            align-items: center;
            justify-content: center;
        }

        .feature-icon i {

            font-size: 18px;
        }


        /* =========================
           BAGIAN KANAN
        ========================= */

        .right-side {

            padding: 65px 68px 40px;

            background: white;

            display: flex;

            flex-direction: column;

            justify-content: center;
        }


        .welcome {

            margin-bottom: 28px;
        }


        .welcome h2 {

            color: #063e5e;

            font-size: 36px;

            font-weight: 700;

            margin-bottom: 10px;
        }


        .welcome h2 span {

            display: inline-block;

            font-size: 34px;

            margin-left: 5px;
        }


        .welcome p {

            color: #9099a3;

            font-size: 15px;
        }


        /* =========================
           ERROR
        ========================= */

        .alert-error {

            background: #fff0f0;

            border-radius: 13px;

            padding: 16px 18px;

            color: #dc3545;

            font-size: 14px;

            margin-bottom: 22px;

            display: flex;

            align-items: center;

            gap: 10px;
        }


        /* =========================
           FORM
        ========================= */

        .form-group {

            margin-bottom: 22px;
        }


        .form-group label {

            display: block;

            font-size: 15px;

            font-weight: 600;

            color: #17202a;

            margin-bottom: 9px;
        }


        .input-wrapper {

            position: relative;
        }


        .input-wrapper > .left-icon {

            position: absolute;

            left: 19px;

            top: 50%;

            transform: translateY(-50%);

            color: #0b5b7a;

            font-size: 17px;

            z-index: 2;
        }


        .form-control {

            width: 100%;

            height: 67px;

            border: 1px solid #dce1e6;

            border-radius: 15px;

            outline: none;

            padding: 0 48px;

            font-family: 'Poppins', sans-serif;

            font-size: 15px;

            color: #333;

            background: #fff;

            transition: 0.2s;
        }


        .form-control::placeholder {

            color: #aeb6bd;
        }


        .form-control:focus {

            border-color: #159db0;

            box-shadow:
                0 0 0 4px rgba(21,157,176,0.10);
        }


        /* =========================
           SELECT ROLE
        ========================= */

        select.form-control {

            appearance: none;

            cursor: pointer;

            padding-right: 45px;
        }


        .select-arrow {

            position: absolute;

            right: 20px;

            top: 50%;

            transform: translateY(-50%);

            color: #78909c;

            pointer-events: none;
        }


        /* =========================
           PASSWORD
        ========================= */

        .password-toggle {

            position: absolute;

            right: 18px;

            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: transparent;

            cursor: pointer;

            color: #7f919b;

            font-size: 18px;

            padding: 5px;

            z-index: 3;
        }


        .password-toggle:hover {

            color: #08718b;
        }


        /* =========================
           REMEMBER & LUPA PASSWORD
        ========================= */

        .form-options {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin: 4px 0 27px;
        }


        .remember {

            display: flex;

            align-items: center;

            gap: 8px;

            color: #7d858c;

            font-size: 14px;
        }


        .remember input {

            width: 16px;
            height: 16px;

            accent-color: #0b718c;

            cursor: pointer;
        }


        .forgot {

            text-decoration: none;

            color: #006084;

            font-weight: 600;

            font-size: 14px;
        }


        .forgot:hover {

            text-decoration: underline;
        }


        /* =========================
           TOMBOL LOGIN
        ========================= */

        .btn-login {

            width: 100%;

            height: 66px;

            border: none;

            border-radius: 15px;

            background:
                linear-gradient(
                    90deg,
                    #064566,
                    #149caf
                );

            color: white;

            font-family: 'Poppins', sans-serif;

            font-size: 17px;

            font-weight: 600;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 14px;

            box-shadow:
                0 13px 25px rgba(7,101,126,0.20);

            transition: 0.2s;
        }


        .btn-login:hover {

            transform: translateY(-2px);

            box-shadow:
                0 16px 30px rgba(7,101,126,0.28);
        }


        .btn-login:active {

            transform: translateY(0);
        }


        .btn-login i {

            font-size: 18px;
        }


        /* =========================
           FOOTER
        ========================= */

        .footer {

            text-align: center;

            color: #a2a8ad;

            font-size: 13px;

            margin-top: 30px;
        }


        /* =========================
           AKUN DEMO
        ========================= */

        .demo-account {

            margin-top: 18px;

            padding: 13px 16px;

            background: #f6f9fb;

            border-radius: 10px;

            color: #7b858d;

            font-size: 11px;

            line-height: 1.7;
        }

        .demo-account strong {

            color: #345;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .login-wrapper {

                grid-template-columns: 1fr;

                max-width: 600px;

                border-radius: 25px;
            }

            .left-side {

                display: none;
            }

            .right-side {

                padding: 45px 35px;
            }
        }


        @media (max-width: 500px) {

            body {

                padding: 10px;
            }

            .login-wrapper {

                border-radius: 20px;
            }

            .right-side {

                padding: 35px 24px;
            }

            .welcome h2 {

                font-size: 28px;
            }

            .welcome h2 span {

                font-size: 27px;
            }

            .form-control {

                height: 60px;
            }

            .btn-login {

                height: 60px;

                font-size: 15px;
            }

            .form-options {

                gap: 10px;

                align-items: flex-start;
            }

            .forgot {

                text-align: right;
            }
        }

    </style>

</head>


<body>


<div class="login-wrapper">


    <!-- =========================
         BAGIAN KIRI
    ========================== -->

    <div class="left-side">

        <div class="circle-one"></div>

        <div class="circle-two"></div>


        <div class="school-logo">

            <i class="fa-solid fa-school"></i>

        </div>


        <h1>
            Sistem<br>
            Ekstrakurikuler
        </h1>


        <p class="description">

            Platform pengelolaan kegiatan ekstrakurikuler
            untuk membantu sekolah mengatur peserta,
            kegiatan, penilaian, dan laporan.

        </p>


        <div class="features">

            <div class="feature">

                <div class="feature-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <span>Pengelolaan data peserta</span>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

                <span>Manajemen kegiatan</span>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

                <span>Penilaian dan laporan</span>

            </div>

        </div>

    </div>



    <!-- =========================
         BAGIAN KANAN
    ========================== -->

    <div class="right-side">


        <div class="welcome">

            <h2>
                Selamat Datang
                <span>👋</span>
            </h2>

            <p>
                Silakan masuk untuk mengakses sistem.
            </p>

        </div>


        <!-- ERROR -->

        @if(session('error'))

            <div class="alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif



        <!-- FORM LOGIN -->

       <form action="{{ route('login.process') }}" method="POST">
    @csrf


            <!-- ROLE -->

            <div class="form-group">

                <label for="role">
                    Login sebagai
                </label>

                <div class="input-wrapper">

                    <i class="fa-solid fa-user-tag left-icon"></i>

                    <select
                        name="role"
                        id="role"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Pilih Admin / Guru / Siswa
                        </option>

                        <option
                            value="admin"
                            {{ old('role') == 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>

                        <option
                            value="guru"
                            {{ old('role') == 'guru' ? 'selected' : '' }}
                        >
                            Guru
                        </option>

                        <option
                            value="siswa"
                            {{ old('role') == 'siswa' ? 'selected' : '' }}
                        >
                            Siswa
                        </option>

                    </select>

                    <i class="fa-solid fa-chevron-down select-arrow"></i>

                </div>

            </div>



            <!-- USERNAME -->

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <div class="input-wrapper">

                    <i class="fa-solid fa-user left-icon"></i>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        required
                    >

                </div>

            </div>



            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="input-wrapper">

                    <i class="fa-solid fa-lock left-icon"></i>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >


                    <!-- Tombol buka/tutup password -->

                    <button
                        type="button"
                        class="password-toggle"
                        id="togglePassword"
                        aria-label="Tampilkan password"
                    >

                        <i class="fa-solid fa-eye" id="eyeIcon"></i>

                    </button>

                </div>

            </div>



            <!-- OPTIONS -->

           <div class="form-options">

    <label class="remember">
        <input type="checkbox" name="remember">
        <span>Ingat saya</span>
    </label>

    <a href="{{ route('password.request') }}" class="forgot">
        Lupa password?
    </a>

</div>

<div style="text-align:right; margin-top:-15px; margin-bottom:22px;">
    <a href="{{ route('hubungi.admin') }}"
       style="color:#08718e; font-size:13px; text-decoration:none; font-weight:600;">
        <i class="fa-solid fa-headset"></i>
        Hubungi Admin
    </a>
</div>



            <!-- BUTTON -->

            <button
                type="submit"
                class="btn-login"
            >

                <i class="fa-solid fa-right-to-bracket"></i>

                <span>Masuk ke Sistem</span>

            </button>

        </form>
        
<div class="register-link">
    <p>Belum punya akun?</p>
    <a href="{{ route('register') }}">Daftar Sekarang</a>
</div>



      



        <div class="footer">

            Sistem Ekstrakurikuler © 2026

        </div>

    </div>

</div>



<!-- =========================
     JAVASCRIPT PASSWORD
========================== -->

<script>

    const passwordInput =
        document.getElementById('password');

    const togglePassword =
        document.getElementById('togglePassword');

    const eyeIcon =
        document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {

        if (passwordInput.type === 'password') {

            passwordInput.type = 'text';

            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');

            togglePassword.setAttribute(
                'aria-label',
                'Sembunyikan password'
            );

        } else {

            passwordInput.type = 'password';

            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');

            togglePassword.setAttribute(
                'aria-label',
                'Tampilkan password'
            );

        }

    });

</script>
  

</body>

</html>