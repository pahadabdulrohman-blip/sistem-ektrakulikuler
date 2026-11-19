<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

/**
 * Menyiapkan tabel aplikasi otomatis saat deploy pertama kali.
 *
 * Beberapa platform deploy tidak menjalankan `php artisan migrate` untuk
 * database addon (MySQL/Postgres). Tanpa tabel `users`, `cache`, dan
 * `sessions`, POST /login langsung menghasilkan error 500.
 *
 * Provider ini hanya bekerja saat ada request web (bukan saat artisan/test),
 * hanya mencoba sekali per konfigurasi database, dan tidak mengganggu
 * aplikasi yang sudah termigrasi.
 */
class AutoMigrateProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $koneksi = (string) config('database.default');

        $penanda = storage_path('framework/.db-siap-'.md5(
            $koneksi.'|'.(string) config('database.connections.'.$koneksi.'.database')
        ));

        if (is_file($penanda)) {
            return;
        }

        try {
            $perluMigrasi = ! Schema::hasTable('users')
                || ! Schema::hasTable('cache')
                || ! Schema::hasTable('cache_locks')
                || ! Schema::hasTable('sessions');

            if ($perluMigrasi) {
                Artisan::call('migrate', [
                    '--force' => true,
                    '--no-interaction' => true,
                ]);
            }

            if (Schema::hasTable('users') && Schema::hasTable('sessions')) {
                @file_put_contents($penanda, date('c'));
            }
        } catch (Throwable $e) {
            // Jangan sampai error migrasi menggantikan error aplikasi.
            // Sengaja tidak memanggil Log::*: storage/logs bisa tidak writable
            // oleh PHP-FPM di container dan akan memicu fatal error baru.
        }
    }
}
