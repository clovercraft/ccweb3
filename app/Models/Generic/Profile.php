<?php

namespace App\Models\Generic;

use App\Models\User;
use App\Services\MinecraftService;
use App\Services\DiscordService;

class Profile
{

    public User $user;
    public $member;
    public $player;

    private MinecraftService $minecraft;
    private DiscordService $discord;

    public function __construct(User $user)
    {
        $this->minecraft = new MinecraftService();
        $this->discord = new DiscordService();

        $this->user = $user;

        $this->loadDiscordProfile();
        $this->loadMinecraftProfile();
    }

    private function loadDiscordProfile(): void
    {
        $uuid = $this->user->discord_id;
        $member = $this->discord->getGuildMembership($uuid);
        $this->member = $member->toArray();
    }

    private function loadMinecraftProfile(): void
    {
        if ($this->user->minecraft_id === null) {
            $this->player = null;
            return;
        }

        $player = $this->minecraft->getPlayer($this->user->minecraft_id);
        $this->player = $player->toArray();
    }
}
