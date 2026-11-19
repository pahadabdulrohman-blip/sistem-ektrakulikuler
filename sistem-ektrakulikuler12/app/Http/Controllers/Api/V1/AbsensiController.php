<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AbsensiSiswa;
use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AbsensiController extends ApiController
{
    /**
     * Rekap absensi beserta daftar siswa dan ekstrakurikuler.
     */
    public function index()
    {
        $siswa = User::where('role', 'siswa')->whereNotNull('username')
            ->with(['pendaftaranEkstrakurikuler.ekstrakurikuler'])
            ->orderBy('name')->get();

        return $this->sukses([
            'siswa' => $siswa,
            'absensi' => AbsensiSiswa::latest('tanggal')->latest()->get(),
            'ekstrakurikuler' => Ekstrakurikuler::orderBy('nama_ekstrakurikuler')->get(),
        ]);
    }

    /**
     * Simpan atau perbarui absensi siswa.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|exists:users,username',
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        $siswa = User::where('username', $data['username'])->where('role', 'siswa')->first();

        if (! $siswa) {
            throw ValidationException::withMessages([
                'username' => 'Akun yang dipilih bukan akun siswa.',
            ]);
        }

        $data['nama_kegiatan'] = AbsensiSiswa::rapikanNama($data['nama_kegiatan']);

        $absensi = AbsensiSiswa::updateOrCreate(
            [
                'username' => $data['username'],
                'nama_kegiatan' => $data['nama_kegiatan'],
                'tanggal' => $data['tanggal'],
            ],
            [
                'status' => $data['status'],
                'dicatat_oleh' => $request->user()->username,
            ]
        );

        return $this->sukses($absensi, 'Absensi siswa berhasil disimpan.');
    }
}
