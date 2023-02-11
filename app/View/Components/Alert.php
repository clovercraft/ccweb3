<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Alert extends Component
{
    public $message;
    public $type;
    public $show;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $message = '', ?string $type = 'danger')
    {
        if (empty($message)) {
            $message = Session::pull('msg');
        }

        $this->message = $message;
        $this->type = $type;
        $this->show = !empty($message);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
