<?php

namespace App\View\Components\Common;

use Illuminate\View\Component;

class NavLink extends Component
{
    public $url;
    public $target;
    public $icon;
    public $srtext;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $url, ?string $target = '_self', ?string $icon = '', ?string $srtext = '')
    {
        $this->url = $url;
        $this->target = $target;
        $this->icon = $icon;
        $this->srtext = $srtext;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.common.nav-link');
    }
}
