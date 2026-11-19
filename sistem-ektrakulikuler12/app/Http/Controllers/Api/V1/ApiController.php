<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * Format respons standar untuk seluruh endpoint API v1:
 *
 *   { "success": true|false, "message": "...", "data": ..., "errors": {...} }
 */
abstract class ApiController extends Controller
{
    protected function sukses(mixed $data = null, string $pesan = 'Berhasil.', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $pesan,
            'data' => $data,
        ], $status);
    }

    protected function gagal(string $pesan, int $status = 400, mixed $errors = null): JsonResponse
    {
        $respons = [
            'success' => false,
            'message' => $pesan,
            'data' => null,
        ];

        if ($errors !== null) {
            $respons['errors'] = $errors;
        }

        return response()->json($respons, $status);
    }

    /**
     * Representasi pengguna yang aman (tanpa password dan api_token).
     */
    protected function formatUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'status_pendaftaran' => $user->status_pendaftaran,
            'kelas' => $user->kelas,
            'kelas_saat_ini' => data_get($user, 'kelas_saat_ini', '-'),
            'tahun_masuk' => $user->tahun_masuk,
            'nama_sekolah' => $user->nama_sekolah,
        ];
    }
}
