<?php

namespace App\View\Components\Input;

use App\Models\Generic\FilterButtonData;
use Illuminate\View\Component;

class FilterButton extends Component
{

    public string $id;
    public string $label;
    public array $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(FilterButtonData $dataObject)
    {
        $this->hydrateFromData($dataObject);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.filter-button');
    }

    private function hydrateFromData(FilterButtonData $data): void
    {
        $this->id = $data->id;
        $this->label = $data->label;
        $this->options = $data->options;
    }
}
