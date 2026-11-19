<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\JadwalEkstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JadwalController extends ApiController
{
    /**
     * Jadwal wajib & gabungan yang akan datang. Guru juga mendapat semua jadwal.
     */
    public function index(Request $request)
    {
        $role = strtolower(trim((string) $request->user()->role));

        $wajib = JadwalEkstrakurikuler::where('jenis', 'wajib')
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')->orderBy('jam_mulai')->get();

        $gabungan = JadwalEkstrakurikuler::where('jenis', 'gabungan')
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')->orderBy('jam_mulai')->get();

        $semua = $role === 'guru'
            ? JadwalEkstrakurikuler::orderBy('tanggal')->orderBy('jam_mulai')->get()
            : collect();

        return $this->sukses([
            'jadwal_wajib' => $wajib,
            'jadwal_gabungan' => $gabungan,
            'semua_jadwal' => $semua->values(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $this->tolakJadwalGanda($data);

        $jadwal = JadwalEkstrakurikuler::create($data);

        return $this->sukses($jadwal, 'Jadwal kegiatan berhasil ditambahkan.', 201);
    }

    public function update(Request $request, int $id)
    {
        $jadwal = JadwalEkstrakurikuler::findOrFail($id);

        $data = $this->validatedData($request);
        $this->tolakJadwalGanda($data, $id);

        $jadwal->update($data);

        return $this->sukses($jadwal->fresh(), 'Jadwal kegiatan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        JadwalEkstrakurikuler::findOrFail($id)->delete();

        return $this->sukses(null, 'Jadwal kegiatan berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jenis' => 'required|in:wajib,gabungan',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter.',
            'jenis.required' => 'Jenis ekstrakurikuler wajib dipilih.',
            'jenis.in' => 'Jenis ekstrakurikuler harus Wajib atau Gabungan.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus lebih lambat dari jam mulai.',
            'lokasi.required' => 'Lokasi kegiatan wajib diisi.',
            'lokasi.max' => 'Lokasi maksimal 255 karakter.',
        ]);

        $data['nama_kegiatan'] = JadwalEkstrakurikuler::rapikanNama($data['nama_kegiatan']);

        return $data;
    }

    private function tolakJadwalGanda(array $data, ?int $abaikanId = null): void
    {
        $query = JadwalEkstrakurikuler::where('nama_kegiatan', JadwalEkstrakurikuler::normalisasiNama($data['nama_kegiatan']))
            ->whereDate('tanggal', $data['tanggal'])
            ->where('jam_mulai', $data['jam_mulai']);

        if ($abaikanId !== null) {
            $query->whereKeyNot($abaikanId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'nama_kegiatan' => 'Jadwal kegiatan ini sudah ada pada tanggal dan jam yang sama.',
            ]);
        }
    }
}
