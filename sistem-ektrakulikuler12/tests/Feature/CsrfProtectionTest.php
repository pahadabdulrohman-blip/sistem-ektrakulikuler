<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class CsrfProtectionTest extends TestCase
{
    /**
     * Laravel sengaja melewati pengecekan CSRF saat berjalan di test.
     * Middleware dipaksa aktif di sini agar perilakunya sama seperti produksi.
     */
    public function test_post_without_csrf_token_is_rejected(): void
    {
        $this->app->instance(ValidateCsrfToken::class, new class($this->app, $this->app['encrypter']) extends ValidateCsrfToken
        {
            protected function runningUnitTests(): bool
            {
                return false;
            }
        });

        $this->withSession([
            'login' => true,
            'username' => 'admin',
            'role' => 'admin',
        ]);

        $this->post('/admin/ekstrakurikuler', [
            'nama' => 'Badminton CSRF Test '.uniqid(),
            'deskripsi' => 'Uji perlindungan CSRF.',
        ])->assertStatus(419);
    }
}
