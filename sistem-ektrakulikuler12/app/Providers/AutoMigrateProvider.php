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
        if ($this->app->runningInConsole()) {
            return;
        }

        $koneksi = (string) config('database.default');

        $folder = storage_path('framework');
        if (! is_writable($folder)) {
            $folder = sys_get_temp_dir();
        }

        $penanda = $folder.DIRECTORY_SEPARATOR.'.db-siap-'.md5(
            $koneksi.'|'.(string) config('database.connections.'.$koneksi.'.database')
        );

        if (is_file($penanda)) {
            return;
        }

        try {
            $this->jalankanMigrasiSatuPerSatu();

            if (config('database.default') === 'sqlite') {
                $this->seedAkunDefault();
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
                continue;
            }
        }
    }

    /**
     * Akun demo untuk fallback SQLite (data hilang setiap deploy).
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
