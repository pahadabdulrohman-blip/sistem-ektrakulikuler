<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePhoto extends Model
{
    protected $fillable = [
        'username',
        'role',
        'photo_path',
    ];

    /**
     * Alamat foto profil yang hanya bisa diakses pengguna yang login.
     */
    public function getUrlAttribute(): ?string
    {
        return $this->photo_path
            ? route('profil.foto', basename($this->photo_path))
            : null;
    }
}