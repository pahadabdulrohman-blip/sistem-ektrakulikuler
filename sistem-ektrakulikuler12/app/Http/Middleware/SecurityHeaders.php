<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menambahkan header keamanan dasar pada setiap respons.
 *
 * Header ini mencegah:
 * - browser menebak tipe file (nosniff),
 * - halaman ditampilkan di iframe situs lain (clickjacking),
 * - kebocoran URL halaman ke situs lain lewat Referer,
 * - akses kamera/mikrofon/lokasi tanpa izin.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
            'Cross-Origin-Opener-Policy' => 'same-origin',

            // Penanda build untuk memastikan perubahan sudah aktif di deploy.
            'X-AKTIVIA-BUILD' => '20261119-sqlite-tmp',
        ];

        // Diagnostik koneksi DB tanpa membocorkan kredensial.
        // Format: connection|url ada/tidak|host
        $koneksi = (string) config('database.default');
        $konfigurasi = config('database.connections.'.$koneksi) ?? [];
        $host = $koneksi === 'sqlite'
            ? 'file'
            : (string) ($konfigurasi['host'] ?? '-');

        $headers['X-AKTIVIA-DB'] = $koneksi
            .'|'.(! empty($konfigurasi['url']) ? 'url' : 'no-url')
            .'|'.$host;

        $diag = (string) config('app.diag_migrasi', '');
        if ($diag !== '') {
            $headers['X-AKTIVIA-MIG'] = substr($diag, 0, 500);
        }

        foreach ($headers as $nama => $nilai) {
            if (! $response->headers->has($nama)) {
                $response->headers->set($nama, $nilai);
            }
        }

        // HSTS hanya dikirim lewat HTTPS agar tidak mengunci akses localhost.
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        return $response;
    }
}
