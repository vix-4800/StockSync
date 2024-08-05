<?php

namespace Tests\Feature\Filament\Admin;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test the admin login page.
     */
    public function test_admin_login_page_is_accessible(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Sign in');
    }

    /**
     * Test the admin register page.
     */
    public function test_admin_register_page_is_disabled(): void
    {
        $response = $this->get('/admin/register');

        $response->assertStatus(404);
    }

    /**
     * Test the redirection to the admin login page when unauthenticated.
     */
    public function test_redirect_unauthenticated_to_admin_login_page(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
    }
}
