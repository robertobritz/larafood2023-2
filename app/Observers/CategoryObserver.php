<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
        /**
     * Handle the Category "creating" event.
     */
    public function creating(Category $category): void
    {
        $category->url = Str::of($category->name)->kebab();
        $category->uuid = Str::uuid();
    }

    /**
     * Handle the Category "updating" event.
     */
    public function updating(Category $category): void
    {
        $category->url = Str::of($category->name)->kebab();
    }
}
