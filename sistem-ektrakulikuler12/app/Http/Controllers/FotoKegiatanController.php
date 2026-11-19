<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\EkstrakurikulerFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoKegiatanController extends Controller
{
    /**
     * Disk dan folder penyimpanan foto kegiatan.
     * File tersimpan di storage/app/public/foto-kegiatan/{id ekskul}/...
     * dan diakses lewat public/storage (symlink).
     */
    private const DISK = 'public';
    private const FOLDER = 'foto-kegiatan';

    /**
     * UNGGAH FOTO KEGIATAN (BISA BEBERAPA SEKALIGUS)
     */
    public function store(Request $request, $id)
    {
        $ekskul = Ekstrakurikuler::find($id);

        if (! $ekskul) {
            return back()->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $request->validate([
            'foto' => 'required|array|max:10',
            'foto.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'keterangan' => 'nullable|string|max:150',
        ], [
            'foto.required' => 'Silakan pilih minimal satu foto kegiatan.',
            'foto.array' => 'Format unggahan foto tidak valid.',
            'foto.max' => 'Maksimal 10 foto dalam sekali unggah.',
            'foto.*.required' => 'Ada file foto yang kosong. Silakan pilih ulang.',
            'foto.*.image' => 'Setiap file harus berupa gambar.',
            'foto.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.*.max' => 'Ukuran setiap foto maksimal 10 MB.',
            'keterangan.max' => 'Keterangan maksimal 150 karakter.',
        ]);

        $keterangan = trim((string) $request->input('keterangan'));
        $jumlah = 0;

        foreach ($request->file('foto') as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            // Nama file diacak oleh Laravel, disimpan per ekstrakurikuler.
            $path = $file->store(self::FOLDER . '/' . $ekskul->id, self::DISK);

            EkstrakurikulerFoto::create([
                'ekstrakurikuler_id' => $ekskul->id,
                'foto_path' => $path,
                'keterangan' => $keterangan !== '' ? $keterangan : null,
                'diunggah_oleh' => session('username', session('name')),
            ]);

            $jumlah++;
        }

        if ($jumlah === 0) {
            return back()->withErrors([
                'foto' => 'Foto gagal diunggah. Silakan coba lagi.',
            ]);
        }

        return back()->with(
            'status_foto',
            $jumlah . ' foto kegiatan berhasil diunggah.'
        );
    }

    /**
     * HAPUS SATU FOTO KEGIATAN
     */
    public function destroy($id, $fotoId)
    {
        // Pastikan foto memang milik ekstrakurikuler pada URL.
        $foto = EkstrakurikulerFoto::where('ekstrakurikuler_id', $id)
            ->find($fotoId);

        if (! $foto) {
            return back()->with('error', 'Foto kegiatan tidak ditemukan.');
        }

        if ($foto->foto_path && Storage::disk(self::DISK)->exists($foto->foto_path)) {
            Storage::disk(self::DISK)->delete($foto->foto_path);
        }

        $foto->delete();

        return back()->with('status_foto', 'Foto kegiatan berhasil dihapus.');
    }
}
