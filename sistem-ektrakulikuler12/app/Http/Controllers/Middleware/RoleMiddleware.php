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
        string $role
    ): Response {

        // Belum login
        if (!session('login')) {
            return redirect()->route('login');
        }

        // Role tidak sesuai
        if (session('role') !== $role) {

            if (session('role') === 'admin') {
                return redirect()->route('dashboard.admin');
            }

            if (session('role') === 'guru') {
                return redirect()->route('dashboard.guru');
            }

            if (session('role') === 'siswa') {
                return redirect()->route('dashboard.siswa');
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}