<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserPageTest extends TestCase
{
    /**
     * Test the login page.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/account/login');

        $response->assertStatus(200);
        $response->assertSee('Sign in');
    }

    /**
     * Test the register page.
     */
    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/account/register');

        $response->assertStatus(200);
        $response->assertSee('Sign up');
    }

    /**
     * Test the password reset page.
     */
    public function test_password_reset_page_is_accessible(): void
    {
        $response = $this->get('/account/password-reset/request');

        $response->assertStatus(200);
        $response->assertSee('Forgot password?');
    }

    /**
     * Test the redirection to the login page.
     */
    public function test_root_url_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(301);
        $response->assertRedirect('/account/login');
    }

    /**
     * Test the redirection to the login page when unauthenticated.
     */
    public function test_redirect_unauthenticated_to_login_page(): void
    {
        $response = $this->get('/account');

        $response->assertStatus(302);
        $response->assertRedirect('/account/login');
    }
}
