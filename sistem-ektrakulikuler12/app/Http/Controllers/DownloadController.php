<?php

namespace App\Http\Controllers;

class DownloadController extends Controller
{
    /**
     * Halaman unduh APK publik.
     */
    public function index()
    {
        $nama = (string) config('apk.nama');

        return view('download', [
            'nama' => $nama,
            'versi' => (string) config('apk.versi'),
            'ukuran' => (string) config('apk.ukuran'),
            'url' => asset('storage/downloads/'.rawurlencode($nama)),
            'sha256' => (string) config('apk.sha256'),
        ]);
    }
}
