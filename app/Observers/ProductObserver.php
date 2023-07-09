<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function creating(Product $product): void
    {
        $product->flag = Str::of($product->title)->kebab();
        $product->uuid = Str::uuid();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updating(Product $product): void
    {
        $product->flag = Str::of($product->title)->kebab();
    }
}