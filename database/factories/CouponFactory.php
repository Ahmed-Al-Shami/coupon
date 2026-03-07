<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'place_name' => fake()->company(),
            'place_category' => fake()->randomElement(['restaurant', 'cafe', 'shopping', 'entertainment', 'health', 'other']),
            'place_address' => fake()->address(),
            'latitude' => fake()->latitude(22, 31), // Egypt lat
            'longitude' => fake()->longitude(25, 34), // Egypt lng
            'discount_value' => fake()->numberBetween(5, 50),
            'discount_type' => 'percentage',
            'expiry_date' => now()->addDays(15),
            'coupon_code' => Str::random(10),
            'image_path' => 'coupons/default.jpg',
            'coins_price' => fake()->numberBetween(50, 500),
            'owner_revenue_percentage' => 80, // Default 80%
            'status' => 'active',
            'grace_period_minutes' => 60,
        ];
    }
}
