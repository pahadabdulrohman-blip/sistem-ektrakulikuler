<?php

namespace App\Http\Controllers;

use App\Models\PasswordRequest;
use App\Models\ProfilePhoto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGuruController extends Controller
{
    public function index()
    {
        $guru = User::where('role', 'guru')
            ->orderBy('name')
            ->get();

        return view('admin.guru', compact('guru'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama guru wajib diisi.',
            'username.required' => 'Username guru wajib diisi.',
            'username.unique' => 'Username sudah dipakai akun lain.',
            'email.required' => 'Email guru wajib diisi.',
            'email.unique' => 'Email sudah dipakai akun lain.',
            'password.required' => 'Password awal wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'guru',
            'kelas' => null,
            'tahun_masuk' => null,
        ]);

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Akun guru berhasil dibuat.');
    }

    public function resetPassword(Request $request, $id)
    {
        $data = $request->validate([
            'password' => 'required|string|min:8',
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $guru = User::where('role', 'guru')->findOrFail($id);

        $guru->update([
            'password' => $data['password'],
        ]);

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Password guru ' . $guru->name . ' berhasil diubah.');
    }

    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        if ($guru->username === session('username')) {
            return redirect()
                ->route('admin.guru.index')
                ->withErrors(['guru' => 'Akun yang sedang dipakai tidak dapat dihapus.']);
        }

        $foto = ProfilePhoto::where('username', $guru->username)
            ->where('role', 'guru')
            ->first();

        if ($foto && $foto->photo_path) {
            Storage::disk('public')->delete($foto->photo_path);
        }

        ProfilePhoto::where('username', $guru->username)
            ->where('role', 'guru')
            ->delete();

        PasswordRequest::where('username', $guru->username)->delete();

        $guru->delete();

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Akun guru berhasil dihapus.');
    }
}
