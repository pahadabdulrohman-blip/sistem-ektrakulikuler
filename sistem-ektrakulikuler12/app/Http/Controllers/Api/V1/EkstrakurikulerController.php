<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ekstrakurikuler;
use App\Models\PendaftaranEkstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EkstrakurikulerController extends ApiController
{
    /**
     * Daftar ekstrakurikuler. Untuk siswa disertakan daftar pilihannya.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $role = strtolower(trim((string) $user->role));

        $ekskul = Ekstrakurikuler::orderBy('id', 'asc')->get()
            ->map(fn (Ekstrakurikuler $item) => $this->formatEkskul($item))
            ->values();

        $hasil = ['ekstrakurikuler' => $ekskul];

        if ($role === 'siswa') {
            $hasil['pilihan'] = PendaftaranEkstrakurikuler::where('username', $user->username)
                ->orderBy('id')
                ->pluck('ekstrakurikuler_id')
                ->map(fn ($id) => (string) $id)
                ->values()
                ->all();
        }

        return $this->sukses($hasil);
    }

    /**
     * Detail ekstrakurikuler beserta galeri foto kegiatannya.
     */
    public function show(int $id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        $data = $this->formatEkskul($ekskul);
        $data['fotos'] = $ekskul->fotoKegiatan()->latest()->get()
            ->map(fn ($foto) => [
                'id' => $foto->id,
                'foto_path' => $foto->foto_path,
                'url' => Storage::disk('public')->url($foto->foto_path),
                'keterangan' => $foto->keterangan,
                'diunggah_oleh' => $foto->diunggah_oleh,
            ])
            ->values()
            ->all();

        return $this->sukses($data);
    }

    /**
     * Tambah ekstrakurikuler (admin/guru).
     */
    public function store(Request $request)
    {
        // Menerima dua konvensi nama field seperti di aplikasi web.
        if ($request->has('nama') && ! $request->has('nama_ekstrakurikuler')) {
            $request->merge(['nama_ekstrakurikuler' => $request->input('nama')]);
        }

        $data = $this->validasi($request);
        $nama = Ekstrakurikuler::rapikanNama($data['nama_ekstrakurikuler']);

        if (Ekstrakurikuler::namaSudahAda($nama)) {
            throw ValidationException::withMessages([
                'nama_ekstrakurikuler' => 'Ekstrakurikuler "'.$nama.'" sudah terdaftar.',
            ]);
        }

        $ekskul = Ekstrakurikuler::create([
            'nama_ekstrakurikuler' => $nama,
            'deskripsi' => $data['deskripsi'],
            'ikon' => ($data['ikon'] ?? '') ?: strtoupper(substr($nama, 0, 1)),
            'pembina' => $data['pembina'] ?? '-',
            'jadwal' => $data['jadwal'] ?? '-',
            'tempat' => $data['tempat'] ?? '-',
        ]);

        return $this->sukses(
            $this->formatEkskul($ekskul),
            'Ekstrakurikuler berhasil ditambahkan.',
            201
        );
    }

    /**
     * Ubah ekstrakurikuler (admin/guru).
     */
    public function update(Request $request, int $id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        if ($request->has('nama') && ! $request->has('nama_ekstrakurikuler')) {
            $request->merge(['nama_ekstrakurikuler' => $request->input('nama')]);
        }

        $data = $this->validasi($request, $id);
        $nama = Ekstrakurikuler::rapikanNama($data['nama_ekstrakurikuler']);

        if (Ekstrakurikuler::namaSudahAda($nama, $id)) {
            throw ValidationException::withMessages([
                'nama_ekstrakurikuler' => 'Ekstrakurikuler "'.$nama.'" sudah terdaftar.',
            ]);
        }

        $ekskul->update([
            'nama_ekstrakurikuler' => $nama,
            'deskripsi' => $data['deskripsi'],
            'ikon' => ($data['ikon'] ?? '') ?: strtoupper(substr($nama, 0, 1)),
            'pembina' => $data['pembina'] ?? '-',
            'jadwal' => $data['jadwal'] ?? '-',
            'tempat' => $data['tempat'] ?? '-',
        ]);

        return $this->sukses(
            $this->formatEkskul($ekskul->fresh()),
            'Ekstrakurikuler berhasil diperbarui.'
        );
    }

    /**
     * Hapus ekstrakurikuler beserta direktori fotonya (admin/guru).
     */
    public function destroy(int $id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        Storage::disk('public')->deleteDirectory('foto-kegiatan/'.$ekskul->id);
        $ekskul->delete();

        return $this->sukses(null, 'Ekstrakurikuler berhasil dihapus.');
    }

    private function validasi(Request $request, ?int $abaikanId = null): array
    {
        return $request->validate([
            'nama_ekstrakurikuler' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'ikon' => 'nullable|string|max:50',
            'pembina' => 'nullable|string|max:255',
            'jadwal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ], [
            'nama_ekstrakurikuler.required' => 'Nama ekstrakurikuler wajib diisi.',
            'nama_ekstrakurikuler.max' => 'Nama maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'ikon.max' => 'Ikon maksimal 50 karakter.',
            'pembina.max' => 'Nama pembina maksimal 255 karakter.',
            'jadwal.max' => 'Jadwal maksimal 255 karakter.',
            'tempat.max' => 'Tempat maksimal 255 karakter.',
        ]);
    }

    private function formatEkskul(Ekstrakurikuler $item): array
    {
        $nama = $item->nama_ekstrakurikuler;

        return [
            'id' => $item->id,
            'nama' => $nama,
            'nama_ekstrakurikuler' => $nama,
            'ikon' => $item->ikon ?: strtoupper(substr((string) $nama, 0, 1)),
            'deskripsi' => $item->deskripsi ?? '-',
            'pembina' => $item->pembina ?? '-',
            'jadwal' => $item->jadwal ?? '-',
            'tempat' => $item->tempat ?? '-',
        ];
    }
}
