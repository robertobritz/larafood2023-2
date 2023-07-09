<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Error get All Products.
     */
    public function test_ErrorGetAllProducts(): void
    {
        $tenant = 'fake_value';
        $response = $this->getJson("/api/v1/products?token_company={$tenant}");

        $response->assertStatus(422);
    }

    /**
     *   All Products.
     */
    public function test_GetAllProducts(): void
    {
        $tenant = Tenant::factory()->create();
        $response = $this->getJson("/api/v1/products?token_company={$tenant->uuid}");

        //$response->dump();

        $response->assertStatus(200);
    }

        /**
     * Product Not Found
     */
    public function test_TestNotFoundProduct(): void
    {
        $tenant = Tenant::factory()->create();
        $product = 'fake_value';

        $response = $this->getJson("/api/v1/products/{$product}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

     /**
     *Get Product by Identify
     */
    public function test_GetProductsByIdentify(): void
    {
        $tenant = Tenant::factory()->create();
        $product = Product::factory()->create(
            //['tenant_id' => $tenant->id], Caso tivesse uma validação de produto para empresa
        );

        $response = $this->getJson("/api/v1/products/{$product->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
