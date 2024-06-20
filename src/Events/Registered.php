<?php

namespace Geekpack\Api\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Geekpack\Api\Models\User;

class Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
