<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

/**
 * Menyiapkan tabel aplikasi hanya jika database masih kosong.
 *
 * Database yang sudah berisi akun dan data pengguna TIDAK diubah sama sekali:
 * tidak ada migrasi yang dijalankan dan tidak ada akun yang dibuat. Ini
 * penting karena environment produksi memakai database addon yang sudah ada.
 */
class AutoMigrateProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Test memakai database sendiri. Untuk web, jangan hanya mengandalkan
        // runningInConsole(): runtime FrankenPHP/Octane bisa melaporkan console
        // walaupun ini request HTTP. REQUEST_URI menjadi penanda request web.
        if ($this->app->runningUnitTests()) {
            return;
        }

        if ($this->app->runningInConsole() && empty($_SERVER['REQUEST_URI'])) {
            return;
        }

        config(['app.diag_migrasi' => 'boot;']);

        $koneksi = (string) config('database.default');
        config(['app.diag_migrasi' => config('app.diag_migrasi').'koneksi='.$koneksi.';']);

        // Direktori temp selalu writable di container.
        $folder = sys_get_temp_dir();
        $penanda = $folder.DIRECTORY_SEPARATOR.'.db-siap-'.md5(
            $koneksi.'|'.(string) config('database.connections.'.$koneksi.'.database')
        );

        if (is_file($penanda)) {
            config(['app.diag_migrasi' => config('app.diag_migrasi').'marker=ada;']);

            return;
        }

        try {
            $sudahAda = Schema::hasTable('users');

            if ($sudahAda) {
                // Database produksi sudah terisi. Jangan sentuh skema/data.
                config(['app.diag_migrasi' => config('app.diag_migrasi').'users=ada;skip;']);
                @file_put_contents($penanda, date('c'));

                return;
            }

            $this->jalankanMigrasiSatuPerSatu();

            config(['app.diag_migrasi' => config('app.diag_migrasi')
                .'users='.(Schema::hasTable('users') ? 'ada' : 'tidak').';']);

            if (Schema::hasTable('users') && Schema::hasTable('sessions')) {
                @file_put_contents($penanda, date('c'));
            }
        } catch (Throwable $e) {
            config(['app.diag_migrasi' => config('app.diag_migrasi')
                .'err='.str_replace(["\n", "\r", '|', ';'], ' ', $e->getMessage()).';']);

            // Jangan sampai error migrasi menggantikan error aplikasi.
            // Sengaja tidak memanggil Log::*: storage/logs bisa tidak writable
            // oleh PHP-FPM di container dan akan memicu fatal error baru.
        }
    }

    private function jalankanMigrasiSatuPerSatu(): void
    {
        $berkas = glob(database_path('migrations/*.php')) ?: [];
        sort($berkas);

        foreach ($berkas as $file) {
            try {
                Artisan::call('migrate', [
                    '--force' => true,
                    '--no-interaction' => true,
                    '--path' => 'database/migrations/'.basename($file),
                ]);
            } catch (Throwable $e) {
                // Migrasi duplikat lama diabaikan; kolomnya sudah dibuat
                // oleh migrasi sebelumnya.
                config(['app.diag_migrasi' => config('app.diag_migrasi')
                    .'gagal='.basename($file).':'
                    .str_replace(["\n", "\r", '|', ';'], ' ', $e->getMessage()).';']);
                continue;
            }
        }
    }
}
