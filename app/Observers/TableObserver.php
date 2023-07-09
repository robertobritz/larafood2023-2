<?php

namespace App\Observers;

use App\Models\Table;
use Illuminate\Support\Str;

class TableObserver
{
    /**
     * Handle the Table "created" event.
     */
    public function creating(Table $table): void
    {
        $table->uuid = Str::uuid();
    }

}
