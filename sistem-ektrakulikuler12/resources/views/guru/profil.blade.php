
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Guru</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1e293b;
        }

        .card {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 20px #0000000d;
        }

        h1 { color: #167d5a; }

        label {
            display: block;
            margin: 20px 0 8px;
            color: #64748b;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }

        a {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 18px;
            background: #167d5a;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main class="card">
        <h1>Profil Guru</h1>
        <p>Informasi akun Guru</p>

        <label>Nama pengguna</label>
        <input
            type="text"
            value="{{ session('username', 'Guru') }}"
            readonly
        >

        <label>Role</label>
        <input type="text" value="Guru" readonly>

        <a href="{{ route('dashboard.guru') }}">
            Kembali ke Dashboard
        </a>
    </main>
</body>
</html>
@php
    $fotoProfil = \App\Models\ProfilePhoto::where(
        'username', session('username')
    )->where(
        'role', session('role')
    )->first();
@endphp

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p style="color: red">{{ $error }}</p>
    @endforeach
@endif

<div style="margin: 20px 0;">
    @if ($fotoProfil)
        <img
            src="{{ asset('storage/' . $fotoProfil->photo_path) }}"
            alt="Foto Profil"
            style="width:130px;height:130px;object-fit:cover;border-radius:50%;"
        >
    @else
        <div style="width:130px;height:130px;border-radius:50%;
                    background:#d9f7e7;display:flex;align-items:center;
                    justify-content:center;font-size:45px;">
            👤
        </div>
    @endif

    <form action="{{ route('profil.foto.upload') }}"
          method="POST"
          enctype="multipart/form-data"
          style="margin-top:15px;">
        @csrf

        <label for="foto">Pilih foto profil</label><br>

        <input
            type="file"
            name="foto"
            id="foto"
            accept=".jpg,.jpeg,.png,.webp"
            required
        >

        <br><br>

        <button type="submit">Simpan Foto</button>
    </form>
</div>