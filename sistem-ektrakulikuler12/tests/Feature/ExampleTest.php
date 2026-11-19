<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Halaman awal memang mengarahkan pengunjung ke halaman login.
     */
    public function test_the_application_redirects_guest_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');

        $this->get('/login')->assertOk();
    }
}
