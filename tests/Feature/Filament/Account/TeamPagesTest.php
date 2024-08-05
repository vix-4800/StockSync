<?php

namespace Tests\Feature\Filament\Account;

use App\Enums\UserRole;
use App\Filament\Account\Pages\NetProfit;
use App\Filament\Account\Pages\Reviews;
use App\Filament\Account\Pages\SKUPlanner;
use App\Filament\Account\Pages\StickerPrint;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamPagesTest extends TestCase
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
            'team_id' => Team::factory()->create()->id,
            'role' => UserRole::USER->value,
        ]);

        $this->actingAs($user);
    }

    /**
     * Test that the sticker print page is accessible without a team.
     */
    public function test_sticker_print_page_is_accessible_with_a_team(): void
    {
        $response = $this->get('/account'.StickerPrint::getUrl());

        $response->assertStatus(200);
    }

    /**
     * Test that the user net profit page is accessible without a team.
     */
    public function test_net_profit_page_is_accessible_with_a_team(): void
    {
        $response = $this->get(NetProfit::getUrl());

        $response->assertStatus(200);
    }

    /**
     * Test that the reviews page is accessible without a team.
     */
    public function test_reviews_page_is_accessible_with_a_team(): void
    {
        $response = $this->get(Reviews::getUrl());

        $response->assertStatus(200);
    }

    /**
     * Test that the sku planner page is accessible without a team.
     */
    public function test_sku_planner_page_is_accessible_with_a_team(): void
    {
        $response = $this->get(SKUPlanner::getUrl());

        $response->assertStatus(200);
    }
}
