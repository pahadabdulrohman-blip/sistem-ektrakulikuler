<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginRouteTest extends TestCase
{
    public function test_login_page_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_login_submission_route_exists(): void
    {
        $response = $this->from('/login')->post('/login', [
            'username' => 'admin',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(302);
    }
}
