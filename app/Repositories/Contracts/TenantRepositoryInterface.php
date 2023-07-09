<?php

namespace App\Repositories\Contracts;

interface TenantRepositoryInterface
{
    public function getAllTenant(int $per_page);
    public function getTenantByUuid(string $uuid);
}