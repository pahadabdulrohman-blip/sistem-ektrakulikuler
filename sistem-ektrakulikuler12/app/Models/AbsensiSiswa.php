<?php

namespace App\Models;

use App\Models\Concerns\RapikanNama;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    use RapikanNama;

    protected $table = 'absensi_siswas';

    protected $fillable = [
        'username',
        'nama_kegiatan',
        'tanggal',
        'status',
        'dicatat_oleh',
    ];
}
