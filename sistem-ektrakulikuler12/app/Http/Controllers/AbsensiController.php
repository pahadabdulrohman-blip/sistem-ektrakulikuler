<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiSiswa;

class AbsensiController extends Controller
{
    // Memeriksa hak akses Admin dan Guru
    private function cekAkses()
    {
        if (!session('login')) {
            return redirect()->route('login');
        }

        if (!in_array(session('role'), ['admin', 'guru'], true)) {
            abort(403, 'Kamu tidak memiliki akses ke halaman absensi.');
        }

        return null;
    }

    // Menampilkan data absensi
    public function index()
    {
        $akses = $this->cekAkses();

        if ($akses) {
            return $akses;
        }

        $absensi = AbsensiSiswa::latest('tanggal')->get();

        return view('absensi.index', compact('absensi'));
    }

    // Menyimpan data absensi
    public function simpan(Request $request)
    {
        $akses = $this->cekAkses();

        if ($akses) {
            return $akses;
        }

        $data = $request->validate([
            'username' => 'required|string|max:255',
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        AbsensiSiswa::updateOrCreate(
            [
                'username' => $data['username'],
                'nama_kegiatan' => $data['nama_kegiatan'],
                'tanggal' => $data['tanggal'],
            ],
            [
                'status' => $data['status'],
                'dicatat_oleh' => session('username'),
            ]
        );

        return back()->with('success', 'Absensi berhasil disimpan!');
    }
}
