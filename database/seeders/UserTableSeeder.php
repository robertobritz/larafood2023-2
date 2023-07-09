<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();

        $tenant->users()->create([
            'name' => 'Roberto',
            'email' => 'roberto.britz@hotmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
