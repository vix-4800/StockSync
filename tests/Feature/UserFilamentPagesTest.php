<?php

namespace Tests\Feature;

use App\Filament\Account\Pages\NetProfit;
use App\Filament\Account\Pages\TelegramTokens;
use App\Filament\Account\Resources\DeepLinkResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Tests\TestCase;

class UserFilamentPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorize();
    }

    /**
     * Authorize the user.
     */
    protected function authorize(): void
    {
        $user = User::factory()->create([
            'is_blocked' => false,
            'team_id' => null,
        ]);

        $this->actingAs($user);
    }

    /**
     * Test that the user dashboard is accessible.
     */
    public function test_user_dashboard_is_accessible(): void
    {
        $response = $this->get('/account');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /**
     * Test that the user deep link page is accessible.
     */
    public function test_user_deep_link_page_is_accessible(): void
    {
        $response = $this->get(DeepLinkResource::getUrl('index'));

        $response->assertStatus(200);
        $response->assertSee('Deep Links');
    }

    /**
     * Test that the user net profit page is not accessible without a team.
     */
    public function test_user_net_profit_page_is_unaccessible_without_a_team(): void
    {
        $response = $this->get(NetProfit::getUrl());

        $response->assertStatus(403);
    }

    /**
     * Test that the user telegram tokens page is accessible.
     */
    public function test_user_telegram_tokens_page_is_accessible(): void
    {
        $response = $this->get(TelegramTokens::getUrl());

        $response->assertStatus(200);
        $response->assertSee('Telegram Tokens');
    }

    /**
     * Test that the user settings page is accessible.
     */
    public function test_user_settings_page_is_accessible(): void
    {
        $response = $this->get('/account'.FilamentEditProfilePlugin::get()->getSlug());

        $response->assertStatus(200);
        $response->assertSee('Edit Profile');
    }
}
