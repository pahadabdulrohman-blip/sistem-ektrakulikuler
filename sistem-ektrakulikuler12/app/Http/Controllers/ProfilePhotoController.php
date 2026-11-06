<?php

namespace App\Http\Controllers;

use App\Models\ProfilePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function update(Request $request)
    {
        // Pastikan pengguna sudah login
        if (
            !session('login') ||
            !in_array(session('role'), ['admin', 'guru', 'siswa'])
        ) {
            return redirect()->route('login');
        }

        // Validasi foto
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.required' => 'Silakan pilih foto terlebih dahulu.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $username = session('username');
        $role = session('role');

        // Cari foto berdasarkan akun dan role
        $profil = ProfilePhoto::where('username', $username)
            ->where('role', $role)
            ->first();

        // Simpan foto baru
        $path = $request->file('foto')
            ->store('foto-profil', 'public');

        // Simpan atau perbarui data foto
        ProfilePhoto::updateOrCreate(
            [
                'username' => $username,
                'role' => $role,
            ],
            [
                'photo_path' => $path,
            ]
        );

        // Hapus foto lama setelah data baru berhasil disimpan
        if ($profil && $profil->photo_path) {
            Storage::disk('public')->delete($profil->photo_path);
        }

        return back()->with(
            'success',
            'Foto profil berhasil diperbarui.'
        );
    }
}
