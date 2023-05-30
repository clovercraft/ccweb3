<?php

namespace App\Facades;

use App\Services\DiscordService;
use Illuminate\Support\Facades\Facade;

class Discord extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DiscordService::class;
    }
}
