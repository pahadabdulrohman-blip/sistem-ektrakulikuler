<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerFoto extends Model
{
    protected $table = 'ekstrakurikuler_fotos';

    protected $fillable = [
        'ekstrakurikuler_id',
        'foto_path',
        'keterangan',
        'diunggah_oleh',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(
            Ekstrakurikuler::class,
            'ekstrakurikuler_id'
        );
    }

    /**
     * Alamat gambar siap pakai di tag <img src="...">.
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->foto_path);
    }
}
