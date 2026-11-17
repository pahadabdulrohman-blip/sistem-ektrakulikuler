<?php

namespace App\Models\Concerns;

/**
 * Perapi nama kegiatan agar penulisan yang berbeda spasi/huruf besar
 * dianggap sama. Dipakai sebagai kunci anti-duplikat.
 */
trait RapikanNama
{
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
}
