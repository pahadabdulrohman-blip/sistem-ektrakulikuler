<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ekstrakurikuler;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PenilaianController extends ApiController
{
    /**
     * Daftar penilaian sesuai role:
     * - siswa: nilai milik sendiri
     * - guru: seluruh nilai + daftar siswa & ekskul
     * - admin: rekap dengan predikat
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $role = strtolower(trim((string) $user->role));

        if ($role === 'siswa') {
            $nilai = Penilaian::where('username', $user->username)->latest()->get()
                ->map(fn ($item) => $this->formatNilai($item))
                ->values();

            return $this->sukses(['penilaian' => $nilai]);
        }

        if ($role === 'admin') {
            $penilaian = Penilaian::latest()->get();
            $siswa = User::where('role', 'siswa')->get()->keyBy('username');

            $daftarNilai = $penilaian->map(function ($item) use ($siswa) {
                $pengguna = $siswa->get($item->username);

                return [
                    'id' => $item->id,
                    'nama' => data_get($pengguna, 'name', $item->username),
                    'kelas' => data_get($pengguna, 'kelas_saat_ini', '-'),
                    'kegiatan' => $item->nama_kegiatan ?: '-',
                    'nilai' => Penilaian::formatNilai($item->nilai),
                    'predikat' => Penilaian::predikatDariNilai($item->nilai),
                    'dicatat_oleh' => $item->dicatat_oleh ?: '-',
                    'tanggal' => optional($item->created_at)->format('d/m/Y'),
                ];
            })->values();

            return $this->sukses([
                'penilaian' => $daftarNilai,
                'total_penilaian' => $penilaian->count(),
                'rata_nilai' => $penilaian->isNotEmpty()
                    ? Penilaian::formatNilai($penilaian->avg('nilai')) : '-',
            ]);
        }

        return $this->sukses([
            'siswa' => User::where('role', 'siswa')->whereNotNull('username')
                ->with(['pendaftaranEkstrakurikuler.ekstrakurikuler'])
                ->orderBy('name')->get(),
            'ekstrakurikuler' => Ekstrakurikuler::orderBy('nama_ekstrakurikuler')->get(),
            'penilaian' => Penilaian::latest()->get()->map(fn ($item) => $this->formatNilai($item))->values(),
        ]);
    }

    /**
     * Detail nilai. Siswa hanya bisa melihat nilai milik sendiri.
     */
    public function show(Request $request, int $id)
    {
        $user = $request->user();
        $role = strtolower(trim((string) $user->role));

        $query = Penilaian::whereKey($id);

        if ($role === 'siswa') {
            $query->where('username', $user->username);
        }

        $nilai = $query->firstOrFail();

        return $this->sukses($this->formatNilai($nilai));
    }

    /**
     * Catat penilaian baru (guru).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|exists:users,username',
            'nama_kegiatan' => 'required|string|max:100',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $siswa = User::where('username', $data['username'])->where('role', 'siswa')->first();

        if (! $siswa) {
            throw ValidationException::withMessages([
                'username' => 'Akun yang dipilih bukan akun siswa.',
            ]);
        }

        $data['nama_kegiatan'] = Penilaian::rapikanNama($data['nama_kegiatan']);

        $sudahAda = Penilaian::where('username', $data['username'])
            ->whereRaw('LOWER(TRIM(nama_kegiatan)) = ?', [Penilaian::normalisasiNama($data['nama_kegiatan'])])
            ->exists();

        if ($sudahAda) {
            throw ValidationException::withMessages([
                'nama_kegiatan' => 'Penilaian untuk siswa dan kegiatan ini sudah ada. Gunakan tombol Edit pada data yang sudah tercatat.',
            ]);
        }

        $data['dicatat_oleh'] = $request->user()->username;
        $nilai = Penilaian::create($data);

        return $this->sukses($this->formatNilai($nilai), 'Penilaian berhasil disimpan.', 201);
    }

    /**
     * Ubah nilai & keterangan. Hanya guru yang mencatatnya.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $nilai = Penilaian::findOrFail($id);
        $this->pastikanPemilik($nilai, $request->user()->username);

        $nilai->update($data);

        return $this->sukses($this->formatNilai($nilai->fresh()), 'Penilaian berhasil diperbarui.');
    }

    /**
     * Hapus nilai. Hanya guru yang mencatatnya.
     */
    public function destroy(Request $request, int $id)
    {
        $nilai = Penilaian::findOrFail($id);
        $this->pastikanPemilik($nilai, $request->user()->username);

        $nilai->delete();

        return $this->sukses(null, 'Penilaian berhasil dihapus.');
    }

    private function pastikanPemilik(Penilaian $nilai, string $username): void
    {
        if ($nilai->dicatat_oleh !== $username) {
            throw ValidationException::withMessages([
                'penilaian' => 'Anda tidak berhak mengubah penilaian milik guru lain.',
            ]);
        }
    }

    private function formatNilai(Penilaian $item): array
    {
        return [
            'id' => $item->id,
            'username' => $item->username,
            'nama_kegiatan' => $item->nama_kegiatan,
            'nilai' => Penilaian::formatNilai($item->nilai),
            'nilai_mentah' => $item->nilai,
            'predikat' => Penilaian::predikatDariNilai($item->nilai),
            'keterangan' => $item->keterangan,
            'dicatat_oleh' => $item->dicatat_oleh,
            'created_at' => optional($item->created_at)->toISOString(),
        ];
    }
}
