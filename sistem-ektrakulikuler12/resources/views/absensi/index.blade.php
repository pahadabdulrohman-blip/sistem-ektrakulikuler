
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa - AKTIVIA</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f6fa;
            color: #17202a;
        }

        .main {
            margin-left: 270px;
            padding: 35px;
        }

        .header, .card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        h1, h2 {
            color: #116b43;
        }

        h1 {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .subtitle {
            color: #718096;
            font-size: 13px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 22px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 13px;
            border: 1px solid #dce5df;
            border-radius: 9px;
            font-family: inherit;
            font-size: 13px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #148f5a;
        }

        .btn {
            border: none;
            background: #148f5a;
            color: white;
            padding: 13px 22px;
            border-radius: 9px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            margin-top: 22px;
        }

        .btn:hover {
            background: #087847;
        }

        .back {
            display: inline-block;
            color: #148f5a;
            text-decoration: none;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .message {
            padding: 13px;
            border-radius: 9px;
            margin-top: 15px;
            font-size: 13px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-wrapper {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            background: #148f5a;
            color: white;
            text-align: left;
            padding: 14px;
            font-size: 12px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e8edf1;
            font-size: 13px;
        }

        .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            background: #d9f7e7;
            color: #087847;
            font-size: 11px;
            font-weight: 600;
        }

        @media(max-width: 800px) {
            .main {
                margin-left: 0;
                padding: 18px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .top-back {
                padding: 15px 15px 0;
            }

            .top-back a {
                display: block !important;
                text-align: center;
                padding: 11px 16px !important;
            }

            .header, .card {
                padding: 20px;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>
@php
    $dataSiswa = $dataSiswa ?? collect($siswa ?? [])->keyBy('username');
    $ekskul = $ekskul ?? collect();
@endphp

    <div class="top-back" style="margin-bottom: 20px;">
    <a href="{{ url('/dashboard') }}"
       style="
            display: inline-block;
            padding: 12px 22px;
            background-color: #0b3d5c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
       ">
        ← Kembali ke Dashboard
    </a>
</div>

<main class="main">
    

    <a href="{{ route('dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>

    <header class="header">
        <h1>Absensi Siswa</h1>
        <p class="subtitle">
            Kelola dan catat kehadiran siswa dalam kegiatan ekstrakurikuler.
        </p>
    </header>

    <section class="card">

        <h2>Formulir Absensi</h2>

        @if(session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="message error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('guru.absensi.simpan') }}" method="POST">
            @csrf

            <div class="form-grid">

                <div>
                    <label>Nama Siswa</label>
                    <select name="username" required>
                        <option value="">-- Pilih Siswa --</option>

                        @foreach($siswa as $item)
                            @php
                                $ekskulSiswa = $item->pendaftaranEkstrakurikuler
                                    ->pluck('ekstrakurikuler.nama_ekstrakurikuler')
                                    ->filter()
                                    ->values();
                            @endphp

                            <option value="{{ $item->username }}"
                                data-kelas="{{ $item->kelas_saat_ini ?? '-' }}"
                                data-ekskul="{{ $ekskulSiswa->implode('|') }}"
                                {{ old('username') == $item->username ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->username }}) - Kelas {{ $item->kelas_saat_ini ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Kelas</label>
                    <input
                        type="text"
                        id="kelasSiswa"
                        value="-"
                        readonly
                        style="background:#f3f6fa;"
                    >
                </div>

                <div>
                    <label>Nama Kegiatan</label>
                    <select name="nama_kegiatan" id="namaKegiatan" required>
                        <option value="">-- Pilih Ekstrakurikuler --</option>
                        @foreach($ekskul as $item)
                            <option value="{{ $item->nama_ekstrakurikuler }}"
                                {{ old('nama_kegiatan') == $item->nama_ekstrakurikuler ? 'selected' : '' }}>
                                {{ $item->nama_ekstrakurikuler }}
                            </option>
                        @endforeach
                    </select>
                    <small style="color:#718096;display:block;margin-top:6px;">
                        Otomatis mengikuti ekstrakurikuler siswa yang dipilih.
                    </small>
                </div>

                <div>
                    <label>Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal', date('Y-m-d')) }}"
                        required
                    >
                </div>

                <div>
                    <label>Status Kehadiran</label>
                    <select name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpa">Alpa</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn">
                Simpan Absensi
            </button>
        </form>

    </section>

    <section class="card">

        <h2>Rekap Absensi Siswa</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absensi as $index => $item)
                        @php
                            $siswaAbsen = $dataSiswa->get($item->username);
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswaAbsen->name ?? $item->username }}</td>
                            <td>{{ $siswaAbsen->kelas_saat_ini ?? '-' }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                <span class="status">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>{{ $item->dicatat_oleh }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </section>

</main>

<script>
    (function () {
        const siswa = document.querySelector('select[name="username"]');
        const kelas = document.getElementById('kelasSiswa');
        const kegiatan = document.getElementById('namaKegiatan');

        // Semua pilihan ekskul dari server (dipakai bila siswa belum memilih ekskul).
        const semuaEkskul = Array.from(kegiatan.options)
            .map(function (opsi) {
                return opsi.value;
            })
            .filter(Boolean);

        let pertamaKali = true;

        function isiDataSiswa() {
            const opsi = siswa.options[siswa.selectedIndex];
            const daftarEkskul = opsi && opsi.dataset.ekskul
                ? opsi.dataset.ekskul.split('|').filter(Boolean)
                : [];

            kelas.value = opsi && opsi.dataset.kelas ? opsi.dataset.kelas : '-';

            if (!opsi || !opsi.value) {
                pertamaKali = false;
                return;
            }

            const nilaiLama = pertamaKali ? kegiatan.value : '';
            pertamaKali = false;

            // Ekskul yang diikuti siswa; jika belum ada, tampilkan semua ekskul.
            const daftarTampil = daftarEkskul.length > 0
                ? daftarEkskul
                : semuaEkskul;

            kegiatan.innerHTML = '';

            daftarTampil.forEach(function (nama) {
                const pilihan = document.createElement('option');
                pilihan.value = nama;
                pilihan.textContent = nama;
                kegiatan.appendChild(pilihan);
            });

            // Langsung pilih ekskul siswa tanpa perlu klik ulang.
            if (nilaiLama && daftarTampil.indexOf(nilaiLama) !== -1) {
                kegiatan.value = nilaiLama;
            } else if (daftarTampil.length > 0) {
                kegiatan.selectedIndex = 0;
            }
        }

        siswa.addEventListener('change', isiDataSiswa);
        isiDataSiswa();
    })();
</script>

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
