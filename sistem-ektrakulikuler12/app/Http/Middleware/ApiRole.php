<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pembatasan akses API berdasarkan role pengguna yang sudah terautentikasi
 * middleware api.token.
 *
 * Contoh: api.role:admin,guru
 */
class ApiRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Autentikasi diperlukan.',
                'data' => null,
            ], 401);
        }

        $roleAktif = strtolower(trim((string) $user->role));
        $diizinkan = array_map(
            fn (string $role) => strtolower(trim($role)),
            $roles
        );

        if (! in_array($roleAktif, $diizinkan, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Role yang diizinkan: '.implode(', ', $diizinkan).'.',
                'data' => null,
            ], 403);
        }

        return $next($request);
    }
}
