<?php

namespace Tests\Feature\Api;

use App\Models\Coupon;
use App\Models\User;
use App\Models\PlatformSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponPurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        PlatformSetting::create(['key' => 'platform_revenue_percentage', 'value' => '20', 'type' => 'int']);
        PlatformSetting::create(['key' => 'grace_period_minutes', 'value' => '60', 'type' => 'int']);
    }

    public function test_user_can_purchase_coupon()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create(['coins_balance' => 1000]);
        $coupon = Coupon::factory()->create([
            'user_id' => $seller->id,
            'coins_price' => 100,
            'status' => 'active',
        ]);

        $response = $this->actingAs($buyer, 'sanctum')
            ->postJson("/api/v1/auth/coupons/{$coupon->id}/purchase");

        $response->assertStatus(200);

        $this->assertEquals(900, $buyer->fresh()->coins_balance);
        $this->assertEquals(80, $seller->fresh()->coins_balance);
    }

    public function test_insufficient_balance_prevents_purchase()
    {
        $buyer = User::factory()->create(['coins_balance' => 50]);
        $coupon = Coupon::factory()->create(['coins_price' => 100]);

        $response = $this->actingAs($buyer, 'sanctum')
            ->postJson("/api/v1/auth/coupons/{$coupon->id}/purchase");

        $response->assertStatus(400);
        $this->assertEquals(50, $buyer->fresh()->coins_balance);
    }
}
