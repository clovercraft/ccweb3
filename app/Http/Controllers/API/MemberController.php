<?php

namespace App\Http\Controllers\API;

use App\Events\MemberWhitelistActivated;
use App\Events\MemberWhitelistDeactivated;
use App\Events\MemberBanned;
use App\Models\User;

class MemberController extends ApiController
{
    public function activateWhitelist(User $user)
    {
        $user->whitelisted = true;

        if ($user->save()) {
            return $this->success([
                'user' => $user->id
            ]);
            MemberWhitelistActivated::dispatch($user);
        }

        return $this->failure("Failed to save user record.");
    }

    public function deactivateWhitelist(User $user)
    {
        $user->whitelisted = false;

        if ($user->save()) {
            return $this->success([
                'user' => $user->id
            ]);
            MemberWhitelistDeactivated::dispatch($user);
        }

        return $this->failure("Failed to save user record.");
    }

    public function banMember(User $user)
    {
        $user->banned = true;

        if ($user->save()) {
            return $this->success([
                'user' => $user->id
            ]);
            MemberBanned::dispatch($user);
        }

        return $this->failure("Failed to save user record.");
    }
}
