<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\DiscordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    private $statusRoutes = [
        User::STATUS_NEW    => 'page.registration',
        User::STATUS_BANNED => 'page.banned'
    ];

    private $roleRoutes = [
        Role::MEMBER    => 'page.profile',
        Role::STAFF     => 'admin.members.list',
        Role::ADMIN     => 'admin.members.list'
    ];

    private $defaultRoute = 'page.home';

    public function sendToDiscord()
    {
        return Socialite::driver('discord')
            ->scopes(['guilds'])
            ->redirect();
    }

    public function redirect(DiscordService $discordService)
    {
        $discord = Socialite::driver('discord')->user();
        $user = $this->getUser($discord);
        if ($user->discord_joined_at == null) {
            $member = $discordService->getGuildMembership();
            $user->discord_joined_at = $member->get('joined_at');
            $user->save();
        }

        Session::put('discord_token', $discord->token);
        Auth::login($user);

        return $this->getRedirect($user);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('page.home');
    }

    private function getUser($discord): User
    {
        $user = User::where('discord_id', $discord->id)->first();

        if (!empty($user)) {
            return $user;
        }

        // if no user exists, create a new one.
        $user = new User();
        $user->name = $discord->name;
        $user->discord_id = $discord->id;
        $user->minecraft_id = Str::uuid();
        $user->avatar = $discord->avatar;
        $user->status = 'new';

        $role = Role::where('slug', 'member')->first();
        $user->role_id = $role->id;
        $user->save();

        return $user;
    }

    private function getRedirect(User $user): RedirectResponse
    {
        if (Session::has('redirect') && $user->status !== User::STATUS_BANNED) {
            return redirect()->route(Session::pull('redirect'));
        }

        $status = $user->status;
        if (array_key_exists($status, $this->statusRoutes)) {
            return redirect()->route($this->statusRoutes[$status]);
        }

        $role = $user->role->slug;
        if (array_key_exists($role, $this->roleRoutes)) {
            return redirect()->route($this->roleRoutes[$role]);
        }

        return redirect()->route($this->defaultRoute);
    }
}
