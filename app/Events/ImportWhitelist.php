<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportWhitelist implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $players = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $players)
    {
        $this->players = $players;
    }

    public function broadcastOn()
    {
        return new Channel('smp-relay');
    }

    public function broadcastAs()
    {
        return 'importWhitelist';
    }
}
