<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Permintaan Password</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

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
            background: #f4f7f9;
            padding: 40px;
            color: #263238;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            background: linear-gradient(135deg, #064566, #159aaa);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .header p {
            opacity: .9;
        }

        .notification {
            background: white;
            border-radius: 16px;
            padding: 22px;
            margin-bottom: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.07);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: #e7f7fa;
            color: #08718b;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 22px;
        }

        .info h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .info p {
            color: #777;
            font-size: 13px;
        }

        .badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 8px;
        }

        .empty {
            background: white;
            text-align: center;
            padding: 60px 20px;
            border-radius: 16px;
            color: #777;
        }

        .empty i {
            font-size: 45px;
            margin-bottom: 15px;
            color: #aaa;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #08718b;
            text-decoration: none;
            font-weight: 600;
        }

        @media(max-width:700px) {
            body {
                padding: 15px;
            }

            .notification {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <h1>
            <i class="fa-solid fa-bell"></i>
            Permintaan Ubah Password
        </h1>

        <p>
            Daftar permintaan perubahan password dari pengguna sistem.
        </p>

    </div>


    @forelse($requests as $item)

        <div class="notification">

            <div class="left">

                <div class="icon">
                    <i class="fa-solid fa-key"></i>
                </div>

                <div class="info">

                    <h3>
                        {{ $item->username }}
                    </h3>

                    <p>
                        Role:
                        <strong>{{ ucfirst($item->role) }}</strong>
                    </p>

                    <p>
                        Waktu:
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </p>

                    <span class="badge">
                        {{ ucfirst($item->status) }}
                    </span>

                </div>

            </div>

        </div>

    @empty

        <div class="empty">

            <i class="fa-regular fa-bell-slash"></i>

            <h3>Tidak ada permintaan</h3>

            <p>
                Belum ada permintaan ubah password.
            </p>

        </div>

    @endforelse


    <a href="{{ route('dashboard.admin') }}" class="back">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Dashboard Admin
    </a>

</div>

</body>

</html>