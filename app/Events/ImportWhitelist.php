<?php

namespace App\Events;

use App\Models\User;
use App\Services\MinecraftService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportWhitelist implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function broadcastOn()
    {
        return new Channel('smp-relay');
    }

    public function broadcastAs()
    {
        return 'importWhitelist';
    }

    public function broadcastWith()
    {
        return [
            'players' => $this->getActivePlayers(),
        ];
    }

    private function getActivePlayers(): array
    {
        $players = [];
        $minecraft = new MinecraftService();
        $users = User::active()->get();
        foreach ($users as $user) {
            $players[] = $minecraft->resolveUsername($user->minecraft_id);
        }
        return $players;
    }
}
