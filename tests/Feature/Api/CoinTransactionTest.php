<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CoinPackage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoinTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_balance()
    {
        $user = User::factory()->create(['coins_balance' => 500]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/auth/coins/balance');

        $response->assertStatus(200)
            ->assertJsonPath('data.coins_balance', 500);
    }

    public function test_user_can_topup_request()
    {
        $user = User::factory()->create();
        $package = CoinPackage::create([
            'name' => 'Starter',
            'coins_amount' => 100,
            'price' => 10,
            'currency' => 'EGP',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/auth/coins/topup', [
                'package_id' => $package->id,
                'payment_method' => 'vodafone_cash',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('coin_topups', [
            'user_id' => $user->id,
            'amount_paid' => 10,
        ]);
    }
}
