<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Services\Discord\ApiCall;
use App\Services\Discord\MessageSearch;
use Illuminate\Support\Facades\Auth;

class DiscordService
{
    private $guildId;

    public function __construct()
    {
        $this->guildId = config('services.discord.guild');
    }

    public function userInGuild(): bool
    {
        $response = ApiCall::endpoint("users/@me/guilds")
            ->asUser()
            ->get();

        if (!$response) {
            return $response;
        }

        return $response->contains('id', '=', $this->guildId);
    }

    public function getGuildMembership(): ?Collection
    {
        $path = sprintf("users/@me/guilds/%s/member", $this->guildId);
        $response = ApiCall::endpoint($path)
            ->asUser()
            ->get();

        if (!$response) {
            return null;
        }

        return $response;
    }

    public function getUserIntro()
    {
        $channel = config('services.discord.intro_channel');
        $user = Auth::user();
        $author = $user->discord_id;
        $query = new MessageSearch($channel, $author);
        return $query->search();
    }

    public function sendUserVerified(User $user)
    {
        $content = "<@" . $user->discord_id . "> has completed web verification, and is now whitelisted.";
        $channel = config('services.discord.whitelist_channel');
        ApiCall::endpoint(sprintf("channels/%s/messages", $channel))
            ->asBot()
            ->post([
                'content' => $content
            ]);
    }

    public function getGuildRoles(): ?Collection
    {
        $response = ApiCall::endpoint(sprintf("guilds/%s/roles", $this->guildId))
            ->asBot()
            ->get();

        if ($response === false) {
            return null;
        }
        return $response;
    }
}
