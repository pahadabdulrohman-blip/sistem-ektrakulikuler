<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f4f7fb;
}


/* SIDEBAR */

.sidebar{
    position:fixed;
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,#212529,#000);
    color:white;
    padding:25px 18px;
    overflow-y:auto;
}

.logo{
    text-align:center;
    margin-bottom:35px;
}

.logo i{
    font-size:38px;
}

.logo h2{
    margin-top:8px;
}

.menu a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    margin-bottom:8px;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

.menu a:hover,
.menu .active{
    background:rgba(255,255,255,.15);
}


/* NOTIFIKASI */

.notification-link{
    position:relative;
}

.notification-badge{
    margin-left:auto;
    min-width:22px;
    height:22px;
    padding:0 6px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#dc3545;
    color:white;

    border-radius:20px;

    font-size:11px;
    font-weight:700;
}


/* CONTENT */

.content{
    margin-left:250px;
    padding:35px;
}

.header{
    background:white;
    padding:25px;
    border-radius:15px;
    margin-bottom:25px;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header h1{
    color:#212529;
}

.header p{
    color:#777;
    margin-top:5px;
}

.notification-top{
    text-decoration:none;
    color:#212529;

    width:48px;
    height:48px;

    border-radius:12px;

    background:#f1f3f5;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:20px;

    position:relative;
}

.notification-top:hover{
    background:#e9ecef;
}

.notification-top .notification-badge{
    position:absolute;
    top:-5px;
    right:-5px;
}


/* CARDS */

.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,.05);
}

.stat{
    display:flex;
    align-items:center;
    gap:15px;
}

.icon{
    width:55px;
    height:55px;
    background:#e9ecef;
    color:#212529;
    border-radius:12px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:22px;
}

.stat h2{
    color:#212529;
}

.stat p{
    color:#777;
    font-size:13px;
}


/* GRID */

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:15px 0;

    border-bottom:1px solid #eee;
}

.badge{
    padding:5px 10px;
    background:#e9ecef;
    border-radius:20px;
    font-size:12px;
}


/* NOTIFICATION CARD */

.notification-card{
    margin-top:25px;
}

.notification-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.notification-header h2{
    font-size:20px;
}

.view-all{
    color:#08718b;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}

.request{
    display:flex;
    align-items:center;
    gap:15px;

    padding:15px 0;

    border-bottom:1px solid #eee;
}

.request-icon{
    width:45px;
    height:45px;

    border-radius:12px;

    background:#fff3cd;
    color:#856404;

    display:flex;
    align-items:center;
    justify-content:center;
}

.request-info{
    flex:1;
}

.request-info strong{
    display:block;
    color:#212529;
}

.request-info span{
    font-size:12px;
    color:#777;
}

.status{
    padding:5px 10px;
    border-radius:20px;

    background:#fff3cd;
    color:#856404;

    font-size:11px;
}


/* RESPONSIVE */

@media(max-width:1100px){

    .cards{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:900px){

    .grid{
        grid-template-columns:1fr;
    }

}

@media(max-width:600px){

    .sidebar{
        width:70px;
    }

    .logo h2,
    .menu span{
        display:none;
    }

    .menu a{
        justify-content:center;
    }

    .notification-badge{
        position:absolute;
        top:0;
        right:0;
    }

    .content{
        margin-left:70px;
        padding:20px;
    }

    .cards{
        grid-template-columns:1fr;
    }

    .header{
        padding:20px;
    }

    .header h1{
        font-size:22px;
    }

    .header p{
        font-size:12px;
    }

}

</style>

</head>

<body>


@php

    $jumlahPermintaan = \App\Models\PasswordRequest::where(
        'status',
        'menunggu'
    )->count();

@endphp


<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-user-shield"></i>

        <h2>ADMIN</h2>

    </div>


    <div class="menu">


        <a href="{{ route('dashboard.admin') }}" class="active">

            <i class="fa-solid fa-house"></i>

            <span>Dashboard</span>

        </a>


        <a href="{{ route('admin.ekstrakurikuler') }}">
            <i class="fa-solid fa-people-group"></i>

            <span>Ekstrakurikuler</span>

        </a>


        <a href="{{ route('penilaian') }}">

            <i class="fa-solid fa-star"></i>

            <span>Penilaian</span>

        </a>


        <a href="{{ route('admin.laporan') }}">

            <i class="fa-solid fa-file-lines"></i>

            <span>Laporan</span>

        </a>


      <a href="{{ route('admin.profil') }}">

            <i class="fa-solid fa-user"></i>

            <span>Profil</span>

        </a>


        <!-- PERMINTAAN PASSWORD -->

        <a href="{{ route('admin.password.requests') }}"
           class="notification-link">

            <i class="fa-solid fa-bell"></i>

            <span>Permintaan Password</span>


            @if($jumlahPermintaan > 0)

                <span class="notification-badge">
                    {{ $jumlahPermintaan }}
                </span>

            @endif

        </a>


        <a href="{{ route('login') }}">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>Logout</span>

        </a>


    </div>

</aside>
<a href="{{ route('admin.ekstrakurikuler') }}">
    <i class="fa-solid fa-futbol"></i>
    <span>Ekstrakurikuler</span>
</a>
<a href="{{ route('admin.penilaian') }}">
    <i class="fa-solid fa-star"></i>
    <span>Penilaian</span>
</a>
<a href="{{ route('admin.laporan') }}">
    <i class="fa-solid fa-file-lines"></i>
    <span>Laporan</span>
</a>
<a href="{{ route('admin.profil') }}">
    <i class="fa-solid fa-user"></i>
    <span>Profil</span>
</a>




<!-- CONTENT -->

<main class="content">


    <!-- HEADER -->

    <div class="header">

        <div>

            <h1>Dashboard Admin</h1>

            <p>
                Kelola seluruh data Sistem Ekstrakurikuler Sekolah.
            </p>

        </div>


        <!-- ICON NOTIFIKASI -->

        <a href="{{route('admin.password.requests') }}"
   class="notification-top">
            <i class="fa-solid fa-bell"></i>


            @if($jumlahPermintaan > 0)

                <span class="notification-badge">
                    {{ $jumlahPermintaan }}
                </span>

            @endif

        </a>

    </div>



    <!-- STATISTIK -->

    <div class="cards">


        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-users"></i>

            </div>

            <div>

                <h2>350</h2>

                <p>Total Siswa</p>

            </div>

        </div>



        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-chalkboard-user"></i>

            </div>

            <div>

                <h2>25</h2>

                <p>Total Guru</p>

            </div>

        </div>



        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-people-group"></i>

            </div>

            <div>

                <h2>9</h2>

                <p>Ekstrakurikuler</p>

            </div>

        </div>



        <div class="card stat">

            <div class="icon">

                <i class="fa-solid fa-star"></i>

            </div>

            <div>

                <h2>1.250</h2>

                <p>Data Penilaian</p>

            </div>

        </div>


    </div>



    <!-- DATA SISTEM -->

    <div class="grid">


        <div class="card">

            <h2>Data Sistem</h2>


            <div class="item">

                <span>Total Siswa</span>

                <strong>350</strong>

            </div>


            <div class="item">

                <span>Total Guru</span>

                <strong>25</strong>

            </div>


            <div class="item">

                <span>Ekstrakurikuler</span>

                <strong>9</strong>

            </div>


            <div class="item">

                <span>Penilaian</span>

                <strong>1.250</strong>

            </div>

        </div>



        <!-- STATUS -->

        <div class="card">

            <h2>Status Sistem</h2>


            <div class="item">

                <span>Database</span>

                <span class="badge">
                    Aktif
                </span>

            </div>


            <div class="item">

                <span>Sistem</span>

                <span class="badge">
                    Online
                </span>

            </div>


            <div class="item">

                <span>Server</span>

                <span class="badge">
                    Aktif
                </span>

            </div>


            <div class="item">

                <span>Backup</span>

                <span class="badge">
                    Tersedia
                </span>

            </div>

        </div>


    </div>



    <!-- NOTIFIKASI PERMINTAAN PASSWORD -->

    <div class="card notification-card">

        <div class="notification-header">

            <h2>
                <i class="fa-solid fa-bell"></i>
                Permintaan Ubah Password
            </h2>


           <a href="{{ route('admin.password.requests') }}"
         class="view-all">
           Lihat Semua
          </a>
        </div>


        @php

            $permintaanTerbaru =
                \App\Models\PasswordRequest::latest()
                ->take(5)
                ->get();

        @endphp


        @forelse($permintaanTerbaru as $item)


            <div class="request">


                <div class="request-icon">

                    <i class="fa-solid fa-key"></i>

                </div>


                <div class="request-info">

                    <strong>
                        {{ $item->username }}
                    </strong>

                    <span>

                        Role:
                        {{ ucfirst($item->role) }}

                        &nbsp; • &nbsp;

                        {{ $item->created_at->format('d/m/Y H:i') }}

                    </span>

                </div>


                <span class="status">

                    {{ ucfirst($item->status) }}

                </span>


            </div>


        @empty


            <div style="
                text-align:center;
                padding:30px;
                color:#777;
            ">

                <i class="fa-regular fa-bell-slash"
                   style="
                    font-size:30px;
                    margin-bottom:10px;
                 ">
                </i>

                <p>
                    Belum ada permintaan ubah password.
                </p>

            </div>


        @endforelse


    </div>


</main>


</body>

</html>