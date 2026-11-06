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
        // Periksa apakah pengguna sudah login
        if (!session('login')) {
            return redirect()->route('login');
        }

        // Periksa apakah role pengguna sesuai
        if (!in_array(session('role'), $roles, true)) {
            abort(403, 'Kamu tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
