<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

/**
 * Menyiapkan tabel dan akun awal saat deploy pertama kali.
 *
 * Beberapa platform deploy tidak menjalankan `php artisan migrate`. Selain itu,
 * migrasi lama di proyek ini ada yang duplikat (menambah kolom username/role
 * dua kali) sehingga `migrate` biasa berhenti di tengah pada database baru.
 * Karena itu tiap file migrasi dijalankan satu per satu; kegagalan satu file
 * tidak menghentikan yang lain.
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

        // Sama seperti file SQLite fallback: memakai direktori temp yang
        // writable di container.
        $folder = sys_get_temp_dir();

        $penanda = $folder.DIRECTORY_SEPARATOR.'.db-siap-'.md5(
            $koneksi.'|'.(string) config('database.connections.'.$koneksi.'.database')
        );

        config(['app.diag_migrasi' => config('app.diag_migrasi').'koneksi='.$koneksi.';']);

        if (is_file($penanda)) {
            config(['app.diag_migrasi' => config('app.diag_migrasi').'marker=ada;']);

            return;
        }

        try {
            $this->jalankanMigrasiSatuPerSatu();

            config(['app.diag_migrasi' => config('app.diag_migrasi')
                .'users='.(Schema::hasTable('users') ? 'ada' : 'tidak').';']);

            $this->seedAkunDefault();

            if (Schema::hasTable('users') && Schema::hasTable('sessions')) {
                @file_put_contents($penanda, date('c'));
            }
        } catch (Throwable $e) {
            config(['app.diag_migrasi' => config('app.diag_migrasi')
                .'err='.str_replace(["\n", "\r", '|'], ' ', $e->getMessage()).';']);

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

    /**
     * Akun awal untuk database baru (SQLite fallback maupun addon Postgres/
     * MySQL). Hanya dibuat jika username belum ada, jadi tidak menimpa akun
     * yang sudah ada.
     */
    private function seedAkunDefault(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $akun = [
            ['nama' => 'Administrator', 'username' => 'admin', 'email' => 'admin@aktivia.local', 'password' => 'admin123', 'role' => 'admin', 'kelas' => null],
            ['nama' => 'Guru Contoh', 'username' => 'guru', 'email' => 'guru@aktivia.local', 'password' => 'guru123', 'role' => 'guru', 'kelas' => null],
            ['nama' => 'Siswa Contoh', 'username' => 'siswa', 'email' => 'siswa@aktivia.local', 'password' => 'siswa123', 'role' => 'siswa', 'kelas' => 'X'],
        ];

        foreach ($akun as $data) {
            if (User::where('username', $data['username'])->exists()) {
                continue;
            }

            $kolom = [
                'name' => $data['nama'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ];

            foreach (['kelas' => $data['kelas'], 'status_pendaftaran' => 'diterima', 'nama_sekolah' => 'SMA Negeri 1 Contoh'] as $nama => $nilai) {
                if (Schema::hasColumn('users', $nama)) {
                    $kolom[$nama] = $nilai;
                }
            }

            User::create($kolom);
        }
    }
}
