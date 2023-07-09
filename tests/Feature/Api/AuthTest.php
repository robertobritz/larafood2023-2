<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class AuthTest extends TestCase
{
    /**
     * Test Validation Auth
     */
    public function test_ValidationAuth(): void
    {
        $response = $this->postJson('/api/auth/token');

        $response->assertStatus(422);
    }

    /**
     *Test Auth User Fake
     */
    public function test_AuthClientFake(): void
    {
        $payload = [
            'email' => 'fake@mail.com',
            'password' => '1234567',
            'device_name' => Str::random(10),
        ];
        $response = $this->postJson("/api/auth/token", $payload);

        $response->assertStatus(404)
                    ->assertExactJson([
                        'message' => trans('messages.invalid_credentials')
                    ]);
    }

    /**
     *Test Auth Success Client
     */
    public function test_AuthClientSuccess(): void
    {
        $client = Client::factory()->create();

        $payload = [
            'email' => $client->email,
            'password' => 'password',
            'device_name' => Str::random(10),
        ];

        $response = $this->postJson("/api/auth/token", $payload);
        //$response->dump();

        $response->assertStatus(200)
                    ->assertJsonStructure(['token']);
    }

        /**
     *Error Get Me
     */
    public function test_ErrorGetMe(): void
    {
        $response = $this->getJson("/api/auth/me");
        //$response->dump();

        $response->assertStatus(401);
    }

    /**
     *Get Me
     */
    public function test_GetMe(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;


        $response = $this->getJson('/api/auth/me',[
            'Authorization' => "Bearer {$token}",
        ]);

        //$response->dump();

        $response->assertStatus(200)
                    ->assertExactJson([
                        'data' => [
                            'name' => $client->name,
                            'email' => $client->email,
                        ]
                    ]);
    }

    /**
     *Logout
     */
    public function test_LogOut(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;


        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => "Bearer {$token}",
        ]);

        //$response->dump();

        $response->assertStatus(204);
    }


}
