<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\Penilaian;
use App\Models\User;

class PenilaianController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')
            ->whereNotNull('username')
            ->with(['pendaftaranEkstrakurikuler.ekstrakurikuler'])
            ->orderBy('name')
            ->get();

        // Data siswa per username untuk menampilkan nama dan kelas di tabel.
        $dataSiswa = $siswa->keyBy('username');

        $ekskul = Ekstrakurikuler::orderBy('nama_ekstrakurikuler')->get();

        $nilai = Penilaian::latest()->get();

        return view('penilaian', [
            'siswa' => $siswa,
            'nilai' => $nilai,
            'dataSiswa' => $dataSiswa,
            'ekskul' => $ekskul,
        ]);
    }

    /**
     * Daftar penilaian untuk halaman admin.
     */
    public function adminIndex()
    {
        $penilaian = Penilaian::latest()->get();

        $siswa = User::where('role', 'siswa')
            ->get()
            ->keyBy('username');

        $daftarNilai = $penilaian->map(function ($item) use ($siswa) {
            $user = $siswa->get($item->username);

            return [
                'nama' => data_get($user, 'name', $item->username),
                'kelas' => data_get($user, 'kelas_saat_ini', '-'),
                'kegiatan' => $item->nama_kegiatan ?: '-',
                'nilai' => Penilaian::formatNilai($item->nilai),
                'predikat' => Penilaian::predikatDariNilai($item->nilai),
                'dicatat_oleh' => $item->dicatat_oleh ?: '-',
                'tanggal' => optional($item->created_at)->format('d/m/Y'),
            ];
        });

        return view('admin.penilaian', [
            'daftarNilai' => $daftarNilai,
            'totalPenilaian' => $penilaian->count(),
            'rataNilai' => $penilaian->isNotEmpty()
                ? Penilaian::formatNilai($penilaian->avg('nilai'))
                : '-',
        ]);
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|exists:users,username',
            'nama_kegiatan' => 'required|string|max:100',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $siswa = User::where('username', $data['username'])
            ->where('role', 'siswa')
            ->first();

        if (!$siswa) {
            return back()->withErrors([
                'username' => 'Akun yang dipilih bukan akun siswa.'
            ])->withInput();
        }

        $data['dicatat_oleh'] = session('username');

        Penilaian::create($data);

        return redirect()->route('guru.penilaian')
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $penilaian = Penilaian::findOrFail($id);
        $penilaian->update($data);

        return redirect()->route('guru.penilaian')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();

        return redirect()->route('guru.penilaian')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}
