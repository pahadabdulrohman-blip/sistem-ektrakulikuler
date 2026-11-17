<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KeamananDasarTest extends TestCase
{
    public function test_header_keamanan_terpasang(): void
    {
        $this->get('/login')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_registrasi_dibatasi_rate_limit(): void
    {
        // Enam percobaan pertama masih diproses (gagal validasi -> redirect).
        for ($i = 0; $i < 6; $i++) {
            $this->post(route('register.store'), [])->assertStatus(302);
        }

        // Percobaan ketujuh diblokir sementara.
        $this->post(route('register.store'), [])->assertStatus(429);
    }

    public function test_foto_profil_tidak_bisa_diakses_tanpa_login(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('foto-profil/uji.jpg', 'isi-gambar');

        $this->get(route('profil.foto', 'uji.jpg'))
            ->assertRedirect(route('login'));
    }

    public function test_foto_profil_bisa_diakses_setelah_login(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('foto-profil/uji.jpg', 'isi-gambar');

        $this->withSession([
            'login' => true,
            'role' => 'guru',
            'username' => 'guru_uji_foto',
        ])->get(route('profil.foto', 'uji.jpg'))
            ->assertOk();
    }
}
