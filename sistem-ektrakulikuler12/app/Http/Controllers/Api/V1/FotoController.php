<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ekstrakurikuler;
use App\Models\EkstrakurikulerFoto;
use App\Models\ProfilePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoController extends ApiController
{
    /**
     * Stream foto profil privat milik pengguna yang sedang login.
     */
    public function fotoProfil(Request $request)
    {
        $user = $request->user();
        $role = strtolower(trim((string) $user->role));

        $foto = ProfilePhoto::where('username', $user->username)
            ->where('role', $role)->first();

        if (! $foto || ! $foto->photo_path
            || ! Storage::disk('local')->exists($foto->photo_path)) {
            return $this->gagal('Foto profil tidak ditemukan.', 404);
        }

        // basename() mencegah path traversal dari data database.
        $path = 'foto-profil/'.basename($foto->photo_path);

        if (! Storage::disk('local')->exists($path)) {
            return $this->gagal('Foto profil tidak ditemukan.', 404);
        }

        return response()->file(
            Storage::disk('local')->path($path),
            ['Cache-Control' => 'private, max-age=0']
        );
    }

    /**
     * Upload / ganti foto profil (maksimal 10 MB).
     */
    public function uploadProfil(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'foto.required' => 'Silakan pilih foto terlebih dahulu.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 10 MB.',
        ]);

        $user = $request->user();
        $username = $user->username;
        $role = strtolower(trim((string) $user->role));

        if (! $username) {
            return $this->gagal('Username tidak ditemukan. Silakan login kembali.', 401);
        }

        if (! in_array($role, ['admin', 'guru', 'siswa'], true)) {
            return $this->gagal('Role pengguna tidak dikenali. Silakan login kembali.', 403);
        }

        $fotoLama = ProfilePhoto::where('username', $username)->where('role', $role)->first();
        $pathLama = $fotoLama?->photo_path;

        $pathBaru = $request->file('foto')->store('foto-profil', 'local');

        ProfilePhoto::updateOrCreate(
            ['username' => $username, 'role' => $role],
            ['photo_path' => $pathBaru]
        );

        if ($pathLama) {
            foreach (['local', 'public'] as $disk) {
                if (Storage::disk($disk)->exists($pathLama)) {
                    Storage::disk($disk)->delete($pathLama);
                }
            }
        }

        $foto = ProfilePhoto::where('username', $username)->where('role', $role)->first();

        return $this->sukses([
            'id' => $foto->id,
            'photo_path' => $foto->photo_path,
            'url' => route('api.v1.profil.foto'),
        ], 'Foto profil berhasil diperbarui!');
    }

    /**
     * Unggah galeri foto kegiatan (admin/guru), maksimal 10 foto × 10 MB.
     */
    public function uploadKegiatan(Request $request, int $id)
    {
        $ekskul = Ekstrakurikuler::find($id);

        if (! $ekskul) {
            return $this->gagal('Data ekstrakurikuler tidak ditemukan.', 404);
        }

        $data = $request->validate([
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

        $keterangan = trim((string) $request->input('keterangan', ''));
        $keterangan = $keterangan !== '' ? $keterangan : null;
        $username = $request->user()->username;
        $jumlah = 0;
        $hasil = [];

        foreach ($request->file('foto') as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $path = $file->store('foto-kegiatan/'.$ekskul->id, 'public');
            $foto = EkstrakurikulerFoto::create([
                'ekstrakurikuler_id' => $ekskul->id,
                'foto_path' => $path,
                'keterangan' => $keterangan,
                'diunggah_oleh' => $username,
            ]);

            $hasil[] = [
                'id' => $foto->id,
                'url' => Storage::disk('public')->url($path),
                'keterangan' => $keterangan,
            ];
            $jumlah++;
        }

        if ($jumlah === 0) {
            return $this->gagal('Foto gagal diunggah. Silakan coba lagi.', 422);
        }

        return $this->sukses(
            ['fotos' => $hasil, 'jumlah' => $jumlah],
            $jumlah.' foto kegiatan berhasil diunggah.',
            201
        );
    }

    /**
     * Hapus satu foto galeri milik ekskul tertentu (admin/guru).
     */
    public function hapusKegiatan(int $id, int $foto)
    {
        $item = EkstrakurikulerFoto::where('ekstrakurikuler_id', $id)->find($foto);

        if (! $item) {
            return $this->gagal('Foto kegiatan tidak ditemukan.', 404);
        }

        if (Storage::disk('public')->exists($item->foto_path)) {
            Storage::disk('public')->delete($item->foto_path);
        }

        $item->delete();

        return $this->sukses(null, 'Foto kegiatan berhasil dihapus.');
    }
}
