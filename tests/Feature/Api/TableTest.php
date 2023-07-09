<?php

namespace Tests\Api\Feature;

use App\Models\Table;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableTest extends TestCase
{
    /**
     * Error Get Table by tenant.
     */
    public function test_GetTableTenantError(): void
    {
        $response = $this->getJson('/api/v1/tables');
        //$response->dump();

        $response->assertStatus(422);
    }

     /**
     * Test get tables by Tenant.
     */
    public function test_GetAllTablesByTenant(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables?token_company={$tenant->uuid}");
        //$response->dump();

        $response->assertStatus(200);
    }

         /**
     * Get Table erro by tenant.
     */
    public function test_ErrorTableByTenant(): void
    {
        $table = 'fake_value';
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables/{$table}?token_company={$tenant->uuid}");
        //$response->dump();

        $response->assertStatus(404);
    }

     /**
     * Get Table  by tenant.
     */
    public function test_TableByTenant(): void
    {
        $table = Table::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables/{$table->uuid}?token_company={$tenant->uuid}");
        //$response->dump();

        $response->assertStatus(200);
    }
    
}

