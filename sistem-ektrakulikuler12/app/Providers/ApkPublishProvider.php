<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Throwable;

/**
 * Menyatukan potongan APK di folder apk-parts/ menjadi satu file yang bisa
 * diunduh lewat /storage/downloads/.
 *
 * File aslinya melebihi batas 100 MB GitHub, jadi tidak bisa di-commit utuh.
 * Penggabungan dilakukan sekali saja, saat request web pertama setelah deploy.
 */
class ApkPublishProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $nama = (string) config('apk.nama');
        $jumlahPart = (int) config('apk.jumlah_part');
        $hash = (string) config('apk.sha256');

        if ($nama === '' || $jumlahPart < 1) {
            return;
        }

        $tujuan = storage_path('app/public/downloads/'.$nama);

        if (is_file($tujuan)) {
            return;
        }

        $parts = [];
        for ($i = 1; $i <= $jumlahPart; $i++) {
            $part = base_path('apk-parts/'.$nama.'.part'.$i);
            if (! is_file($part)) {
                return;
            }
            $parts[] = $part;
        }

        @mkdir(dirname($tujuan), 0755, true);

        $lock = fopen($tujuan.'.lock', 'c');
        if ($lock === false) {
            return;
        }

        $tmp = $tujuan.'.tmp';

        try {
            if (! flock($lock, LOCK_EX)) {
                return;
            }

            if (is_file($tujuan)) {
                return;
            }

            $keluar = fopen($tmp, 'wb');
            if ($keluar === false) {
                return;
            }

            foreach ($parts as $part) {
                $masuk = fopen($part, 'rb');
                if ($masuk === false) {
                    fclose($keluar);
                    return;
                }

                while (($data = fread($masuk, 1048576)) !== false && $data !== '') {
                    fwrite($keluar, $data);
                }

                fclose($masuk);
            }

            fclose($keluar);

            if (hash_file('sha256', $tmp) !== $hash) {
                @unlink($tmp);
                return;
            }

            rename($tmp, $tujuan);
        } catch (Throwable $e) {
            // Gagal gabung tidak boleh merusak halaman. Sengaja tidak menulis
            // log karena storage/logs bisa tidak writable oleh PHP-FPM.
            @unlink($tmp);
        } finally {
            @flock($lock, LOCK_UN);
            fclose($lock);
        }
    }
}
