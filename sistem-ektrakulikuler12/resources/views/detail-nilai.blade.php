@extends('app')

@section('title', 'Detail Penilaian')

@section('content')

<header class="header">

    <a href="{{ route('penilaian') }}"
       class="back">

        <i class="fa-solid fa-chevron-left"></i>

    </a>

    <div class="header-title">
        Detail Penilaian
    </div>

    <div class="header-icon"></div>

</header>


<main class="content">

    <h1 class="page-title">
        {{ $data['nama'] }}
    </h1>

    <p class="subtitle">
        Nilai Akhir: {{ $data['nilai'] }}
    </p>


    <div class="nilai-box">

        <p>Nilai Rata-rata</p>

        <h1>
            {{ $data['nilai'] }}
        </h1>

        <span class="grade">
            {{ $data['grade'] }}
        </span>

    </div>


    <h3 style="margin-top:25px">
        Komponen Penilaian
    </h3>


    <div class="card">

        <p>
            Kedisiplinan
            <b style="float:right">
                {{ $data['kedisiplinan'] }}
            </b>
        </p>

        <hr><br>

        <p>
            Kerja Sama
            <b style="float:right">
                {{ $data['kerja_sama'] }}
            </b>
        </p>

        <hr><br>

        <p>
            Keaktifan
            <b style="float:right">
                {{ $data['keaktifan'] }}
            </b>
        </p>

        <hr><br>

        <p>
            Tanggung Jawab
            <b style="float:right">
                {{ $data['tanggung_jawab'] }}
            </b>
        </p>

        <hr><br>

        <p>
            Sikap
            <b style="float:right">
                {{ $data['sikap'] }}
            </b>
        </p>

    </div>


    <h3 style="margin-top:25px">
        Catatan Pembina
    </h3>

    <div class="card">

        <p style="
            color:#66869a;
            line-height:1.6;
        ">
            Terus tingkatkan keaktifan dan konsistensi latihan.
        </p>

        <br>

        <p>
            Pak A
        </p>

    </div>

</main>


@endsection