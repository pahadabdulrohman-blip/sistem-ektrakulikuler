<?php

namespace Tests\Feature;

use Tests\TestCase;

class CsrfProtectionTest extends TestCase
{
    public function test_post_without_csrf_token_is_rejected(): void
    {
        // Login sebagai admin melalui session
        $this->withSession([
            'login' => true,
            'role' => 'admin',
        ]);

        // Kirim POST tanpa token CSRF
        $response = $this->withMiddleware()
            ->post('/admin/ekstrakurikuler', [
                'nama' => 'Badminton',
                'deskripsi' => 'Kegiatan olahraga badminton',
            ]);

        // Harus ditolak oleh perlindungan CSRF
        $response->assertStatus(419);
    }
}
