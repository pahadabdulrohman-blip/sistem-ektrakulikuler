<?php

namespace App\Http\Controllers;

use App\Models\JadwalEkstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

        // Guru dapat mengelola seluruh jadwal (termasuk yang sudah lewat).
        $semuaJadwal = session('role') === 'guru'
            ? JadwalEkstrakurikuler::orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->get()
            : collect();

        return view('jadwal-ekstrakurikuler', compact(
            'jadwalWajib',
            'jadwalGabungan',
            'semuaJadwal'
        ));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $this->tolakJadwalGanda($data);

        JadwalEkstrakurikuler::create($data);

        return redirect()
            ->route('jadwal.ekstrakurikuler')
            ->with('success', 'Jadwal kegiatan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalEkstrakurikuler::findOrFail($id);

        $data = $this->validatedData($request);

        $this->tolakJadwalGanda($data, $jadwal->id);

        $jadwal->update($data);

        return redirect()
            ->route('jadwal.ekstrakurikuler')
            ->with('success', 'Jadwal kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalEkstrakurikuler::findOrFail($id);

        $jadwal->delete();

        return redirect()
            ->route('jadwal.ekstrakurikuler')
            ->with('success', 'Jadwal kegiatan berhasil dihapus.');
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

        // Rapikan nama kegiatan supaya variasi spasi tidak membuat jadwal ganda.
        $data['nama_kegiatan'] = JadwalEkstrakurikuler::rapikanNama(
            $data['nama_kegiatan']
        );

        return $data;
    }

    /**
     * Tolak jadwal yang sama persis (kegiatan + tanggal + jam mulai).
     */
    private function tolakJadwalGanda(array $data, ?int $abaikanId = null): void
    {
        $query = JadwalEkstrakurikuler::where(
            'nama_kegiatan',
            $data['nama_kegiatan']
        )
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
