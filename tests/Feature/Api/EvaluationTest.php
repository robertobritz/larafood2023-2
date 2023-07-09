<?php

namespace Tests\Feature\api;

use App\Models\Client;
use App\Models\Order;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class EvaluationTest extends TestCase
{
    /**
     * Test Error Create New Evaluation
     */
    public function test_ErrorCreateNewEvaluation(): void
    {
        $order = 'fake_value';
        $response = $this->postJson("api/auth/v1/orders/{$order}/evaluations");
        //$response->dump();
        $response->assertStatus(401);
    }

    /**
     * Test  Create New Evaluation
     */
    public function test_CreateNewEvaluation(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;
        
        $order = $client->orders()->save(Order::factory()->make());

        $payload = [
            'stars' => 5,
            'comment' => Str::random(10),
        ];

        $header = [
            'Authorization' => "Bearer {$token}",
        ];

        $response = $this->postJson(
            "api/auth/v1/orders/{$order->identify}/evaluations", 
            $payload,
            $header,
        );
        $response->dump();
        $response->assertStatus(201);
    }
}
