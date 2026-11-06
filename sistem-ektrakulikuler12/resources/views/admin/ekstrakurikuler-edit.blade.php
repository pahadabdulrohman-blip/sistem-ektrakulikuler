<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ekstrakurikuler</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            padding: 40px;
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
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 110px;
        }

        .buttons {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        button,
        .back {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #2563eb;
            color: white;
        }

        .back {
            background: #e5e7eb;
            color: #111827;
        }
    </style>
</head>

<body>

<div class="box">

    <h1>Edit Ekstrakurikuler</h1>

    <p class="subtitle">
        Ubah data ekstrakurikuler.
    </p>

    <form action="{{ route('admin.ekstrakurikuler.update', $ekstrakurikuler->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <label>Nama Ekstrakurikuler</label>

        <input type="text"
               name="nama"
               value="{{ old('nama', $ekstrakurikuler->nama) }}"
               required>


        <label>Ikon</label>

        <input type="text"
               name="ikon"
               value="{{ old('ikon', $ekstrakurikuler->ikon) }}">


        <label>Deskripsi</label>

        <textarea name="deskripsi"
                  required>{{ old('deskripsi', $ekstrakurikuler->deskripsi) }}</textarea>


        <label>Nama Pembina</label>

        <input type="text"
               name="pembina"
               value="{{ old('pembina', $ekstrakurikuler->pembina) }}">


        <label>Jadwal</label>

        <input type="text"
               name="jadwal"
               value="{{ old('jadwal', $ekstrakurikuler->jadwal) }}">


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

</body>
</html>