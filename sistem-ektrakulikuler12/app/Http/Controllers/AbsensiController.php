<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiSiswa;
use App\Models\Ekstrakurikuler;
use App\Models\User;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')
            ->whereNotNull('username')
            ->with(['pendaftaranEkstrakurikuler.ekstrakurikuler'])
            ->orderBy('name')
            ->get();

        // Data siswa per username untuk menampilkan nama dan kelas di rekap.
        $dataSiswa = $siswa->keyBy('username');

        $ekskul = Ekstrakurikuler::orderBy('nama_ekstrakurikuler')->get();

        $absensi = AbsensiSiswa::latest('tanggal')
            ->latest()
            ->get();

        return view('absensi.index', compact('siswa', 'absensi', 'dataSiswa', 'ekskul'));
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|exists:users,username',
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        // Rapikan nama kegiatan supaya variasi spasi/huruf besar tidak
        // menghasilkan baris absensi ganda.
        $data['nama_kegiatan'] = AbsensiSiswa::rapikanNama($data['nama_kegiatan']);

        $siswa = User::where('username', $data['username'])
            ->where('role', 'siswa')
            ->first();

        if (!$siswa) {
            return back()->withErrors([
                'username' => 'Akun yang dipilih bukan akun siswa.'
            ])->withInput();
        }

        // updateOrCreate: absensi yang sama (siswa + kegiatan + tanggal)
        // hanya diperbarui, tidak dibuat baris baru.
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

        return redirect()
            ->route(session('role') === 'admin' ? 'admin.absensi' : 'guru.absensi')
            ->with('success', 'Absensi siswa berhasil disimpan.');
    }
}
