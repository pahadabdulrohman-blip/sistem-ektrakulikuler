<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminDataController extends Controller
{
    /**
     * Halaman data guru beserta jumlah totalnya.
     */
    public function guru()
    {
        $pengguna = User::where('role', 'guru')
            ->orderBy('name')
            ->get();

        return view('admin.data-pengguna', [
            'roleAktif' => 'guru',
            'judul' => 'Data Guru',
            'deskripsi' => 'Daftar seluruh guru yang terdaftar di sistem.',
            'pengguna' => $pengguna,
            'total' => $pengguna->count(),
            'jumlahPerKelas' => null,
        ]);
    }

    /**
     * Halaman data siswa beserta jumlah total dan sebaran per kelas.
     */
    public function siswa()
    {
        $pengguna = User::where('role', 'siswa')
            ->orderBy('name')
            ->get();

        $jumlahPerKelas = $pengguna
            ->countBy(fn ($item) => $item->kelas_saat_ini ?: 'Belum diisi')
            ->sortKeys();

        return view('admin.data-pengguna', [
            'roleAktif' => 'siswa',
            'judul' => 'Data Siswa',
            'deskripsi' => 'Daftar seluruh siswa yang terdaftar di sistem.',
            'pengguna' => $pengguna,
            'total' => $pengguna->count(),
            'jumlahPerKelas' => $jumlahPerKelas,
        ]);
    }
}
