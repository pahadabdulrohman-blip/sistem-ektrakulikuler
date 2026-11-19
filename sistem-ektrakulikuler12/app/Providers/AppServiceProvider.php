
private function siapkanDatabaseFallback(): void
{
    // SQLite fallback hanya digunakan di production.
    // Development lokal tetap menggunakan MySQL dari .env.
    if (! $this->app->environment('production')) {
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

    $berkas = $folder . DIRECTORY_SEPARATOR . 'fallback.sqlite';

    config([
        'database.default' => 'sqlite',
        'database.connections.sqlite.database' => $berkas,
    ]);

    @mkdir(dirname($berkas), 0755, true);

    if (! is_file($berkas)) {
        @touch($berkas);
    }
}
