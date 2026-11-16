<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama_ekstrakurikuler',
        'pembina',
        'jadwal',
        'deskripsi',
        'ikon',
        'tempat',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(
            PendaftaranEkstrakurikuler::class,
            'ekstrakurikuler_id'
        );
    }
}