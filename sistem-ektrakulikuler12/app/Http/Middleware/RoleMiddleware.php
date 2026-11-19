<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        // Periksa status login
        if (!session('login')) {
            return redirect()->route('login');
        }

        // Ambil role pengguna
        $userRole = strtolower(trim((string) session('role')));

        // Samakan format role yang diizinkan
        $roles = array_map(
            fn ($role) => strtolower(trim($role)),
            $roles
        );

        // Pastikan siswa yang sudah ditolak atau masih menunggu
        // tidak dapat mengakses halaman yang butuh login.
        if ($userRole === 'siswa') {
            $user = User::where('username', session('username'))
                ->where('role', 'siswa')
                ->first();

            if (! $user) {
                session()->invalidate();

                return redirect()
                    ->route('login')
                    ->with('error', 'Sesi Anda tidak valid. Silakan login kembali.');
            }

            $status = $user->status_pendaftaran ?? 'diterima';

            if ($status !== 'diterima') {
                session()->invalidate();

                return redirect()
                    ->route('login')
                    ->with('error', $status === 'menunggu'
                        ? 'Pendaftaran Anda masih menunggu persetujuan admin.'
                        : 'Pendaftaran Anda telah ditolak. Silakan hubungi admin.');
            }
        }

        // Jika role tidak sesuai, arahkan ke dashboard masing-masing
        if (!in_array($userRole, $roles, true)) {

            return match ($userRole) {
                'admin' => redirect()->route('dashboard.admin'),
                'guru'  => redirect()->route('dashboard.guru'),
                'siswa' => redirect()->route('dashboard.siswa'),

                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
