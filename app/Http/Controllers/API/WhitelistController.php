<?php

namespace App\Http\Controllers\API;

use App\Services\MinecraftService;
use App\Models\User;
use App\Models\ApiRequest;
use Carbon\Carbon;

class WhitelistController extends ApiController
{
    private MinecraftService $minecraft;

    public function __construct(MinecraftService $minecraft)
    {
        $this->minecraft = $minecraft;
    }

    public function getWhitelistUpdate()
    {
        $uuids = $this->getWhitelistedPlayers();
        return $this->smpResponse([
            'count' => count($uuids),
            'players' => $uuids,
        ]);
    }

    public function getFullWhitelist()
    {
        $uuids = $this->getWhitelistedPlayers(true);
        return $this->smpResponse([
            'count' => count($uuids),
            'players' => $uuids
        ]);
    }

    private function getWhitelistedPlayers(?bool $getAll = false): array
    {
        $players = [];

        $query = User::where('status', 'active');

        if (!$getAll) {
            $timestart = $this->getLastWhitelistRequestTime();
            $query = $query->where('created_at', '>', $timestart);
        }

        $users = $query->get();

        foreach ($users as $user) {
            $players[] = $this->minecraft->resolveUsername($user->minecraft_uuid);
        }

        return $players;
    }

    private function getLastWhitelistRequestTime(): Carbon
    {
        $lastRequest = ApiRequest::where('route', 'api.whitelist.updates')
            ->orderBy('id', 'DESC')
            ->first();

        return $lastRequest->created_at;
    }
}
