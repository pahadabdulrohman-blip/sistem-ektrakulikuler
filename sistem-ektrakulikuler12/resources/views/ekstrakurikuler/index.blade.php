
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #eef8fd;
            color: #075985;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 272px;
            height: 100vh;
            background: linear-gradient(180deg, #0785bb, #08658c);
            color: white;
            padding: 28px 20px;
            z-index: 10;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 12px 30px;
            border-bottom: 1px solid rgba(255,255,255,.25);
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,.18);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .logo-text {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.3;
        }

        .menu-title {
            font-size: 11px;
            margin: 30px 14px 15px;
            opacity: .8;
        }

        .menu a {
            display: block;
            padding: 14px 18px;
            margin-bottom: 7px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255,255,255,.17);
        }

        .main {
            margin-left: 272px;
            min-height: 100vh;
        }

        .topbar {
            min-height: 80px;
            background: #0785bb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 40px;
            gap: 20px;
        }

        .top-title {
            font-size: 22px;
            font-weight: 700;
        }

        .user {
            text-align: right;
            font-size: 12px;
        }

        .content {
            padding: 48px 44px;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 36px;
            color: #075985;
        }

        .subtitle {
            color: #6590a8;
            margin-bottom: 25px;
        }

        .counter {
            background: white;
            border: 2px solid #d4eaf4;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .counter span {
            color: #0785bb;
        }

        .info {
            background: #e0f2fe;
            border-left: 5px solid #0785bb;
            padding: 15px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            color: #075985;
        }

        .search {
            width: 100%;
            height: 58px;
            background: white;
            border: 1px solid #cfe5ef;
            border-radius: 15px;
            padding: 0 20px;
            font-family: inherit;
            font-size: 15px;
            outline: none;
            margin-bottom: 30px;
        }

        .search:focus {
            border-color: #0785bb;
            box-shadow: 0 0 0 3px rgba(7,133,187,.1);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .card {
            background: white;
            border: 1px solid #d7eaf2;
            border-radius: 18px;
            padding: 28px;
            display: flex;
            align-items: center;
            gap: 22px;
            transition: .2s;
        }

        .card.selected {
            border: 2px solid #0785bb;
            background: #f0faff;
        }

        .icon {
            width: 80px;
            height: 80px;
            min-width: 80px;
            border-radius: 50%;
            background: #e3f4fb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
        }

        .info-ekskul {
            flex: 1;
            min-width: 0;
        }

        .info-ekskul h2 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .info-ekskul p {
            color: #6590a8;
            font-size: 13px;
            line-height: 1.7;
        }

        .btn-pilih {
            border: none;
            background: #087fb3;
            color: white;
            padding: 11px 18px;
            border-radius: 9px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            min-width: 90px;
            transition: .2s;
        }

        .btn-pilih:hover:not(:disabled) {
            background: #066b98;
        }

        .btn-pilih.selected {
            background: #16a34a;
        }

        .btn-pilih:disabled {
            background: #cbd5e1;
            color: #64748b;
            cursor: not-allowed;
        }

        .aksi-pilihan {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding: 22px;
            background: white;
            border: 1px solid #d7eaf2;
            border-radius: 15px;
        }

        .aksi-pilihan button {
            border: none;
            border-radius: 9px;
            padding: 12px 18px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        #btnKunci {
            background: #087fb3;
            color: white;
        }

        #btnBatal {
            background: #fee2e2;
            color: #b91c1c;
        }

        .aksi-pilihan button:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        #statusPilihan {
            flex-basis: 100%;
            font-size: 13px;
            color: #6590a8;
        }

        .kosong {
            display: none;
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            color: #6590a8;
        }

        .data-kosong {
            grid-column: 1 / -1;
            background: white;
            padding: 40px 20px;
            border-radius: 15px;
            text-align: center;
            color: #6590a8;
        }

        @media (max-width: 1100px) {
            .sidebar {
                width: 220px;
            }

            .main {
                margin-left: 220px;
            }

            .content {
                padding: 32px 25px;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: sticky;
                top: 0;
                display: flex;
                align-items: center;
                gap: 8px;
                width: 100%;
                height: auto;
                padding: 12px 14px;
                z-index: 100;
                box-shadow: 0 6px 18px rgba(4, 66, 112, .2);
            }

            .logo {
                flex-shrink: 0;
                padding: 0 10px 0 0;
                border-right: 1px solid rgba(255, 255, 255, .25);
                border-bottom: 0;
            }

            .logo-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                font-size: 18px;
            }

            .logo-text {
                display: none;
            }

            .menu-title {
                display: none;
            }

            .menu {
                display: flex;
                gap: 6px;
                overflow-x: auto;
                padding: 3px 0;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
            }

            .menu a {
                flex: 0 0 auto;
                margin: 0;
                padding: 9px 12px;
                border-radius: 8px;
                font-size: 12px;
                white-space: nowrap;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                min-height: 62px;
                padding: 14px 16px;
                gap: 10px;
            }

            .top-title {
                font-size: 15px;
            }

            .user {
                font-size: 11px;
            }

            .content {
                padding: 20px 16px;
            }

            .heading {
                display: block;
            }

            h1 {
                font-size: 27px;
            }

            .subtitle {
                font-size: 13px;
            }

            .counter {
                display: inline-block;
                margin: 0 0 18px;
                font-size: 13px;
                padding: 9px 14px;
            }

            .info {
                padding: 13px 15px;
                font-size: 13px;
                margin-bottom: 18px;
            }

            .search {
                height: 50px;
                margin-bottom: 20px;
                font-size: 14px;
            }

            .grid {
                gap: 14px;
            }

            .card {
                padding: 18px;
                flex-wrap: wrap;
                align-items: flex-start;
                gap: 14px;
            }

            .icon {
                width: 54px;
                height: 54px;
                min-width: 54px;
                font-size: 25px;
            }

            .info-ekskul {
                flex: 1 1 calc(100% - 70px);
            }

            .info-ekskul h2 {
                font-size: 19px;
            }

            .info-ekskul p {
                font-size: 12px;
                line-height: 1.6;
            }

            .btn-pilih {
                width: 100%;
                padding: 12px;
            }

            .aksi-pilihan {
                align-items: stretch;
                flex-direction: column;
                padding: 16px;
            }

            .aksi-pilihan button {
                width: 100%;
            }
        }

        @media (max-width: 400px) {
            .content {
                padding: 16px 12px;
            }

            .topbar {
                padding: 12px;
            }

            .top-title {
                font-size: 13px;
            }

            .user {
                display: none;
            }
        }
    </style>
</head>

<body>

<aside class="sidebar">
    <div class="logo">
        <div class="logo-icon">🏫</div>
        <div class="logo-text">
            Sistem<br>Ekstrakurikuler
        </div>
    </div>

    <div class="menu-title">MENU UTAMA</div>

    <nav class="menu">
        <a href="{{ route('dashboard.siswa') }}">🏠 &nbsp; Dashboard</a>
        <a href="{{ route('ekstrakurikuler') }}" class="active">👥 &nbsp; Ekstrakurikuler</a>
        <a href="{{ route('penilaian') }}">⭐ &nbsp; Penilaian</a>
        <a href="{{ route('profil') }}">👤 &nbsp; Profil</a>
    </nav>
</aside>

<main class="main">

    <header class="topbar">
        <div class="top-title">← &nbsp; Daftar Ekstrakurikuler</div>

        <div class="user">
            <strong>{{ session('username') }}</strong><br>
            Siswa
        </div>
    </header>

    <section class="content">

        <div class="heading">
            <div>
                <h1>Ekstrakurikuler</h1>
                <p class="subtitle">
                    Pilih maksimal 2 ekstrakurikuler yang ingin kamu ikuti
                </p>
            </div>

            <div class="counter">
                Dipilih: <span id="jumlahDipilih">0</span> / 2
            </div>
        </div>

        <div class="info">
            ℹ️ Kamu hanya dapat memilih
            <strong>maksimal 2 ekstrakurikuler</strong>.
            Setelah memilih 2, pilihan lainnya akan dinonaktifkan.
        </div>

        <input
            type="text"
            id="search"
            class="search"
            placeholder="🔍 Cari ekstrakurikuler..."
            aria-label="Cari ekstrakurikuler"
        >

        <div class="grid" id="daftarEkskul">

            {{-- DATA DIAMBIL LANGSUNG DARI DATABASE --}}
            @forelse($ekskul as $item)

                <div class="card"
                     data-id="{{ $item->id }}"
                     data-name="{{ strtolower($item->nama_ekstrakurikuler) }}">

                    <div class="icon">
                        {{ $item->ikon ?: '⭐' }}
                    </div>

                    <div class="info-ekskul">

                        <h2>{{ $item->nama_ekstrakurikuler }}</h2>

                        <p>
                            {{ $item->deskripsi ?: 'Tidak ada deskripsi' }}<br>

                            Jadwal:
                            {{ $item->jadwal ?: 'Belum ditentukan' }}<br>

                            Pembina:
                            {{ $item->pembina ?: 'Belum ditentukan' }}<br>

                            Tempat:
                            {{ $item->tempat ?: 'Belum ditentukan' }}
                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn-pilih"
                        onclick="pilihEkskul(this)">
                        Pilih
                    </button>

                </div>

            @empty

                <div class="data-kosong">
                    <h3>Belum Ada Ekstrakurikuler</h3>
                    <p>Admin belum menambahkan data ekstrakurikuler.</p>
                </div>

            @endforelse

        </div>

        <div id="pesanKosong" class="kosong">
            Ekstrakurikuler tidak ditemukan.
        </div>

        <div class="aksi-pilihan">

            <button
                type="button"
                id="btnKunci"
                onclick="kunciPilihan()"
                disabled>
                🔒 Kunci Pilihan
            </button>

            <button
                type="button"
                id="btnBatal"
                onclick="batalkanSemua()"
                disabled>
                ↩ Batalkan Semua
            </button>

            <p id="statusPilihan" aria-live="polite">
                Status: Belum dikunci
            </p>

        </div>

    </section>
</main>

<script>
    let pilihan = [];
    let terkunci = false;

    // MEMILIH EKSTRAKURIKULER BERDASARKAN ID DATABASE
    function pilihEkskul(button) {

        if (terkunci) {
            alert('Pilihan sudah dikunci.');
            return;
        }

        const card = button.closest('.card');
        const id = card.dataset.id;

        if (pilihan.includes(id)) {

            pilihan = pilihan.filter(item => item !== id);

        } else {

            if (pilihan.length >= 2) {
                alert('Maksimal memilih 2 ekstrakurikuler.');
                return;
            }

            pilihan.push(id);
        }

        updateButton();
    }

    // MEMPERBARUI TAMPILAN PILIHAN
    function updateButton() {

        document.getElementById('jumlahDipilih').textContent =
            pilihan.length;

        document.querySelectorAll('#daftarEkskul .card').forEach(card => {

            const id = card.dataset.id;
            const sudahDipilih = pilihan.includes(id);
            const button = card.querySelector('.btn-pilih');

            card.classList.toggle('selected', sudahDipilih);

            button.classList.toggle('selected', sudahDipilih);

            button.textContent = sudahDipilih
                ? '✓ Dipilih'
                : 'Pilih';

            button.disabled = terkunci ||
                (pilihan.length >= 2 && !sudahDipilih);
        });

        document.getElementById('btnKunci').disabled =
            terkunci || pilihan.length === 0;

        document.getElementById('btnBatal').disabled =
            terkunci || pilihan.length === 0;

        document.getElementById('statusPilihan').textContent =
            terkunci
                ? 'Status: 🔒 Pilihan sudah dikunci'
                : 'Status: Belum dikunci';
    }

    // MENGUNCI PILIHAN
    function kunciPilihan() {

        if (pilihan.length === 0) {
            alert('Pilih minimal satu ekstrakurikuler.');
            return;
        }

        const namaPilihan = pilihan.map(id => {

            const card = document.querySelector(
                `.card[data-id="${id}"]`
            );

            return card.querySelector('h2').textContent.trim();
        });

        const yakin = confirm(
            'Yakin ingin mengunci pilihan ' +
            namaPilihan.join(' dan ') + '?'
        );

        if (!yakin) return;

        terkunci = true;

        updateButton();

        alert('Pilihan berhasil dikunci pada halaman ini.');
    }

    // MEMBATALKAN SEMUA PILIHAN
    function batalkanSemua() {

        if (terkunci) {
            alert('Pilihan sudah dikunci dan tidak dapat dibatalkan.');
            return;
        }

        if (pilihan.length === 0) return;

        if (!confirm('Batalkan semua pilihan ekstrakurikuler?')) {
            return;
        }

        pilihan = [];

        updateButton();
    }

    // FITUR PENCARIAN
    document.getElementById('search').addEventListener('input', function () {

        const keyword = this.value.trim().toLowerCase();

        let jumlahTampil = 0;

        document.querySelectorAll('#daftarEkskul .card').forEach(card => {

            const nama = card.dataset.name;

            const deskripsi = card.textContent.toLowerCase();

            const cocok = nama.includes(keyword) ||
                          deskripsi.includes(keyword);

            card.style.display = cocok ? 'flex' : 'none';

            if (cocok) {
                jumlahTampil++;
            }
        });

        document.getElementById('pesanKosong').style.display =
            jumlahTampil === 0 ? 'block' : 'none';
    });

    // TAMPILAN AWAL
    updateButton();
</script>

</body>
</html>
