<?php

namespace Tests\Api\Feature;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Error Get Categories by tenant.
     */
    public function test_GetTenantError(): void
    {
        $response = $this->getJson('/api/v1/categories');
        //$response->dump();

        $response->assertStatus(422);
    }

     /**
     * Test get categories by Tenant.
     */
    public function test_GetAllCategoryByTenant(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories?token_company={$tenant->uuid}");
        //$response->dump();

        $response->assertStatus(200);
    }

         /**
     * Get Category erro by tenant.
     */
    public function test_ErrorCategoryByTenant(): void
    {
        $category = 'fake_value';
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories/{$category}?token_company={$tenant->uuid}");
        //$response->dump();

        $response->assertStatus(404);
    }

     /**
     * Get Category  by tenant.
     */
    public function test_CategoryByTenant(): void
    {
        $category = Category::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories/{$category->uuid}?token_company={$tenant->uuid}");
        //$response->dump();

        $response->assertStatus(200);
    }
    
}
