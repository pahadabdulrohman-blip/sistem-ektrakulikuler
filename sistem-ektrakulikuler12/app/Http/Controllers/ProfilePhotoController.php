<?php

namespace App\Http\Controllers;

use App\Models\ProfilePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.required' => 'Silakan pilih foto terlebih dahulu.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $username = session('username', session('name'));

        if (!$username) {
            return back()->withErrors([
                'foto' => 'Username tidak ditemukan. Silakan login kembali.'
            ]);
        }

        // Cari foto profil siswa sebelumnya
        $fotoLama = ProfilePhoto::where('username', $username)
            ->where('role', 'siswa')
            ->first();

        // Simpan foto baru ke storage/app/public/foto-profil
        $pathBaru = $request->file('foto')
            ->store('foto-profil', 'public');

        // Ambil lokasi foto lama
        $pathLama = $fotoLama?->photo_path;

        // Simpan atau perbarui data menggunakan kolom photo_path
        ProfilePhoto::updateOrCreate(
            [
                'username' => $username,
                'role' => 'siswa',
            ],
            [
                'photo_path' => $pathBaru,
            ]
        );

        // Hapus foto lama setelah data berhasil diperbarui
        if ($pathLama && Storage::disk('public')->exists($pathLama)) {
            Storage::disk('public')->delete($pathLama);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}
