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

    /**
     * Predikat berdasarkan nilai akhir siswa.
     */
    public static function predikatDariNilai($nilai): string
    {
        $nilai = (float) $nilai;

        return match (true) {
            $nilai >= 90 => 'Sangat Baik',
            $nilai >= 80 => 'Baik',
            $nilai >= 70 => 'Cukup',
            default => 'Perlu Bimbingan',
        };
    }

    /**
     * Format nilai tanpa angka nol di belakang koma.
     */
    public static function formatNilai($nilai): string
    {
        if ($nilai === null || $nilai === '') {
            return '-';
        }

        return rtrim(
            rtrim(number_format((float) $nilai, 1, ',', '.'), '0'),
            ','
        );
    }
}
