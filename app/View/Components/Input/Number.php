<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Number extends Component
{
    public $label;
    public $name;
    public $id;
    public $required;
    public $showHelp;
    public $help;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $name, ?bool $required = false, ?string $help = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = "input_number_$name";
        $this->required = $required;
        $this->showHelp = !empty($help);
        $this->help = $help;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.number');
    }
}
