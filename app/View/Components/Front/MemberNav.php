<?php

namespace App\View\Components\Front;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class MemberNav extends Component
{

    public $display = false;
    public $links;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->prepareLinks();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.front.member-nav');
    }

    private function prepareLinks()
    {
        if (!Auth::check()) {
            return;
        }
        $this->display = true;

        $availableRoutes = [
            'member' => [
                'page.profile' => 'Profile'
            ],
            'admin' => [
                'page.profile'  => 'Profile',
                'admin.members.list' => 'Members',
                'admin.settings' => 'Settings',
            ]
        ];

        $user = Auth::user();
        if (array_key_exists($user->role->slug, $availableRoutes)) {
            $this->links = $availableRoutes[$user->role->slug];
        }
    }
}
