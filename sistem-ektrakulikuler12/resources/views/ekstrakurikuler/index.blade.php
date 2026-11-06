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

        @media (max-width: 650px) {
            .sidebar {
                display: none;
            }

            .main {
                margin-left: 0;
            }

            .content {
                padding: 25px 18px;
            }

            .topbar {
                padding: 18px;
            }

            .top-title {
                font-size: 17px;
            }

            .heading {
                display: block;
            }

            h1 {
                font-size: 29px;
            }

            .counter {
                display: inline-block;
                margin: 0 0 20px;
            }

            .card {
                padding: 20px;
                flex-wrap: wrap;
            }

            .icon {
                width: 60px;
                height: 60px;
                min-width: 60px;
                font-size: 28px;
            }

            .info-ekskul h2 {
                font-size: 19px;
            }

            .aksi-pilihan {
                align-items: stretch;
                flex-direction: column;
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
        <a href="{{ route('laporan') }}">📄 &nbsp; Laporan</a>
        <a href="{{ route('profil') }}">👤 &nbsp; Profil</a>
    </nav>
</aside>

<main class="main">
    <header class="topbar">
        <div class="top-title">← &nbsp; Daftar Ekstrakurikuler</div>

        <div class="user">
            <strong>Fahad Abdul Rohman</strong><br>
            Siswa - XI RPL 1
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
            ℹ️ Kamu hanya dapat memilih <strong>maksimal 2 ekstrakurikuler</strong>.
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

            <div class="card" data-name="futsal">
                <div class="icon">⚽</div>
                <div class="info-ekskul">
                    <h2>Futsal</h2>
                    <p>
                        Olahraga<br>
                        Jadwal: Senin &amp; Kamis, 15.00<br>
                        Pembina: Pak A
                    </p>
                </div>
                <button type="button" class="btn-pilih"
                    onclick="pilihEkskul(this, 'Futsal')">Pilih</button>
            </div>

            <div class="card" data-name="seni">
                <div class="icon">🎨</div>
                <div class="info-ekskul">
                    <h2>Seni</h2>
                    <p>
                        Seni &amp; Budaya<br>
                        Jadwal: Selasa, 15.00<br>
                        Pembina: Bu B
                    </p>
                </div>
                <button type="button" class="btn-pilih"
                    onclick="pilihEkskul(this, 'Seni')">Pilih</button>
            </div>

            <div class="card" data-name="coding">
                <div class="icon">💻</div>
                <div class="info-ekskul">
                    <h2>Coding</h2>
                    <p>
                        Teknologi<br>
                        Jadwal: Rabu &amp; Jumat, 15.00<br>
                        Pembina: Pak C
                    </p>
                </div>
                <button type="button" class="btn-pilih"
                    onclick="pilihEkskul(this, 'Coding')">Pilih</button>
            </div>

            <div class="card" data-name="pencak silat">
                <div class="icon">🥋</div>
                <div class="info-ekskul">
                    <h2>Pencak Silat</h2>
                    <p>
                        Olahraga<br>
                        Jadwal: Senin &amp; Rabu, 15.00<br>
                        Pembina: Pak D
                    </p>
                </div>
                <button type="button" class="btn-pilih"
                    onclick="pilihEkskul(this, 'Pencak Silat')">Pilih</button>
            </div>

            <div class="card" data-name="basket">
                <div class="icon">🏀</div>
                <div class="info-ekskul">
                    <h2>Basket</h2>
                    <p>
                        Olahraga<br>
                        Jadwal: Selasa &amp; Kamis, 15.00<br>
                        Pembina: Pak E
                    </p>
                </div>
                <button type="button" class="btn-pilih"
                    onclick="pilihEkskul(this, 'Basket')">Pilih</button>
            </div>

            <div class="card" data-name="voli">
                <div class="icon">🏐</div>
                <div class="info-ekskul">
                    <h2>Voli</h2>
                    <p>
                        Olahraga<br>
                        Jadwal: Rabu &amp; Jumat, 15.00<br>
                        Pembina: Bu F
                    </p>
                </div>
                <button type="button" class="btn-pilih"
                    onclick="pilihEkskul(this, 'Voli')">Pilih</button>
            </div>

        </div>

        <div id="pesanKosong" class="kosong">
            Ekstrakurikuler tidak ditemukan.
        </div>

        <div class="aksi-pilihan">
            <button type="button" id="btnKunci"
                onclick="kunciPilihan()" disabled>
                🔒 Kunci Pilihan
            </button>

            <button type="button" id="btnBatal"
                onclick="batalkanSemua()" disabled>
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

    function pilihEkskul(button, nama) {
        if (terkunci) {
            alert('Pilihan sudah dikunci.');
            return;
        }

        if (pilihan.includes(nama)) {
            pilihan = pilihan.filter(item => item !== nama);
        } else {
            if (pilihan.length >= 2) {
                alert('Maksimal memilih 2 ekstrakurikuler.');
                return;
            }

            pilihan.push(nama);
        }

        updateButton();
    }

    function updateButton() {
        document.getElementById('jumlahDipilih').textContent =
            pilihan.length;

        document.querySelectorAll('.btn-pilih').forEach(button => {
            const card = button.closest('.card');
            const nama = card.querySelector('h2').textContent.trim();
            const sudahDipilih = pilihan.includes(nama);

            card.classList.toggle('selected', sudahDipilih);
            button.classList.toggle('selected', sudahDipilih);
            button.textContent = sudahDipilih ? '✓ Dipilih' : 'Pilih';

            const nonaktif = terkunci ||
                (pilihan.length >= 2 && !sudahDipilih);

            button.disabled = nonaktif;
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

    function kunciPilihan() {
        if (pilihan.length === 0) {
            alert('Pilih minimal satu ekstrakurikuler.');
            return;
        }

        const yakin = confirm(
            'Yakin ingin mengunci pilihan ' +
            pilihan.join(' dan ') + '?'
        );

        if (!yakin) return;

        terkunci = true;
        updateButton();

        alert('Pilihan berhasil dikunci pada halaman ini.');
    }

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

    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.trim().toLowerCase();
        let jumlahTampil = 0;

        document.querySelectorAll('.card').forEach(card => {
            const nama = card.dataset.name;
            const cocok = nama.includes(keyword);

            card.style.display = cocok ? 'flex' : 'none';

            if (cocok) jumlahTampil++;
        });

        document.getElementById('pesanKosong').style.display =
            jumlahTampil === 0 ? 'block' : 'none';
    });

    updateButton();
</script>

</body>
</html>