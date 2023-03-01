<?php

namespace App\Services\Discord;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ApiCall
{

    private string $api_base = 'https://discord.com/api/';

    private string $guildid;
    private string $token;
    private string $token_type = 'BEARER';
    private string $endpoint;
    private array $params = [];

    public static function endpoint(string $path): self
    {
        $call = new self();
        $call->setEndpoint($path);
        return $call;
    }

    public function __construct()
    {
        $this->guildid = config('services.discord.guild');
    }

    public function setEndpoint(string $path): self
    {
        $this->endpoint = $path;
        return $this;
    }

    public function asUser(): self
    {
        if (!Session::has('discord_token')) {
            $e = new Exception("Cannot call Discord API as logged in user without user token");
            throw $e;
        }

        $this->token = Session::get('discord_token');
        $this->token_type = 'Bearer';

        return $this;
    }

    public function asBot(): self
    {
        $this->token = config('services.discord.bot_token');
        $this->token_type = 'Bot';
        return $this;
    }

    public function withParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function post(array $data)
    {
        $this->safetyCheck();
        $path = $this->buildPath();

        $response = $this->request()->post($path, $data);
        return $this->handleResponse($response, $path);
    }

    public function get()
    {
        $this->safetyCheck();
        $path = $this->buildPath();

        $response = $this->request()->get($path, $this->params);
        return $this->handleResponse($response, $path);
    }

    private function safetyCheck(): bool
    {
        if (empty($this->endpoint)) {
            throw new Exception("Must provide endpoint for Discord API call");
        }

        if (empty($this->token)) {
            throw new Exception("Must provide token for Discord API call");
        }

        return true;
    }

    private function buildPath(): string
    {
        return $this->api_base . $this->endpoint;
    }

    private function request()
    {
        return Http::withToken($this->token, $this->token_type);
    }

    private function handleResponse($response, $path)
    {
        if ($response->failed()) {
            Log::warning('Discord API call failed', [
                'endpoint'  => $path,
                'response'  => $response->body()
            ]);
            return false;
        }

        return $response->collect();
    }
}
