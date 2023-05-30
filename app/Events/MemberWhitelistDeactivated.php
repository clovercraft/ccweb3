<?php

namespace App\Events;

use App\Models\User;
use App\Facades\Minecraft;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberWhitelistDeactivated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('smp-relay');
    }

    public function broadcastAs()
    {
        return 'deactivateWhitelist';
    }

    public function broadcastWith()
    {
        $player = Minecraft::getPlayer($this->user->minecraft_id);
        return [
            'username' => $player->get('username')
        ];
    }
}
