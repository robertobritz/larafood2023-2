<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class OrderTest extends TestCase
{
    /**
     * Validation create new order
     */
    public function test_ValidationCreateNewOrder(): void
    {
        $payload = [];

        $response = $this->postJson('/api/v1/orders', $payload);
        //$response->dump();

        $response->assertStatus(422)
                    ->assertJsonPath('errors.token_company', [
                        trans('validation.required', ['attribute' => 'token company'])
                    ])
                    ->assertJsonPath('errors.products', [
                        trans('validation.required', ['attribute' => 'products'])
                    ]);
    }
    /**
     * Create new order
     */
    public function test_CreateNewOrder(): void
    {
        $tenant = Tenant::factory()->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => [],
        ];

        $products = Product::factory()->count(10)->create();
        foreach ($products as $product){
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 2,
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);
        //$response->dump();

        $response->assertStatus(201);
    }

    /**
     * Test total order
     */
    public function test_TotalOrder(): void
    {
        $tenant = Tenant::factory()->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => [],
        ];

        $products = Product::factory()->count(2)->create();
        foreach ($products as $product){
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1,
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);
        //$response->dump();

        $response->assertStatus(201)
                    ->assertJsonPath('data.total', 25.8);
    }

    /**
     * Order Not Found
     */
    public function test_OrderNotFound(): void
    {
        $order = 'fake_value';

        $response = $this->getJson("api/v1/orders/{$order}");

        $response->assertStatus(404);
    }

    /**
     * Order Found
     */
    public function test_OrderFound(): void
    {
        $order = Order::factory()->create();

        $response = $this->getJson("api/v1/orders/{$order->identify}");

        $response->assertStatus(200);
    }

        /**
     * Test create new order authenticated
     */
    public function test_CreateNewOrderAuthenticated(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;
        $tenant = Tenant::factory()->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => [],
        ];

        $products = Product::factory()->count(2)->create();
        foreach ($products as $product){
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1,
            ]);
        }

        $response = $this->postJson('/api/auth/v1/orders', $payload,[
            'Authorization' => "Bearer {$token}"
        ]);
        //$response->dump();

        $response->assertStatus(201);
    }
    /**
     * Test create new order whit table
     */
    public function test_CreateNewOrderWithTable(): void
    {
        $table = Table::factory()->create(); 

        $tenant = Tenant::factory()->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'table' => $table->uuid,
            'products' => [],
        ];

        $products = Product::factory()->count(2)->create();
        foreach ($products as $product){
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1,
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);
        //$response->dump();

        $response->assertStatus(201);
    }
    /**
     * Test get my orders
     */
    public function test_GetMyOrders(): void
    {
        $client = Client::factory()->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;
        Order::factory()->count(2)->create(['client_id' => $client->id]); // Serve para criar o Order já definindo qual cliente

        $response = $this->getJson('/api/auth/v1/my-orders', [
            'Authorization' => "Bearer {$token}"
        ]);
        //$response->dump();

        $response->assertStatus(200)
                    ->assertJsonCount(2, 'data');
    }

}
