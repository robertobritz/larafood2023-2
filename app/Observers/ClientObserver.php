<?php

namespace App\Observers;

use App\Models\Client;
use Illuminate\Support\Str;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function creating(Client $client): void
    {
        $client->uuid = Str::uuid();
    }

}
