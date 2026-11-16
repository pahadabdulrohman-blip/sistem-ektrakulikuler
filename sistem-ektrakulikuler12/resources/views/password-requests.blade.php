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

        .message {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
            line-height: 1.6;
        }

        .message.success {
            background: #e8f8ee;
            color: #16753c;
        }

        .message.error {
            background: #fdecec;
            color: #a02020;
        }

        .notification {
            background: white;
            border-radius: 16px;
            padding: 22px;
            margin-bottom: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.07);
        }

        .notification-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .left {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            min-width: 0;
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
            flex: 0 0 55px;
        }

        .info {
            min-width: 0;
        }

        .info h3 {
            font-size: 16px;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .info p {
            color: #777;
            font-size: 13px;
            margin-bottom: 3px;
            word-break: break-word;
        }

        .badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 8px;
            font-weight: 600;
        }

        .badge.selesai {
            background: #dcfce7;
            color: #166534;
        }

        .badge.gagal {
            background: #fee2e2;
            color: #991b1b;
        }

        .form-proses {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px dashed #e2e8f0;

            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 12px;
        }

        .form-proses .field {
            flex: 1 1 260px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-proses label {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }

        .form-proses input {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
        }

        .form-proses input:focus {
            outline: none;
            border-color: #08718b;
            box-shadow: 0 0 0 3px rgba(8,113,139,.1);
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 12px 16px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-kirim {
            background: #08718b;
            color: white;
        }

        .btn-kirim:hover {
            background: #065d73;
        }

        .btn-hapus {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-hapus:hover {
            background: #fecaca;
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

            .notification-top {
                flex-direction: column;
            }

            .form-proses {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

@php
    $pengguna = $pengguna ?? collect();
@endphp

<div class="container">

    <div class="header">

        <h1>
            <i class="fa-solid fa-bell"></i>
            Permintaan Ubah Password
        </h1>

        <p>
            Proses permintaan dari siswa atau guru. Password baru akan
            dikirim ke email yang terdaftar pada akun mereka.
        </p>

    </div>

    @if(session('success'))
        <div class="message success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @php
        $mailerAktif = config('mail.default');
        $mailerKonfig = config('mail.mailers.' . $mailerAktif, []);

        $mailSiap = ! in_array($mailerAktif, ['log', 'array'], true)
            && filled($mailerKonfig['username'] ?? null)
            && filled($mailerKonfig['password'] ?? null);
    @endphp

    @if($mailSiap)
        {{-- Email aktif, tidak perlu peringatan. --}}
    @else
        <div class="message error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Pengiriman email belum aktif. Password baru akan ditampilkan
            kepada admin dan tidak terkirim ke email pengguna. Isi
            <strong>MAIL_USERNAME</strong> (alamat Gmail) dan
            <strong>MAIL_PASSWORD</strong> (App Password Gmail) pada file
            <strong>.env</strong> agar email benar-benar terkirim.
        </div>
    @endif

    @if($errors->any())
        <div class="message error">
            @foreach($errors->all() as $error)
                <div>
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    @forelse($requests as $item)

        @php
            $user = $pengguna->get($item->username);
            $status = strtolower((string) $item->status);
        @endphp

        <div class="notification">

            <div class="notification-top">

                <div class="left">

                    <div class="icon">
                        <i class="fa-solid fa-key"></i>
                    </div>

                    <div class="info">

                        <h3>
                            {{ $user->name ?? $item->username }}
                        </h3>

                        <p>
                            Username:
                            <strong>{{ $item->username }}</strong>
                            &middot;
                            Role:
                            <strong>{{ ucfirst($item->role) }}</strong>
                        </p>

                        <p>
                            Email:
                            <strong>{{ $user->email ?? 'Belum terdaftar' }}</strong>
                        </p>

                        <p>
                            Waktu:
                            {{ $item->created_at->format('d/m/Y H:i') }}
                        </p>

                    </div>

                </div>

                <span class="badge {{ $status }}">
                    {{ ucfirst($item->status) }}
                </span>

            </div>

            @if($status === 'menunggu')

                <form
                    action="{{ route('admin.password.requests.reset', $item->id) }}"
                    method="POST"
                    class="form-proses"
                >
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label>Password Baru (opsional)</label>
                        <input
                            type="text"
                            name="password"
                            minlength="8"
                            maxlength="50"
                            placeholder="Kosongkan untuk dibuat otomatis"
                            autocomplete="new-password"
                        >
                    </div>

                    <button type="submit" class="btn btn-kirim">
                        <i class="fa-solid fa-paper-plane"></i>
                        Simpan &amp; Kirim Email
                    </button>

                </form>

                <form
                    action="{{ route('admin.password.requests.destroy', $item->id) }}"
                    method="POST"
                    style="margin-top:10px;"
                    onsubmit="return confirm('Hapus permintaan dari {{ $item->username }}? Password tidak akan diubah.')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-hapus">
                        <i class="fa-solid fa-trash"></i>
                        Hapus Permintaan
                    </button>
                </form>

            @endif

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

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>

</html>
