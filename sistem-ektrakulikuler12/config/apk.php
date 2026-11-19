<?php

return [

    /*
    |--------------------------------------------------------------------------
    | APK yang disajikan lewat /download
    |--------------------------------------------------------------------------
    |
    | File aslinya 101 MB, sedikit melebihi batas 100 MB per file GitHub.
    | Karena itu disimpan terpecah di folder apk-parts/ lalu disatukan otomatis
    | oleh ApkPublishProvider ke storage/app/public/downloads/ saat request
    | web pertama. Hash dipakai untuk memastikan hasil gabungan tidak rusak.
    |
    */

    'nama' => 'Alight_Motion_alightmotionsapps.com_063034.apk',
    'versi' => '5.0.281',
    'ukuran' => '101,1 MB',
    'jumlah_part' => 3,
    'sha256' => 'ef3bf2a975665d6934ca6f09dd604185fbd3ed083b288d7bfcdf1a9c5d66f0f3',

];
