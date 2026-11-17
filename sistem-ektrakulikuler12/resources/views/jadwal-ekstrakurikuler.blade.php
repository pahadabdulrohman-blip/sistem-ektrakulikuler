
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Ekstrakurikuler</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
            color: #1e293b;
        }

        .card {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 4px 15px #00000010;
        }

        h1 {
            color: #0f766e;
            margin-top: 0;
        }

        .kategori {
            margin-top: 30px;
        }

        .kategori h2 {
            color: #0f766e;
            border-bottom: 2px solid #ccfbf1;
            padding-bottom: 10px;
        }

        .jadwal {
            padding: 20px;
            margin: 15px 0;
            background: #f0fdfa;
            border-left: 5px solid #0f766e;
            border-radius: 10px;
        }

        .jadwal h3 {
            margin-top: 12px;
            color: #134e4a;
        }

        .info {
            margin: 10px 0;
            line-height: 1.6;
        }

        .info i {
            margin-right: 6px;
            color: #0f766e;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: #ccfbf1;
            color: #0f766e;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge.gabungan {
            background: #fef3c7;
            color: #92400e;
        }

        .kosong {
            background: #f8fafc;
            padding: 18px;
            border-radius: 8px;
            color: #64748b;
        }

        .page-nav {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 18px;
        }

        .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: #0f766e;
            color: white;
            text-decoration: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-kembali:hover {
            background: #115e59;
        }

        /* KELOLA JADWAL (GURU) */
        .kelola {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 2px dashed #ccfbf1;
        }

        .kelola h2 {
            color: #0f766e;
            margin-top: 0;
        }

        .pesan {
            padding: 12px 14px;
            border-radius: 9px;
            margin: 12px 0;
            font-size: 14px;
        }

        .pesan.sukses {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        .pesan.gagal {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 15px;
        }

        .form-grid label {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #134e4a;
        }

        .form-grid .full {
            grid-column: 1 / -1;
        }

        .form-grid input,
        .form-grid select,
        .form-grid textarea {
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font: inherit;
            background: #fff;
            color: #1e293b;
            width: 100%;
        }

        .form-grid input:focus,
        .form-grid select:focus,
        .form-grid textarea:focus {
            outline: 2px solid #99f6e4;
            border-color: #0f766e;
        }

        .form-aksi {
            display: flex;
            gap: 10px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border: none;
            border-radius: 9px;
            background: #0f766e;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            font-family: inherit;
        }

        .btn:hover {
            background: #115e59;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        .btn-edit {
            background: #0ea5e9;
        }

        .btn-edit:hover {
            background: #0284c7;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .table-wrap {
            overflow-x: auto;
            margin-top: 15px;
        }

        table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        th {
            background: #f0fdfa;
            color: #134e4a;
        }

        td small {
            color: #64748b;
        }

        .aksi {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .aksi form {
            margin: 0;
        }

        .aksi .btn {
            padding: 7px 11px;
            font-size: 12px;
        }

        @media(max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 600px) {
            body {
                padding: 15px;
            }

            .card {
                padding: 20px;
                border-radius: 14px;
            }

            h1 {
                font-size: 25px;
            }

            .kategori {
                margin-top: 24px;
            }

            .kategori h2 {
                font-size: 20px;
            }

            .jadwal {
                padding: 16px;
            }

            .jadwal h3 {
                font-size: 17px;
                overflow-wrap: anywhere;
            }

            .info {
                font-size: 14px;
                overflow-wrap: anywhere;
            }
        }

        @media(max-width: 380px) {
            body {
                padding: 10px;
            }

            .card {
                padding: 15px;
            }

            h1 {
                font-size: 21px;
            }

            .kategori h2 {
                font-size: 18px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>

<body>

@php
    $role = strtolower(trim((string) session('role', 'siswa')));

    $dashboardUrl = match ($role) {
        'guru' => route('dashboard.guru'),
        'admin' => route('dashboard.admin'),
        default => route('dashboard.siswa'),
    };

    $bisaKelola = $role === 'guru';
@endphp

<div class="card">

    <div class="page-nav">
        <a href="{{ $dashboardUrl }}" class="btn-kembali">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <h1>Jadwal Ekstrakurikuler</h1>

    <p>Informasi hari, tanggal, tahun, dan kegiatan ekstrakurikuler siswa.</p>

    @if (session('success'))
        <div class="pesan sukses">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- EKSTRAKURIKULER WAJIB --}}
    <section class="kategori">

        <h2>Ekstrakurikuler Wajib</h2>

        @forelse($jadwalWajib as $item)

            <div class="jadwal">

                <span class="badge">WAJIB</span>

                <h3>{{ $item->nama_kegiatan }}</h3>

                <div class="info">
                    <i class="fa-solid fa-calendar-days"></i>
                    <strong>
                        @if($item->tanggal)
                            {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        @else
                            Tanggal belum ditentukan
                        @endif
                    </strong>
                </div>

                <div class="info">
                    <i class="fa-solid fa-clock"></i>
                    {{ $item->jam_mulai ? substr($item->jam_mulai, 0, 5) : '-' }}
                    sampai {{ $item->jam_selesai ? substr($item->jam_selesai, 0, 5) : '-' }}
                </div>

                <div class="info">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $item->lokasi ?? 'Lokasi belum ditentukan' }}
                </div>

                @if($item->keterangan)
                    <p>{{ $item->keterangan }}</p>
                @endif

            </div>

        @empty

            <div class="kosong">
                Belum ada jadwal ekstrakurikuler wajib.
            </div>

        @endforelse

    </section>


    {{-- EKSTRAKURIKULER GABUNGAN --}}
    <section class="kategori">

        <h2>Ekstrakurikuler Gabungan</h2>

        @forelse($jadwalGabungan as $item)

            <div class="jadwal">

                <span class="badge gabungan">GABUNGAN</span>

                <h3>{{ $item->nama_kegiatan }}</h3>

                <div class="info">
                    <i class="fa-solid fa-calendar-days"></i>
                    <strong>
                        @if($item->tanggal)
                            {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        @else
                            Tanggal belum ditentukan
                        @endif
                    </strong>
                </div>

                <div class="info">
                    <i class="fa-solid fa-clock"></i>
                    {{ $item->jam_mulai ? substr($item->jam_mulai, 0, 5) : '-' }}
                    sampai {{ $item->jam_selesai ? substr($item->jam_selesai, 0, 5) : '-' }}
                </div>

                <div class="info">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $item->lokasi ?? 'Lokasi belum ditentukan' }}
                </div>

                @if($item->keterangan)
                    <p>{{ $item->keterangan }}</p>
                @endif

            </div>

        @empty

            <div class="kosong">
                Belum ada jadwal ekstrakurikuler gabungan.
            </div>

        @endforelse

    </section>

    @if ($bisaKelola)

        {{-- FORM TAMBAH / EDIT JADWAL --}}
        <section class="kelola">

            <h2 id="judulForm">Tambah Jadwal Kegiatan</h2>

            <p>Atur jadwal kegiatan ekstrakurikuler yang akan tampil untuk siswa.</p>

            @if ($errors->any())
                <div class="pesan gagal">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form
                id="formJadwal"
                action="{{ route('guru.jadwal.store') }}"
                method="POST"
            >
                @csrf
                <input type="hidden" name="_method" id="metodeForm" value="POST">

                <div class="form-grid">

                    <label>
                        Nama Kegiatan
                        <input
                            type="text"
                            name="nama_kegiatan"
                            id="inputNamaKegiatan"
                            value="{{ old('nama_kegiatan') }}"
                            placeholder="Contoh: Latihan Futsal"
                            required
                        >
                    </label>

                    <label>
                        Jenis Ekstrakurikuler
                        <select name="jenis" id="inputJenis" required>
                            <option value="wajib" @selected(old('jenis') === 'wajib')>Wajib</option>
                            <option value="gabungan" @selected(old('jenis') === 'gabungan')>Gabungan</option>
                        </select>
                    </label>

                    <label>
                        Tanggal
                        <input
                            type="date"
                            name="tanggal"
                            id="inputTanggal"
                            value="{{ old('tanggal') }}"
                            required
                        >
                    </label>

                    <label>
                        Lokasi
                        <input
                            type="text"
                            name="lokasi"
                            id="inputLokasi"
                            value="{{ old('lokasi') }}"
                            placeholder="Contoh: Lapangan Sekolah"
                            required
                        >
                    </label>

                    <label>
                        Jam Mulai
                        <input
                            type="time"
                            name="jam_mulai"
                            id="inputJamMulai"
                            value="{{ old('jam_mulai') }}"
                            required
                        >
                    </label>

                    <label>
                        Jam Selesai
                        <input
                            type="time"
                            name="jam_selesai"
                            id="inputJamSelesai"
                            value="{{ old('jam_selesai') }}"
                            required
                        >
                    </label>

                    <label class="full">
                        Keterangan (opsional)
                        <textarea
                            name="keterangan"
                            id="inputKeterangan"
                            rows="2"
                            placeholder="Informasi tambahan kegiatan"
                        >{{ old('keterangan') }}</textarea>
                    </label>

                </div>

                <div class="form-aksi">
                    <button type="submit" class="btn">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span id="teksTombol">Simpan Jadwal</span>
                    </button>

                    <button type="button" class="btn btn-secondary" id="batalEdit" hidden>
                        <i class="fa-solid fa-xmark"></i>
                        Batal Edit
                    </button>
                </div>

            </form>

        </section>

        {{-- DAFTAR SELURUH JADWAL --}}
        <section class="kelola">

            <h2>Daftar Jadwal Kegiatan</h2>

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>Kegiatan</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($semuaJadwal as $item)

                            <tr>
                                <td>
                                    {{ $item->nama_kegiatan }}
                                    @if ($item->keterangan)
                                        <br><small>{{ $item->keterangan }}</small>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge {{ $item->jenis === 'gabungan' ? 'gabungan' : '' }}">
                                        {{ strtoupper($item->jenis ?? '-') }}
                                    </span>
                                </td>

                                <td>
                                    {{ $item->tanggal
                                        ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y')
                                        : '-' }}
                                </td>

                                <td>
                                    {{ $item->jam_mulai ? substr($item->jam_mulai, 0, 5) : '-' }}
                                    -
                                    {{ $item->jam_selesai ? substr($item->jam_selesai, 0, 5) : '-' }}
                                </td>

                                <td>{{ $item->lokasi ?? '-' }}</td>

                                <td>
                                    <div class="aksi">

                                        <button
                                            type="button"
                                            class="btn btn-edit edit-jadwal"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama_kegiatan }}"
                                            data-jenis="{{ $item->jenis }}"
                                            data-tanggal="{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : '' }}"
                                            data-mulai="{{ $item->jam_mulai ? substr($item->jam_mulai, 0, 5) : '' }}"
                                            data-selesai="{{ $item->jam_selesai ? substr($item->jam_selesai, 0, 5) : '' }}"
                                            data-lokasi="{{ $item->lokasi }}"
                                            data-keterangan="{{ $item->keterangan }}"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                            Edit
                                        </button>

                                        <form
                                            action="{{ route('guru.jadwal.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus jadwal ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="kosong">
                                    Belum ada jadwal kegiatan. Silakan tambahkan jadwal di atas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    @endif

</div>

@if ($bisaKelola)
    <script>
        (function () {
            const form = document.getElementById('formJadwal');

            if (!form) {
                return;
            }

            const urlSimpan = @json(route('guru.jadwal.store'));
            const urlDasarEdit = @json(url('/guru/jadwal'));
            const judulForm = document.getElementById('judulForm');
            const metodeForm = document.getElementById('metodeForm');
            const teksTombol = document.getElementById('teksTombol');
            const batalEdit = document.getElementById('batalEdit');

            const isi = (id, nilai) => {
                document.getElementById(id).value = nilai || '';
            };

            document.querySelectorAll('.edit-jadwal').forEach((tombol) => {
                tombol.addEventListener('click', () => {
                    form.action = urlDasarEdit + '/' + tombol.dataset.id;
                    metodeForm.value = 'PUT';

                    isi('inputNamaKegiatan', tombol.dataset.nama);
                    isi('inputJenis', tombol.dataset.jenis);
                    isi('inputTanggal', tombol.dataset.tanggal);
                    isi('inputJamMulai', tombol.dataset.mulai);
                    isi('inputJamSelesai', tombol.dataset.selesai);
                    isi('inputLokasi', tombol.dataset.lokasi);
                    isi('inputKeterangan', tombol.dataset.keterangan);

                    judulForm.textContent = 'Edit Jadwal Kegiatan';
                    teksTombol.textContent = 'Simpan Perubahan';
                    batalEdit.hidden = false;

                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            if (batalEdit) {
                batalEdit.addEventListener('click', () => {
                    form.reset();
                    form.action = urlSimpan;
                    metodeForm.value = 'POST';
                    judulForm.textContent = 'Tambah Jadwal Kegiatan';
                    teksTombol.textContent = 'Simpan Jadwal';
                    batalEdit.hidden = true;
                });
            }
        })();
    </script>
@endif

    <script src="{{ asset('js/mobile.js') }}"></script>
</body>
</html>
