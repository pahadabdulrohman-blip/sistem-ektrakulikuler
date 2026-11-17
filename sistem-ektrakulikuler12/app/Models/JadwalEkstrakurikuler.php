<?php

namespace App\Models;

use App\Models\Concerns\RapikanNama;
use Illuminate\Database\Eloquent\Model;

class JadwalEkstrakurikuler extends Model
{
    use RapikanNama;

    protected $fillable = [
        'nama_kegiatan',
        'jenis',
        'nama_ekstrakurikuler',
        'sekolah_mitra',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'keterangan',
    ];
}