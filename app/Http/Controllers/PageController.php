<?php

namespace App\Http\Controllers;

use App\Models\Generic\Profile;
use App\Models\User;
use App\Services\DiscordService;
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

        $data = [
            'in_guild' => $discord->userInGuild(),
        ];
        return $this->render('registration', $data);
    }

    public function profile(?User $user = null)
    {
        if (empty($user)) {
            $user = Auth::user();
        }

        $profile = new Profile($user);

        // format dates
        $user->created_at = $this->makeDisplayDate($user->created_at);

        return $this->render('profile', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }
}
