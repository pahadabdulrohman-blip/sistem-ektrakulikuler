<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->siapkanDatabaseFallback();
        $this->siapkanCacheFallback();
    }

    /**
     * Jika addon database belum tersedia (DATABASE_URL kosong dan MySQL masih
     * mengarah ke 127.0.0.1), pakai SQLite sementara agar aplikasi tetap bisa
     * dipakai. Ini bukan pengganti addon: data SQLite ikut hilang saat deploy.
     */
    private function siapkanDatabaseFallback(): void
    {
        // Hanya PHPUnit yang dikecualikan. Jangan pakai environment('testing')
        // atau environment('production'): platform deploy bisa mengirim
        // APP_ENV=testing walaupun ini produksi.
        if ($this->app->runningUnitTests()) {
            return;
        }

        $konfigurasi = config('database.connections.mysql') ?? [];
        $host = (string) ($konfigurasi['host'] ?? '');
        $url = (string) ($konfigurasi['url'] ?? '');

        if (config('database.default') !== 'mysql' || $url !== '' || $host !== '127.0.0.1') {
            return;
        }

        $folder = storage_path('framework');
        if (! is_writable($folder)) {
            $folder = sys_get_temp_dir();
        }

        $berkas = $folder.DIRECTORY_SEPARATOR.'fallback.sqlite';

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => $berkas,
        ]);

        @mkdir(dirname($berkas), 0755, true);
        if (! is_file($berkas)) {
            @touch($berkas);
        }
    }

    /**
     * RateLimiter pada halaman login memakai cache. Jika deploy memaksa
     * CACHE_STORE=database tetapi tabel cache/cache_locks belum ada,
     * POST /login akan 500. Fallback ke driver array agar login aman.
     */
    private function siapkanCacheFallback(): void
    {
        if (config('cache.default') !== 'database') {
            return;
        }

        try {
            $lengkap = Schema::hasTable('cache') && Schema::hasTable('cache_locks');
        } catch (\Throwable $e) {
            $lengkap = false;
        }

        if (! $lengkap) {
            // Sengaja tidak menulis log: storage/logs bisa tidak writable oleh
            // PHP-FPM di container, yang akan mengubah fallback ini jadi 500.
            config(['cache.default' => 'array']);
        }
    }
}
