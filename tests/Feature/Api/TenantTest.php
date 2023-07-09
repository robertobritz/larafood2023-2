<?php

namespace Tests\Feature\Api;

use App\Models\Tenant;
use Tests\TestCase;

class TenantTest extends TestCase
{
    /**
     * Get all Tenants
     */
    public function test_GetAllTenant(): void
    {

        Tenant::factory()->count(10)->create(); // Utilizar o Create para manter no banco de dados, o make(), não mantem no banco

        $response = $this->getJson('/api/v1/tenants'); // Verifica se a rota funciona
        //$response->dump(); // Serve para mostrar o retorno

        $response->assertStatus(200) // verifica se o retorno da rota deu certo
                    ->assertJsonCount(10, 'data'); // verifica se a array de 10 itens foi criado da maneira correta.
    }

    /**
     * Test Get Error Single Tenant
     */

    public function test_ErrorGetTenant(): void
    {
        $tenant = 'fake_value';
        
        $response = $this->getJson("/api/v1/tenants/{$tenant}"); // Verifica se a rota funciona

        $response->assertStatus(404); //Como é um teste de erro, deve retornar o 404.
                    
    }

        /**
     * Test Get  Single Tenant
     */

     public function test_GetTenantByIdentify(): void
     {
         $tenant = Tenant::factory()->make();
         
         $response = $this->getJson("/api/v1/tenants/{$tenant->uuid}"); // Verifica se a rota funciona
 
         $response->assertStatus(200); // Verifica se encontra a empresa
                     
     }
}
