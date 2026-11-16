
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ekstrakurikuler</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            padding: 40px 20px;
        }

        .box {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        h1 {
            margin-bottom: 8px;
            color: #1e3a8a;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;
            font-weight: bold;
            color: #374151;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .buttons {
            margin-top: 25px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button,
        .back {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        button {
            background: #2563eb;
            color: white;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back {
            background: #e5e7eb;
            color: #111827;
        }

        .back:hover {
            background: #d1d5db;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            background: #fee2e2;
            color: #991b1b;
        }

        @media(max-width: 600px) {
            body {
                padding: 22px 14px;
            }

            .box {
                padding: 22px 18px;
                border-radius: 12px;
            }

            h1 {
                font-size: 22px;
            }

            .buttons {
                flex-direction: column;
            }

            button,
            .back {
                text-align: center;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

<div class="box">

    <h1>Edit Ekstrakurikuler</h1>

    <p class="subtitle">
        Ubah data ekstrakurikuler.
    </p>

    @if ($errors->any())
        <div class="alert">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.ekstrakurikuler.update', $ekstrakurikuler['id']) }}"
          method="POST">

        @csrf
        @method('PUT')

        <label>Nama Ekstrakurikuler</label>

        <input type="text"
               name="nama"
               value="{{ old('nama', $ekstrakurikuler['nama']) }}"
               required>

        <label>Ikon</label>

        <input type="text"
               name="ikon"
               value="{{ old('ikon', $ekstrakurikuler['ikon']) }}">

        <label>Deskripsi</label>

        <textarea name="deskripsi"
                  required>{{ old('deskripsi', $ekstrakurikuler['deskripsi']) }}</textarea>

        <label>Nama Pembina</label>

        <input type="text"
               name="pembina"
               value="{{ old('pembina', $ekstrakurikuler['pembina']) }}">

        <label>Jadwal</label>

        <input type="text"
               name="jadwal"
               value="{{ old('jadwal', $ekstrakurikuler['jadwal']) }}">

        <label>Tempat Ekstrakurikuler</label>

        <input type="text"
               name="tempat"
               value="{{ old('tempat', $ekstrakurikuler['tempat'] ?? '-') }}">

        <div class="buttons">

            <a href="{{ route('admin.ekstrakurikuler') }}"
               class="back">
                ← Kembali
            </a>

            <button type="submit">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
