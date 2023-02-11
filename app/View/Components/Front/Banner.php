<?php

namespace App\View\Components\Front;

use App\Traits\HasStyle;
use Illuminate\View\Component;

class Banner extends Component
{

    use HasStyle;

    public $image;
    public $color;
    public $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($image = '', $color = '#202225', $link = '')
    {
        $this->image = $image;
        $this->color = $this->hexToRgb($color);
        $this->link = $link;
        $this->makeStyles([
            'background' => [
                sprintf("box-shadow: -3px -12px 76px 18px rgba(%s,0.75) inset;",  $this->color),
                sprintf("background-image:url('%s');", $this->image)
            ],
            'overlay' => [
                sprintf("background: rgb(%s);", $this->color)
            ]
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.front.banner');
    }
}
