<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaians';

    protected $fillable = [
        'username',
        'nama_kegiatan',
        'nilai',
        'keterangan',
        'dicatat_oleh',
    ];
}
