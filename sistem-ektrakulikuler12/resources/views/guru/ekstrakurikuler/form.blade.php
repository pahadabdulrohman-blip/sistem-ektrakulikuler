
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Poppins, sans-serif;
            background: #eef8ff;
            color: #075985;
        }

        .container {
            max-width: 750px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 32px;
            border-radius: 18px;
            box-shadow: 0 8px 25px #07598512;
        }

        h1 { margin-bottom: 8px; font-size: 27px; }
        .subtitle { color: #7894a6; margin-bottom: 25px; font-size: 14px; }

        label {
            display: block;
            margin: 17px 0 7px;
            font-size: 13px;
            font-weight: 600;
        }

        input, textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #cde3ef;
            border-radius: 10px;
            outline: none;
            font-family: inherit;
            font-size: 14px;
        }

        input:focus, textarea:focus {
            border-color: #0788bd;
            box-shadow: 0 0 0 3px #0788bd18;
        }

        textarea { min-height: 110px; resize: vertical; }

        .error { color: #d83232; font-size: 12px; margin-top: 5px; }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button, .back {
            padding: 12px 20px;
            border: none;
            border-radius: 9px;
            background: #0788bd;
            color: white;
            text-decoration: none;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px;
        }

        .back { background: #718899; }

        @media(max-width: 600px) {
            .container {
                margin: 22px auto;
                padding: 0 14px;
            }

            .card {
                padding: 22px 18px;
                border-radius: 14px;
            }

            h1 { font-size: 22px; }

            .buttons {
                flex-direction: column;
            }

            button, .back {
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card">

        <h1>{{ $judul }}</h1>
        <p class="subtitle">Lengkapi informasi ekstrakurikuler berikut.</p>

        <form action="{{ $action }}" method="POST">
            @csrf

            @if($method === 'PUT')
                @method('PUT')
            @endif

            <label>Nama Ekstrakurikuler *</label>
            <input type="text"
                   name="nama_ekstrakurikuler"
                   value="{{ old('nama_ekstrakurikuler', $item->nama_ekstrakurikuler) }}"
                   placeholder="Contoh: Futsal"
                   required>
            @error('nama_ekstrakurikuler')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Deskripsi *</label>
            <textarea name="deskripsi"
                      placeholder="Masukkan deskripsi kegiatan..."
                      required>{{ old('deskripsi', $item->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="error">{{ $message }}</div>
            @enderror

            <label>Ikon</label>
            <input type="text"
                   name="ikon"
                   value="{{ old('ikon', $item->ikon) }}"
                   placeholder="Contoh: F">

            <label>Nama Pembina</label>
            <input type="text"
                   name="pembina"
                   value="{{ old('pembina', $item->pembina) }}"
                   placeholder="Nama guru pembina">

            <label>Jadwal</label>
            <input type="text"
                   name="jadwal"
                   value="{{ old('jadwal', $item->jadwal) }}"
                   placeholder="Contoh: Jumat, 14.00">

            <label>Tempat</label>
            <input type="text"
                   name="tempat"
                   value="{{ old('tempat', $item->tempat) }}"
                   placeholder="Contoh: Lapangan Sekolah">

            <div class="buttons">
                <button type="submit">Simpan Data</button>

                <a href="{{ route('guru.ekstrakurikuler.index') }}"
                   class="back">Kembali</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>

