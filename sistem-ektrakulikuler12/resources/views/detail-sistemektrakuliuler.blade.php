@extends('app')

@section('title', 'Detail Ekstrakurikuler')

@section('content')

<header class="header">

    <a href="{{ route('ekstrakurikuler') }}"
       class="back">

        <i class="fa-solid fa-chevron-left"></i>

    </a>

    <div class="header-title">
        Detail Ekstrakurikuler
    </div>

    <div class="header-icon"></div>

</header>


<main class="content">

    <div style="
        height:150px;
        background:#dceaf2;
        border-radius:15px;
        display:flex;
        justify-content:center;
        align-items:center;
        font-size:65px;
        margin-bottom:20px;
    ">
        ⚽
    </div>


    <h1 class="page-title">
        {{ $data['nama'] }}
    </h1>

    <p class="subtitle">
        {{ $data['kategori'] }}
    </p>


    <div class="card">

        <p>
            <i class="fa-solid fa-user"></i>
            &nbsp; Pembina:
            <b>{{ $data['pembina'] }}</b>
        </p>

        <br>

        <p>
            <i class="fa-solid fa-calendar"></i>
            &nbsp; Jadwal:
            {{ $data['jadwal'] }}
        </p>

        <br>

        <p>
            <i class="fa-solid fa-location-dot"></i>
            &nbsp; Tempat:
            {{ $data['tempat'] }}
        </p>

    </div>


    <h3 style="margin-top:25px">
        Deskripsi
    </h3>

    <p style="
        color:#607f92;
        line-height:1.6;
        margin-top:10px;
    ">
        {{ $data['deskripsi'] }}
    </p>


    <a href="#"
       class="btn"
       style="margin-top:25px">

        <i class="fa-solid fa-user-plus"></i>
        &nbsp; Daftar Sekarang

    </a>

</main>

@endsection