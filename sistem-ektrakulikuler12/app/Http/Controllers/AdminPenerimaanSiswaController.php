<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminPenerimaanSiswaController extends Controller
{
    public const STATUS_VALID = ['menunggu', 'diterima', 'ditolak'];

    /**
     * Daftar pendaftaran siswa beserta aksi terima/tolak.
     */
    public function index(Request $request)
    {
        $status = (string) $request->query('status', 'menunggu');

        if (! in_array($status, [...self::STATUS_VALID, 'semua'], true)) {
            $status = 'menunggu';
        }

        $query = User::where('role', 'siswa');

        if ($status !== 'semua') {
            $query->where('status_pendaftaran', $status);
        }

        $siswa = $query
            ->orderByDesc('created_at')
            ->orderBy('name')
            ->get();

        $jumlah = [
            'menunggu' => User::where('role', 'siswa')
                ->where('status_pendaftaran', 'menunggu')
                ->count(),
            'diterima' => User::where('role', 'siswa')
                ->where('status_pendaftaran', 'diterima')
                ->count(),
            'ditolak' => User::where('role', 'siswa')
                ->where('status_pendaftaran', 'ditolak')
                ->count(),
        ];

        return view('admin.penerimaan-siswa', compact('siswa', 'status', 'jumlah'));
    }

    /**
     * Terima pendaftaran siswa sehingga akun dapat digunakan untuk login.
     */
    public function terima($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        $siswa->update(['status_pendaftaran' => 'diterima']);

        return back()->with(
            'success',
            'Pendaftaran siswa ' . $siswa->name . ' berhasil diterima.'
        );
    }

    /**
     * Tolak pendaftaran siswa sehingga akun tidak dapat digunakan untuk login.
     */
    public function tolak($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        $siswa->update(['status_pendaftaran' => 'ditolak']);

        return back()->with(
            'success',
            'Pendaftaran siswa ' . $siswa->name . ' berhasil ditolak.'
        );
    }
}
