<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranEkstrakurikuler extends Model
{
    protected $table = 'pendaftaran_ekstrakurikulers';

    protected $fillable = [
        'username',
        'ekstrakurikuler_id',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
}
