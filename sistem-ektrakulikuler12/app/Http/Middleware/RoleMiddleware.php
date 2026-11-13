<?php

namespace App\Http\Middleware;

use Closure;
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
