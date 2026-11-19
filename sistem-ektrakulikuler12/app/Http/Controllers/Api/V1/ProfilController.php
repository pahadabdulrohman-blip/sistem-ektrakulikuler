<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ProfilePhoto;
use Illuminate\Http\Request;

class ProfilController extends ApiController
{
    /**
     * Profil pengguna yang sedang login beserta info foto profil.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $role = strtolower(trim((string) $user->role));

        $foto = ProfilePhoto::where('username', $user->username)
            ->where('role', $role)->first();

        $data = $this->formatUser($user);
        $data['foto_profil'] = $foto ? [
            'id' => $foto->id,
            'photo_path' => $foto->photo_path,
            'url' => route('api.v1.profil.foto'),
            'updated_at' => optional($foto->updated_at)->toISOString(),
        ] : null;

        return $this->sukses($data);
    }
}
