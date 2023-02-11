<?php

namespace App\View\Components\Extras;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Extras extends Component
{

    public $extras = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Session::has('viewExtras')) {
            $this->extras = Session::pull('viewExtras');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.extras.extras');
    }
}
