<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DiscordService
{

    private $api = 'https://discord.com/api';
    private $token;
    private $guildId;

    public function __construct()
    {
        if (Session::has('discord_token')) {
            $this->token = Session::get('discord_token');
        }
        $this->guildId = config('services.discord.guild');
    }

    public function userInGuild(): bool
    {
        $response = $this->callApi("/users/@me/guilds");

        if ($response === false) {
            return false;
        }

        return $response->contains('id', '=', $this->guildId);
    }

    private function callApi(string $endpoint, array $params = [])
    {
        if (empty($this->token) || empty($this->guildId)) {
            return false;
        }

        $path = $this->api . $endpoint;

        $response = Http::withToken($this->token)->get($path, $params);

        if ($response->status() >= 300) {
            Log::warning('Discord API call failed', [
                'endpoint' => $path,
                'params' => $params,
                'response' => $response->body()
            ]);
            return false;
        }

        return $response->collect();
    }
}
