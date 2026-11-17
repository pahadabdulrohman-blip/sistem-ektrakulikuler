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

    /**
     * Galeri foto kegiatan milik ekstrakurikuler ini.
     */
    public function fotoKegiatan()
    {
        return $this->hasMany(
            EkstrakurikulerFoto::class,
            'ekstrakurikuler_id'
        );
    }

    /**
     * Rapikan nama: hapus spasi berlebih dan spasi tersembunyi (NBSP).
     */
    public static function rapikanNama(?string $nama): string
    {
        $nama = preg_replace('/[\s\x{00A0}]+/u', ' ', (string) $nama);

        return trim($nama);
    }

    /**
     * Bentuk nama untuk perbandingan (tanpa beda huruf besar/kecil).
     */
    public static function normalisasiNama(?string $nama): string
    {
        return mb_strtolower(self::rapikanNama($nama));
    }

    /**
     * Cek apakah nama ekstrakurikuler sudah dipakai.
     * Perbandingan tidak membedakan huruf besar/kecil dan spasi berlebih.
     */
    public static function namaSudahAda(?string $nama, ?int $abaikanId = null): bool
    {
        $target = self::normalisasiNama($nama);

        if ($target === '') {
            return false;
        }

        return self::query()
            ->when($abaikanId, fn ($query) => $query->where('id', '!=', $abaikanId))
            ->pluck('nama_ekstrakurikuler')
            ->contains(
                fn ($namaAda) => self::normalisasiNama($namaAda) === $target
            );
    }
}