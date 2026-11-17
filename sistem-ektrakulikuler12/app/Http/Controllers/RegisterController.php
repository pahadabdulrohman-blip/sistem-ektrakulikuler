<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    /**
     * Pendaftaran publik hanya untuk siswa.
     * Akun guru dibuat oleh admin melalui halaman Akun Guru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|ends_with:gmail.com|unique:users,email',
            'kelas' => 'required|in:X,XI,XII',
            'password' => 'required|min:8|confirmed',
        ], [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'kelas.required' => 'Kelas wajib dipilih untuk siswa.',
            'kelas.in' => 'Kelas harus salah satu dari X, XI, atau XII.',
        ]);

        $kelas = strtoupper(trim((string) $request->input('kelas')));

        User::create([
            'name' => $request->name,
            'nama_sekolah' => $request->nama_sekolah,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'siswa',
            'status_pendaftaran' => 'menunggu',
            'kelas' => $kelas,
            'tahun_masuk' => User::tahunMasukDariKelas($kelas),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Akun Anda menunggu persetujuan admin sebelum dapat login.');
    }
}
