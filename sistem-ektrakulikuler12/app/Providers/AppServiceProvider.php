<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
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
        // RateLimiter pada halaman login memakai cache. Jika deploy memaksa
        // CACHE_STORE=database tetapi tabel cache/cache_locks tidak ikut
        // terbuat, POST /login akan 500 (GET /login tetap 200 karena session
        // memakai tabel sessions). Fallback ke driver array agar login aman.
        if (config('cache.default') !== 'database') {
            return;
        }

        try {
            $lengkap = Schema::hasTable('cache') && Schema::hasTable('cache_locks');
        } catch (\Throwable $e) {
            $lengkap = false;
        }

        if (! $lengkap) {
            config(['cache.default' => 'array']);
            Log::warning('Tabel cache/cache_locks tidak tersedia; RateLimiter memakai driver array.');
        }
    }
}
