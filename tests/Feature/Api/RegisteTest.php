<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisteTest extends TestCase
{
    /**
     * Error create new Client.
     */
    public function test_ErrorCreateNewClient(): void
    {
        //Client::truncate();

        $payload = [
            'name' => 'betinho',
            'email' => 'beto@client.com.br'
        ];

        $response = $this->postJson('/api/auth/register', $payload);
        //$response->dump();

        $response->assertStatus(422)
        ->assertExactJson([
            'message'=> 'The password field is required.',
            'errors' => [
                'password' => [trans('validation.required', ['attribute' => 'password'])
                ]
            ]
        ]);
    }

    /**
     * Success Create new Client.
     */
    public function test_SuccessCreateNewClient(): void
    {
        //Client::truncate();

        $payload = [
            'name' => 'betinho',
            'email' => 'beto@client.com.br',
            'password' => '123456'
        ];

        $response = $this->postJson('/api/auth/register', $payload);
        //$response->dump();

        $response->assertStatus(201)
                    ->assertExactJson([
                        'data' => [
                            'name' => $payload['name'],
                            'email' => $payload['email'],
                        ]
                    ]);
    }
}
