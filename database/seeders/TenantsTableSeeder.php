<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan = Plan::first();

        $plan->tenants()->create([
           'cnpj' => '13482706000120',
           'name' => 'Roberto Ti',
           'url' => 'robertoti',
           'email' => 'roberto.britz@hotmail.com',
        ]);
    }
}
