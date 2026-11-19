<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

/**
 * Menyiapkan tabel aplikasi hanya jika database masih kosong.
 *
 * Database yang sudah berisi akun dan data pengguna TIDAK diubah: tidak ada
 * migrasi yang dijalankan. Satu-satunya penambahan adalah akun admin khusus
 * (admin_utama) yang dibuat bila belum ada; akun lain tidak disentuh.
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

        // Akun admin khusus dibuat sekali saja jika belum ada. Akun lain tidak
        // diubah atau dihapus.
        try {
            $this->pastikanAdminKhusus();
        } catch (Throwable $e) {
            config(['app.diag_migrasi' => config('app.diag_migrasi')
                .'admin_err='.str_replace(["\n", "\r", '|', ';'], ' ', $e->getMessage()).';']);
        }

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

            // Database baru: tabel sudah jadi setelah migrasi, buat akunnya.
            $this->pastikanAdminKhusus();

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

    /**
     * Akun admin khusus yang diminta. Dibuat hanya sekali bila username belum
     * ada. Akun lain TIDAK diubah atau dihapus. Password di-hash otomatis oleh
     * cast "hashed" pada model User.
     */
    private function pastikanAdminKhusus(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $username = 'admin_utama';

        if (User::where('username', $username)->exists()) {
            config(['app.diag_migrasi' => config('app.diag_migrasi').'admin=ada;']);

            return;
        }

        User::create([
            'name' => 'Administrator Utama',
            'username' => $username,
            'email' => 'admin_utama@aktivia.local',
            'password' => 'AktiviaAdmin2026!',
            'role' => 'admin',
            'status_pendaftaran' => 'diterima',
            'nama_sekolah' => 'SMA Negeri 1 Contoh',
        ]);

        config(['app.diag_migrasi' => config('app.diag_migrasi').'admin=baru;']);
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
