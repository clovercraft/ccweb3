<?php

namespace App\Http\Controllers;

use App\Events\MemberWhitelistActivated;
use App\Models\User;
use App\Services\DiscordService;
use App\Services\MinecraftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidationController extends Controller
{

    public function profile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $birthdate = $request->get('birthdate');
        $pronouns = $request->get('pronouns');

        if (empty($birthdate) || empty($pronouns)) {
            return redirect()
                ->with('error', 'You must provide both your birth date and pronouns.')
                ->route('page.registration');
        }

        $user->birthdate = $birthdate;
        $user->pronouns = $pronouns;
        $user->save();
        return redirect()->route('page.profile');
    }

    public function minecraft(Request $request, MinecraftService $minecraft)
    {
        /** @var User $user */
        $user = Auth::user();

        $username = $request->get('minecraft_id');
        if (!$minecraft->validateAccount($username)) {
            return redirect()
                ->with('minecraft_id_error', 'Sorry, we could not validate that Minecraft account name.')
                ->route('page.profile');
        }

        $player = $minecraft->getPlayer($username);
        $user->minecraft_id = $player->get('raw_id');
        $user->mc_verified_at = now();
        $user->save();

        $this->checkWhitelistEligible($user);

        return redirect()->route('page.profile');
    }

    public function intro(DiscordService $discord)
    {
        /** @var User $user */
        $user = Auth::user();

        $message = $discord->getUserIntro($user->discord_id);

        if ($message === false) {
            return redirect()
                ->with('intro_error', 'Sorry, we could not find an introduction message for your Discord user.')
                ->route('page.profile');
        }

        $user->intro_verified = true;
        $user->intro_message_id = $message['id'];
        $user->save();

        $this->checkWhitelistEligible($user);

        return redirect()->route('page.profile');
    }

    public function forceIntro(User $user)
    {
        $user->intro_verified = true;
        $user->save();

        $this->checkWhitelistEligible($user);

        return redirect()->route('page.member', ['user' => $user]);
    }

    private function checkWhitelistEligible($user)
    {
        if ($user->status === User::STATUS_ACTIVE) {
            return true;
        }

        if (empty($user->mc_verified_at) || $user->intro_verified === false || empty($user->birthdate) || empty($user->pronouns)) {
            return false;
        }

        $user->status = User::STATUS_ACTIVE;
        $user->whitelisted_at = now();
        $user->save();
        MemberWhitelistActivated::dispatch($user);
        $discord = new DiscordService();
        $discord->sendUserVerified($user);
    }
}
