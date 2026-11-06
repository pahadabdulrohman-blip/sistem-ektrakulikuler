<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalEkstrakurikuler extends Model
{
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