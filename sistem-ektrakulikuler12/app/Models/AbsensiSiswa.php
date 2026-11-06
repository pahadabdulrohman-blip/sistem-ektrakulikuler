<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    protected $table = 'absensi_siswas';

    protected $fillable = [
        'username',
        'nama_kegiatan',
        'tanggal',
        'status',
        'dicatat_oleh',
    ];
}
