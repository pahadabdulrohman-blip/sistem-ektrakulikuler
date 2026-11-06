<?php

namespace App\Http\Controllers;

use App\Models\JadwalEkstrakurikuler;

class JadwalEkstrakurikulerController extends Controller
{
    public function index()
    {
        if (!session('login')) {
            return redirect()->route('login');
        }

        if (!in_array(session('role'), ['admin', 'guru', 'siswa'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $jadwalWajib = JadwalEkstrakurikuler::where('jenis', 'wajib')
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        $jadwalGabungan = JadwalEkstrakurikuler::where('jenis', 'gabungan')
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('jadwal-ekstrakurikuler', compact(
            'jadwalWajib',
            'jadwalGabungan'
        ));
    }
}
