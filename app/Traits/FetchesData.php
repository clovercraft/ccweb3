<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

trait FetchesData
{

    protected $fd_params;

    protected function setGetParameters(array $params): void
    {
        $this->fd_params = $params;
    }

    protected function get(string $uri, ?string $token = null): Collection
    {
        if ($token !== null) {
            $response = Http::withToken($token)->get($uri, $this->fd_params ?? null);
        } else {
            $response = Http::get($uri, $this->fd_params ?? null);
        }

        return collect([
            'status' => $response->status(),
        ])->merge($response->collect());
    }
}
