<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DiscordService;
use App\Services\MinecraftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    protected string $viewNamespace = 'pages';

    public function index()
    {
        return $this->render('home');
    }

    public function smp()
    {
        return $this->render('smp');
    }

    public function community()
    {
        return $this->render('community');
    }

    public function registration(DiscordService $discord)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $user = Auth::user();

        $data = [
            'in_guild' => $discord->userInGuild(),
            'minecraft_verified' => !empty($user->mc_verified_at),
            'whitelisted' => !empty($user->whitelisted_at),
            'whitelistEnabled' => $this->isWhitelistEnabled()
        ];
        return $this->render('registration', $data);
    }

    public function profile(MinecraftService $minecraft, DiscordService $discord, ?User $user = null)
    {
        if (empty($user)) {
            $user = Auth::user();
        }

        $player = $minecraft->getPlayer($user->minecraft_id)->get('username');
        $member = $discord->getGuildMembership();

        // format dates
        $member->put('joined_at', $this->makeDisplayDate($member->get('joined_at')));
        $user->created_at = $this->makeDisplayDate($user->created_at);

        return $this->render('profile', [
            'user' => $user,
            'player' => $player,
            'member' => $member,
        ]);
    }
}
