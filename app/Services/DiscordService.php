<?php

namespace App\Services;

use App\Models\Settlement as Settlement;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Services\Discord\ApiCall;
use App\Services\Discord\MessageSearch;
use App\Facades\Minecraft;
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
        $this->sendWhitelistLog($user);
        $this->sendWhitelistNotice($user);
    }

    private function sendWhitelistNotice(User $user): void
    {
        $options = collect([
            "Congrats, {member}, you've been whitelisted. Happy building!",
            "Oh snap, {member} just got whitelisted!",
            "Slay! {member} you've been whitelisted!",
            "Greetings, {member}, you've been whitelisted. Safe travels!",
            "Praise Goose! {member} has been whitelisted on the server!",
            "What's up {member}? You just got whitelisted. Glory to Snoose!",
            "{member} has been whitelisted! Go forth and craft thy mines!"
        ]);
        $template = $options->random();
        $memberTag = "<@" . $user->discord_id . ">";

        $message = str_replace("{member}", $memberTag, $template);
        $channel = config('services.discord.whitelist_channel');
        $this->sendDiscordMessage($channel, $message);
    }

    private function sendWhitelistLog(User $user): void
    {
        $igname = Minecraft::resolveUsername($user->minecraft_id);

        $message = "<@" . $user->discord_id . "> has completed web verification, and is now whitelisted as `" . $igname . "`.";
        $channel = config('services.discord.log_channel');
        $this->sendDiscordMessage($channel, $message);
    }

    private function sendDiscordMessage(string $channel, string $message): void
    {
        ApiCall::endpoint(sprintf("channels/%s/messages", $channel))
            ->asBot()
            ->post([
                'content' => $message
            ]);
    }

    public function setMemberSettlement(User $user, Settlement $settlement)
    {
        $role_id = $settlement->discord_role_id;
        $member_id = $user->discord_id;
        ApiCall::endpoint(sprintf("guilds/%s/members/%s/roles/%s", $this->guildId, $member_id, $role_id))
            ->asBot()
            ->put();
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
