<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '01234567890',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'device_name' => 'MobileApp',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'user',
                    'token'
                ]
            ]);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => \Hash::make('Password123!'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'device_name' => 'MobileApp',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => ['token']
            ]);
    }

    public function test_banned_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'banned@example.com',
            'password' => \Hash::make('Password123!'),
            'is_banned' => true,
            'ban_reason' => 'Fraud',
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'banned@example.com',
            'password' => 'Password123!',
            'device_name' => 'MobileApp',
        ]);

        $response->assertStatus(403)
            ->assertJsonPath('success', false);
    }
}
