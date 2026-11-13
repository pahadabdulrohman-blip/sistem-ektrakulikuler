
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Ekstrakurikuler</title>

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
            max-width: 900px;
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

        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: #ccfbf1;
            color: #0f766e;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .kosong {
            background: #f8fafc;
            padding: 18px;
            border-radius: 8px;
            color: #64748b;
        }

        .kembali {
            display: inline-block;
            margin-top: 20px;
            color: #0f766e;
            font-weight: bold;
            text-decoration: none;
        }

        .kembali:hover {
            text-decoration: underline;
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
</head>

<body>

<div class="card">

    <h1>Jadwal Ekstrakurikuler</h1>

    <p>Informasi hari, tanggal, tahun, dan kegiatan ekstrakurikuler siswa.</p>

    {{-- EKSTRAKURIKULER WAJIB --}}
    <section class="kategori">

        <h2>Ekstrakurikuler Wajib</h2>

        @forelse($jadwalWajib as $item)

            <div class="jadwal">

                <span class="badge">WAJIB</span>

                <h3>{{ $item->nama_kegiatan }}</h3>

                <div class="info">
                    📅 <strong>
                        @if($item->tanggal)
                            {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        @else
                            Tanggal belum ditentukan
                        @endif
                    </strong>
                </div>

                <div class="info">
                    🕒 {{ $item->jam_mulai ?? '-' }}
                    sampai {{ $item->jam_selesai ?? '-' }}
                </div>

                <div class="info">
                    📍 {{ $item->lokasi ?? 'Lokasi belum ditentukan' }}
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

                <span class="badge">GABUNGAN</span>

                <h3>{{ $item->nama_kegiatan }}</h3>

                <div class="info">
                    📅 <strong>
                        @if($item->tanggal)
                            {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        @else
                            Tanggal belum ditentukan
                        @endif
                    </strong>
                </div>

                <div class="info">
                    🕒 {{ $item->jam_mulai ?? '-' }}
                    sampai {{ $item->jam_selesai ?? '-' }}
                </div>

                <div class="info">
                    📍 {{ $item->lokasi ?? 'Lokasi belum ditentukan' }}
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

    <a href="{{ url('/dashboard-siswa') }}" class="kembali">
        ← Kembali ke Dashboard
    </a>

</div>

</body>
</html>
