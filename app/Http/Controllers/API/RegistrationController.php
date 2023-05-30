<?php

namespace App\Http\Controllers\API;

use App\Events\MemberWhitelistActivated;
use App\Facades\Minecraft;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RegistrationController extends ApiController
{
    public function validateMinecraft(Request $request)
    {
        if (!$request->has('username')) {
            return $this->failure("You must provide a username.");
        }

        $username = $request->input('username');

        if (!Minecraft::validateAccount($username)) {
            return $this->failure("Could not verify Minecraft username. Are you sure you've got the right one?");
        }

        $player = Minecraft::getPlayer($username);
        $this->user->minecraft_id = $player->get('raw_id');
        $this->user->mc_verified_at = now();
        $this->user->save();

        return $this->next("registration", "verification");
    }

    public function verification(Request $request)
    {
        if (!$request->has('birthdate') || !$request->has('pronouns')) {
            return $this->failure("You must provide your birthdate and pronouns.");
        }

        $birthdate = $request->input('birthdate');
        $pronouns = $request->input('pronouns');

        if (!$this->verifyAge($birthdate)) {
            return $this->failure("Sorry, you must be 18 or older to join our community.");
        }

        $this->user->birthdate = $birthdate;
        $this->user->pronouns = $pronouns;
        $this->user->status = 'active';
        $this->user->whitelisted_at = now();
        $this->user->save();

        $enabled = $this->isWhitelistEnabled();
        if ($enabled) {
            MemberWhitelistActivated::dispatch($this->user);
        }

        return $this->next("registration", "finished", ['whitelistEnabled' => $enabled]);
    }

    private function verifyAge($birthdate): bool
    {
        $now = now();
        $birth = Carbon::parse($birthdate);
        $diff = $now->diff($birth);
        return $diff->y >= 18;
    }
}
