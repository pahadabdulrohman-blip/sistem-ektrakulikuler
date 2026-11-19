<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ekstrakurikuler;
use App\Models\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends ApiController
{
    /**
     * Registrasi siswa baru (publik).
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|ends_with:gmail.com|unique:users,email',
            'kelas' => 'required|in:X,XI,XII',
            'password' => 'required|min:8|confirmed',
        ], [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'kelas.required' => 'Kelas wajib dipilih untuk siswa.',
            'kelas.in' => 'Kelas harus salah satu dari X, XI, atau XII.',
        ]);

        $kelas = strtoupper(trim((string) $data['kelas']));

        $user = User::create([
            'name' => $data['name'],
            'nama_sekolah' => $data['nama_sekolah'],
            'username' => $data['username'],
            'email' => $data['email'],
            'kelas' => $kelas,
            'tahun_masuk' => User::tahunMasukDariKelas($kelas),
            'password' => $data['password'],
            'role' => 'siswa',
            'status_pendaftaran' => 'menunggu',
        ]);

        return $this->sukses(
            $this->formatUser($user),
            'Registrasi berhasil. Akun Anda menunggu persetujuan admin sebelum dapat login.',
            201
        );
    }

    /**
     * Login dan terbitkan bearer token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $kunciUser = 'login:'.Str::lower((string) $request->username).'|'.$request->ip();
        $kunciIp = 'login-ip:'.$request->ip();

        if (RateLimiter::tooManyAttempts($kunciUser, 5)) {
            return $this->gagal(
                'Terlalu banyak percobaan login. Coba lagi dalam '.RateLimiter::availableIn($kunciUser).' detik.',
                429
            );
        }

        if (RateLimiter::tooManyAttempts($kunciIp, 30)) {
            return $this->gagal(
                'Terlalu banyak percobaan login dari jaringan ini. Coba lagi dalam '.RateLimiter::availableIn($kunciIp).' detik.',
                429
            );
        }

        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check((string) $request->password, (string) $user->password)) {
            RateLimiter::hit($kunciUser, 60);
            RateLimiter::hit($kunciIp, 60);

            return $this->gagal('Username atau password salah!', 401);
        }

        if (strtolower(trim((string) $user->role)) === 'siswa') {
            $status = $user->status_pendaftaran ?? 'diterima';

            if ($status === 'menunggu') {
                return $this->gagal('Pendaftaran Anda masih menunggu persetujuan admin.', 403);
            }

            if ($status === 'ditolak') {
                return $this->gagal('Pendaftaran Anda telah ditolak. Silakan hubungi admin.', 403);
            }
        }

        $token = Str::random(64);
        $user->api_token = hash('sha256', $token);
        $user->save();

        RateLimiter::clear($kunciUser);

        return $this->sukses([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $this->formatUser($user),
        ], 'Login berhasil.');
    }

    /**
     * Cabut token yang sedang dipakai.
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return $this->sukses(null, 'Logout berhasil. Token sudah dicabut.');
    }

    /**
     * Data pengguna yang sedang login.
     */
    public function me(Request $request)
    {
        return $this->sukses($this->formatUser($request->user()));
    }

    /**
     * Ringkasan dashboard sesuai role.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $role = strtolower(trim((string) $user->role));

        $data = [
            'role' => $role,
            'total_ekstrakurikuler' => Ekstrakurikuler::count(),
            'total_guru' => User::where('role', 'guru')->count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
        ];

        if ($role === 'siswa') {
            $data['total_pilihan'] = $user->pendaftaranEkstrakurikuler()->count();
            $data['total_penilaian'] = \App\Models\Penilaian::where('username', $user->username)->count();
        } elseif ($role === 'guru') {
            $data['total_jadwal'] = \App\Models\JadwalEkstrakurikuler::count();
            $data['total_penilaian_dicatat'] = \App\Models\Penilaian::where('dicatat_oleh', $user->username)->count();
        } elseif ($role === 'admin') {
            $data['pendaftaran_menunggu'] = User::where('role', 'siswa')
                ->where('status_pendaftaran', 'menunggu')->count();
            $data['permintaan_password_menunggu'] = PasswordRequest::where('status', 'menunggu')->count();
        }

        return $this->sukses($data);
    }

    /**
     * Permintaan reset password (publik).
     */
    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'role' => 'required|in:guru,siswa',
        ]);

        $user = User::where('username', $data['username'])
            ->where('role', $data['role'])->first();

        if (! $user) {
            return $this->gagal('Akun dengan username dan role tersebut tidak ditemukan.', 404);
        }

        if (! $user->email) {
            return $this->gagal('Akun tersebut belum memiliki email terdaftar. Hubungi admin.', 422);
        }

        $sudahAda = PasswordRequest::where('username', $user->username)
            ->where('status', 'menunggu')->exists();

        if ($sudahAda) {
            return $this->sukses(
                null,
                'Permintaan ubah password kamu masih diproses admin. Silakan cek email secara berkala.'
            );
        }

        PasswordRequest::create([
            'username' => $user->username,
            'role' => $user->role,
            'status' => 'menunggu',
        ]);

        return $this->sukses(
            null,
            'Permintaan ubah password berhasil dikirim. Password baru akan dikirim ke email terdaftar setelah diproses admin.',
            201
        );
    }
}
