<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class MinecraftService
{
    private const PLAYER_API = 'https://playerdb.co/api/player/minecraft/';
    private const SERVER_API = 'https://api.mcsrvstat.us/2/';

    private $serverip;
    private $denizenSecret;

    private $server;
    private $player;

    public function __construct()
    {
        $this->serverip = config('services.minecraft.serverip');
        $this->denizenSecret = config('services.minecraft.denizen_secret');
    }

    /**
     * Loads the currently configured player and validates their account exists.
     *
     *
     * @return bool true on success false on failure
     */
    public function validateAccount(string $username): bool
    {
        return $this->loadPlayer($username);
    }

    public function getPlayer(string $username): Collection
    {
        $this->loadPlayer($username);
        return $this->player;
    }

    public function resolveUsername(string $uuid): string
    {
        $this->loadPlayer($uuid);
        return $this->player->get('username');
    }

    /**
     * Get player details from playerDB API
     *
     * RESPONSE SCHEMA
     * meta
     *   cached_at (time)
     * username (string)
     * id (string)
     * raw_id (string)
     * avatar (string)
     *
     * @return boolean true on success, false on failure
     */
    private function loadPlayer(?string $username = ''): bool
    {
        $response = Http::get(static::PLAYER_API . $username);

        if ($response->status() !== 200) {
            return false;
        }

        $body = $response->collect();

        if ($body->get('code') !== "player.found") {
            return false;
        }

        $playerArr = $body->get('data')['player'];
        $this->player = collect($playerArr);

        return true;
    }

    /**
     * Get a collection of keyed URLs for the various minecraft skin assets for the current user
     *
     * @param integer|null $size
     * @param integer|null $scale
     * @param boolean|null $overlay
     * @param string|null $default
     * @return mixed
     */
    public function getPlayerAssets(?int $size = 64, ?int $scale = 5, ?bool $overlay = true, ?string $default = 'MHF_Steve'): mixed
    {
        if (empty($this->player)) {
            return false;
        }

        $options = [
            'uuid'      => $this->player->get('raw_id'),
            'default'   => $default,
            'size'      => $size <= 512 ? $size : 512,
            'scale'     => $scale <= 10 ? $scale : 10,
            'overlay'   => $overlay
        ];

        $paths = collect([
            'avatar' => 'https://crafatar.com/avatars/%s',
            'head'   => 'https://crafatar.com/renders/head/%s',
            'body'   => 'https://crafatar.com/renders/body/%s',
            'skin'   => 'https://crafatar.com/skins/%s',
            'capes'  => 'https://crafatar.com/capes/%s'
        ]);

        return $paths->mapWithKeys(function ($url, $key) use ($options) {

            $config = [
                'default' => $options['default']
            ];

            if ($key === 'avatar') {
                $config['size'] = $options['size'];
            }

            if (in_array($key, ['body', 'skin'])) {
                $config['scale'] = $options['scale'];
            }

            if ($options['overlay']) {
                $config['overlay'] = 'true';
            }

            $parameters = '';
            foreach ($config as $param => $val) {
                if (strlen($parameters) === 0) {
                    $parameters = "?$param=$val";
                } else {
                    $parameters .= "&$param=$val";
                }
            }

            $url .= $options['uuid'] . $parameters;


            return [$key => $url];
        });
    }

    /**
     * Query the server data object by property
     *
     * Properties are dot separated and follow the schema defined below.
     * Server data object:
     *  - ip: string
     *  - port: integer
     *  - debug
     *      - ping: boolean
     *      - query: boolean
     *      - srv: boolean
     *      - querymismatch: boolean
     *      - ipinsrv: boolean
     *      - cnameinsrv: boolean
     *      - animatedmotd: boolean
     *      - cachetime: integer
     *      - apiversion: integer
     *      - dns: array
     *  - motd
     *      - raw: array :: MC format codes, one entry per line
     *      - clean: array :: Text only, one entry per line
     *      - html: array :: HTML markup with format, one entry per line
     *  - players
     *      - online: integer
     *      - max: integer
     *      - list: array :: online players by name
     *      - uuid: array :: online players by name => uuid
     *  - version: string
     *  - online: boolean
     *  - protocol: integer
     *  - hostname: string
     *  - icon: string :: data source format
     *  - software: string
     *
     * @param string|null $property
     * @return mixed
     */
    public function queryServer(?string $property = 'online'): mixed
    {
        if ($this->getServerData() === false) {
            return false;
        }

        if (str_contains($property, '.')) {
            $properties = explode(".", $property);
        } else {
            $properties = [$property];
        }

        $data = null;
        foreach ($properties as $prop) {
            if (is_array($data) && key_exists($prop, $data)) {
                $data = $data[$prop];
            } else {
                $data = $this->server->get($prop);
            }
        }

        return $data;
    }

    /**
     * Get the server information object from the API
     *
     * @param boolean|null $force whether or not to force a refresh of data
     * @return boolean true on success false on failure
     */
    private function getServerData(?bool $force = false): bool
    {
        if (isset($this->server) && !$force) {
            return true;
        }

        $this->server = null;

        $path = static::SERVER_API;
        $serverip = $this->serverip;
        $url = $path . $serverip;
        $response = Http::get($url);

        if ($response->status() !== 200) {
            return false;
        }

        $this->server = $response->collect();
        return true;
    }
}
