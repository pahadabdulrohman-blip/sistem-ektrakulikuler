<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Autentikasi API memakai bearer token sederhana.
 *
 * Klien mengirim: Authorization: Bearer <token>  (atau header X-API-Token)
 * Token yang disimpan di database adalah hash SHA-256, bukan token plain.
 */
class ApiTokenAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $this->ambilToken($request);

        if (! $token) {
            return $this->gagal(
                'Token API tidak ditemukan. Kirim header Authorization: Bearer <token>.',
                401
            );
        }

        $user = User::where('api_token', hash('sha256', $token))->first();

        if (! $user) {
            return $this->gagal('Token API tidak valid atau sudah dicabut. Silakan login kembali.', 401);
        }

        if (strtolower(trim((string) $user->role)) === 'siswa'
            && $user->status_pendaftaran !== 'diterima') {
            $pesan = $user->status_pendaftaran === 'ditolak'
                ? 'Pendaftaran Anda telah ditolak. Silakan hubungi admin.'
                : 'Pendaftaran Anda masih menunggu persetujuan admin.';

            return $this->gagal($pesan, 403);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }

    private function ambilToken(Request $request): ?string
    {
        $header = (string) $request->header('Authorization', '');

        if (preg_match('/^Bearer\s+(.+)$/i', $header, $cocok)) {
            return trim($cocok[1]);
        }

        $headerLain = $request->header('X-API-Token');

        return is_string($headerLain) && trim($headerLain) !== ''
            ? trim($headerLain)
            : null;
    }

    private function gagal(string $pesan, int $status): Response
    {
        return response()->json([
            'success' => false,
            'message' => $pesan,
            'data' => null,
        ], $status);
    }
}
