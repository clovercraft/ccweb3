<?php

namespace App\Facades;

use App\Services\MinecraftService;
use Illuminate\Support\Facades\Facade;

class Minecraft extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MinecraftService::class;
    }
}
