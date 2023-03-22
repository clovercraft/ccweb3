<?php

namespace App\View\Components\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MemberCard extends Component
{
    private $member;
    public $uuid;
    public $id;
    public $name;
    public $status;
    public $role;
    public $roleSlug;
    public $avatar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $member)
    {
        $this->member = $member;
        $this->uuid = Str::uuid();
        $this->id = $member->id;
        $this->name = $member->name;
        $this->status = $member->status;
        $this->role = $member->role->displayname;
        $this->roleSlug = $member->role->slug;
        $this->avatar = $this->parseAvatar($member->avatar);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.member-card');
    }

    public function actions(): array
    {
        /** @var User $user */
        $user = Auth::user();

        $actions = [
            'View Profile'      => route('page.member', ['user' => $this->member]),
        ];

        if ($user->can('update', $this->member)) {
            $display = $this->member->whitelisted ? 'Remove Whitelist' : 'Approve Whitelist';
            $url = $this->member->whitelisted
                ? route('api.member.deactivateWhitelist', ['user' => $this->member])
                : route('api.member.activateWhitelist', ['user' => $this->member]);
            $actions[$display] = $url;
        }

        if ($user->can('ban', $this->member)) {
            $actions['Ban User'] = route('api.member.ban', ['user' => $this->member]);
        }

        return $actions;
    }

    private function parseAvatar(?string $url = ''): string
    {
        $alt = asset('img/profile.png');
        if (empty($url) || Http::get($url)->status() !== 200) {
            return $alt;
        }
        return $url;
    }
}
