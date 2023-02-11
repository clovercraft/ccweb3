<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $name;
    public $id;
    public $required;
    public $showHelp;
    public $help;
    public $options;
    public $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $name, array $options, ?string $selected = '', ?bool $required = false, ?string $help = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->id = "input_text_$name";
        $this->required = $required;
        $this->showHelp = !empty($help);
        $this->help = $help;

        if (empty($this->selected)) {
            $this->options = array_merge([
                'none' => '--'
            ], $this->options);
            $this->selected = 'none';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.select');
    }
}
